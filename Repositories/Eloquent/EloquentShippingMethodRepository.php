<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Illuminate\Http\Request;
use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Icommerce\Support\Cart as cartSupport;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class EloquentShippingMethodRepository extends EloquentCrudRepository implements ShippingMethodRepository
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
  
  /**
   *
   * @param $data
   * @return Response
   */
  
  public function getCalculations($data, $params)
  {
    
    /* Init query */
    $query = $this->model->query();
    
    /* Check actives */
    $query->where("status", 1);
    
    /* Filters */
    if (isset($params->filter) && $params->filter) {
      $filter = $params->filter;
      
      if (isset($filter->geozones)) {
        $query->whereIn("geozone_id", $filter->geozones);
      }
    }
    
    // Params to get Shipping Methods
    $params = [
      "filter" => [
        "status" => 1
      ]
    ];
    $methods = $this->getItemsBy(json_decode(json_encode($params)));
    
    
    if (isset($methods) && $methods->count() > 0) {
      // Search Cart
      $cartRepository = app('Modules\Icommerce\Repositories\CartRepository');
      
      if (isset($data['cart_id'])) {
        $cart = $cartRepository->getItem($data['cart_id']);
        
        // Fix data cart products
        $supportCart = new cartSupport();
        $dataCart = $supportCart->fixProductsAndTotal($cart);
        // Add products to request
        $data['products'] = $dataCart['products'];
      }
      foreach ($methods as $key => $method) {
        try {
          $data["methodId"] = $method->id;
          $results = app($method->options->init)->init(new Request ($data));
          $resultData = $results->getData();
          $method->calculations = $resultData;
        } catch (\Exception $e) {
          $resultData["msj"] = "error";
          $resultData["items"] = $e->getMessage();
          $method->calculations = $resultData;
        }
      }
    }
    return $methods;
  }
  
  public function validateTenantWithCentralData($query)
  {
    $entitiesWithCentralData = json_decode(setting("icommerce::tenantWithCentralData", null, "[]"));
    $tenantWithCentralData = in_array("shippingMethods", $entitiesWithCentralData);
    
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
}
