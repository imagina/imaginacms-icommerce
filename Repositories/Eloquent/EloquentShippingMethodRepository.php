<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

use Illuminate\Http\Request;

//Support
use Modules\Icommerce\Support\Cart as cartSupport;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class EloquentShippingMethodRepository extends EloquentBaseRepository implements ShippingMethodRepository
{
  
  public function getItemsBy($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    // RELATIONSHIPS
    $defaultInclude = [];
    $query->with(array_merge($defaultInclude, $params->include ?? []));
    
    // FILTERS
    if ($params->filter) {
      $filter = $params->filter;
      
      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where('id', 'like', '%' . $filter->search . '%')
          ->orWhere('name', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
      }
      //add filter by status
      if (isset($filter->status)) {
        //find search in columns
        $query->where('status', $filter->status);
        
      }
      
    }
    
    if (isset($this->model->tenantWithCentralData) && $this->model->tenantWithCentralData && isset(tenant()->id)) {
      $model = $this->model;
      
      $query->withoutTenancy();
      $query->where(function ($query) use ($model) {
        $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
          ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
      });
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
    //Initialize query
    $query = $this->model->query();
    
    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = [];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include ?? []);
      $query->with($includeDefault);//Add Relationships to query
    }
    
    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;
      
      if (isset($filter->field))//Filter by specific field
        $field = $filter->field;
    }
    
    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);
    
    /*== REQUEST ==*/
    return $query->where($field ?? 'id', $criteria)->first();
  }
  
  
  public function create($data)
  {
    
    $shippingMethod = $this->model->create($data);
    event(new CreateMedia($shippingMethod, $data));
    return $shippingMethod;
    
  }
  
  public function update($model, $data)
  {
    
    $model->update($data);
    
    event(new UpdateMedia($model, $data));
    
    return $model;
    
  }
  
  
  /**
   *
   * @param $request
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
    
    /* Run query*/
    $methods = $query->get();
    
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
  
}
