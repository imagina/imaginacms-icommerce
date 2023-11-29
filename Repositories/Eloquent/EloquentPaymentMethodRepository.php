<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Support\Cart as cartSupport;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Illuminate\Http\Request;

use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class EloquentPaymentMethodRepository extends EloquentBaseRepository implements PaymentMethodRepository
{
  public function getItemsBy($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    // RELATIONSHIPS
    $defaultInclude = [];
    $query->with(array_merge($defaultInclude, $params->include ?? []));
    
    $this->validateTenantWithCentralData($query);
    
    // FILTERS
    if ($params->filter) {
      $filter = $params->filter;
      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where('id', 'like', '%' . $filter->search . '%')
          ->orWhere('payment_code', 'like', '%' . $filter->search . '%')
          ->orWhere('name', 'like', '%' . $filter->search . '%');
      }
      
      if (isset($filter->store)) {
        $query->where('store_id', $filter->store);
      }
      
      if (isset($filter->geozones)) {
        $query->whereIn('geozone_id', $filter->geozones);
      }
      
      if (isset($filter->active)) {
        $query->where('active', $filter->active);
      }
      
      if (isset($filter->status)) {
        $query->where('status', $filter->status);
      }
      
      if (isset($filter->payout)) {
        $query->where('payout', $filter->payout);
      }
      
      if (isset($filter->withCalculations)) {
        
        $query->where('status', 1);
        /* Init query */
        $items = $query->get();
        
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
        return $items;
      }
    }
    
    
    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {
    
    } else {
      //pre-filter status
      $query->where("status", 1);
      
    }
    
    
    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);
    
    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take);
    } else {
      (isset($params->take) && $params->take) ? $query->take($params->take) : false;//Take
      return $query->get();
    }
  }
  
  
  public function getItem($criteria, $params = false)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    //Check field name to criteria
    if (isset($params->filter->field)) $query->where($params->filter->field, $criteria);
    
    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;
      
      if (isset($filter->field))//Filter by specific field
        $field = $filter->field;
    }
    
    // RELATIONSHIPS
    $includeDefault = [];
    $query->with(array_merge($includeDefault, $params->include ?? []));
  
    $this->validateTenantWithCentralData($query);
    
    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);
    
    /*== REQUEST ==*/
    return $query->where($field ?? 'id', $criteria)->first();
    
  }
  
  public function create($data)
  {
    
    $paymentMethod = $this->model->create($data);
    
    event(new CreateMedia($paymentMethod, $data));
    
    return $paymentMethod;
  }
  
  public function update($model, $data)
  {
    
    $model->update($data);
    
    //event(new UpdateMedia($model, $data));
    
    return $model;
    
  }
  
  public function updateBy($criteria, $data, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();
    
    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;
      
      //Update by field
      if (isset($filter->field))
        $field = $filter->field;
    }
    
    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();
    
    if (isset($model->id)) {
      $model->update((array)$data);
      event(new UpdateMedia($model, $data));
      return $model;
    } else {
      return false;
    }
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
  
}
