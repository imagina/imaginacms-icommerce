<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class EloquentPaymentMethodRepository extends EloquentCrudRepository implements PaymentMethodRepository
{
  /**
   * Filter names to replace
   * @var array
   */
  protected $replaceFilters = [];

  /**
   * Relation names to replace
   * @var array
   */
  protected $replaceSyncModelRelations = [];

  /**
   * Filter query
   *
   * @param $query
   * @param $filter
   * @param $params
   * @return mixed
   */
  public function filterQuery($query, $filter, $params)
  {

    /**
     * Note: Add filter name to replaceFilters attribute before replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */

    $this->validateTenantWithCentralData($query);

    if (isset($filter->search)) {
      //find search in columns
      $query->where('id', 'like', '%' . $filter->search . '%')
        ->orWhere('payment_code', 'like', '%' . $filter->search . '%')
        ->orWhere('name', 'like', '%' . $filter->search . '%');
    }


    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {

    } else {
      //pre-filter status
      $query->where("status", 1);

    }

    //Response
    return $query;
  }

  /**
   * Method to sync Model Relations
   *
   * @param $model ,$data
   * @return $model
   */
  public function syncModelRelations($model, $data)
  {
    //Get model relations data from attribute of model
    $modelRelationsData = ($model->modelRelations ?? []);

    /**
     * Note: Add relation name to replaceSyncModelRelations attribute before replace it
     *
     * Example to sync relations
     * if (array_key_exists(<relationName>, $data)){
     *    $model->setRelation(<relationName>, $model-><relationName>()->sync($data[<relationName>]));
     * }
     *
     */

    //Response
    return $model;
  }

  private function validateTenantWithCentralData($query)
  {

    $entitiesWithCentralData = json_decode(setting("icommerce::tenantWithCentralData", null, "[]"));
    $tenantWithCentralData = in_array("paymentMethods", $entitiesWithCentralData);


    if ($tenantWithCentralData && isset(tenant()->id)) {
      $model = $this->model;

      $query->withoutTenancy();
      $query->where(function ($query) use ($model) {
        $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
          ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
      });
    }else{
      // Validation like DEEV
      // When user is going to pay the plan in central checkout
      if( config("tenancy.mode")!=NULL && config("tenancy.mode")=="singleDatabase" && is_null(tenant()))
        $query->where("organization_id",null);
    }

  }

  public function getCalculations($params){

    $items = [];

    if (isset($params->filter->withCalculations)) {
      $filter = $params->filter;//Short data filter
      $items = $this->getItemsBy($params);

      if (isset($items) && $items->count() > 0) {
        $data = [];

        if (isset($filter->cartId)) {
          // Add products to request
          $data['cartId'] = $filter->cartId;
          // Add extra params
          if (isset($params->extra))
            $data['extra'] = $params->extra;
        }

        //Helper to get current currency
        $currentCurrency = currentCurrency();

        foreach ($items as $key => $method) {

          //Process to validate method currencies
          $methodDeleted = false;
          if(isset($filter->validateCurrency)){

            /* If the field is not configured yet,
            the method will be displayed for all */
            if(isset($method->options->showInCurrencies)){
              $currencies = $method->options->showInCurrencies;

              if(!in_array($currentCurrency->code, $currencies)){
                unset($items[$key]);
                $methodDeleted = true;
              }
            }
          }

          if($methodDeleted==false){
            //Process to calculation validation in each method
            $methodApiController = app($method->options->init);

            if (method_exists($methodApiController, "calculations")) {
              try {

                $results = $methodApiController->calculations(new Request ($data));
                $resultData = $results->getData();
                $method->calculations = $resultData;
              } catch (\Exception $e) {

                $resultData["msj"] = "error";
                $resultData["items"] = $e->getMessage();
                $method->calculations = $resultData;
              }
            }
          }
        }
      }
    }

    return $items;
  }
}
