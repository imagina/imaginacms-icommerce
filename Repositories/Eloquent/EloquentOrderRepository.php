<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentOrderRepository extends EloquentBaseRepository implements OrderRepository
{
  public function getItemsBy($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    // RELATIONSHIPS
    $defaultInclude = [];
    $query->with(array_merge($defaultInclude, $params->include));
    
    // FILTERS
    if($params->filter) {
      $filter = $params->filter;
      
      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where('id', 'like', '%' . $filter->search . '%')
          ->orWhere('invoice_nro', 'like', '%' . $filter->search . '%')
          ->orWhere('status_id', 'like', '%' . $filter->search . '%')
          ->orWhere('first_name', 'like', '%' . $filter->search . '%')
          ->orWhere('last_name', 'like', '%' . $filter->search . '%')
          ->orWhere('email', 'like', '%' . $filter->search . '%')
          ->orWhere('payment_first_name', 'like', '%' . $filter->search . '%')
          ->orWhere('payment_last_name', 'like', '%' . $filter->search . '%')
          ->orWhere('shipping_first_name', 'like', '%' . $filter->search . '%')
          ->orWhere('shipping_last_name', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
      }
    }
    
    // FIELDS
    if ($params->fields) {
      $query->select($params->fields);
    }
    
    // PAGE & TAKE
    //Return request with pagination
    if ($params->page) {
      $params->take ? true : $params->take = 12; //If no specific take, query take 12 for default
      return $query->paginate($params->take);
    }
    
    //Return request without pagination
    if (!$params->page) {
      $params->take ? $query->take($params->take) : false; //if request to take a limit
      return $query->get();
    }
  }
  
  public function getItem($criteria, $params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    $query->where('id', $criteria);
    
    // RELATIONSHIPS
    $includeDefault = [];
    $query->with(array_merge($includeDefault, $params->include));
    
    // FIELDS
    if ($params->fields) {
      $query->select($params->fields);
    }
    return $query->first();
    
  }
  
  public function create($data)
  {
    
    $order = $this->model->create($data);
  
    // sync tables
    $order->coupons()->sync(array_get($data, 'coupons', []));
    //$order->orderOption()->sync(array_get($data, 'orderOption', []));
    $order->products()->sync(array_get($data, 'products', []));
    
    return $order;
  }
  
  public function updateBy($criteria, $data, $params){
    
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    // FILTER
    if (isset($params->filter)) {
      $filter = $params->filter;
      
      if (isset($filter->field))//Where field
        $query->where($filter->field, $criteria);
      else//where id
        $query->where('id', $criteria);
    }
    
    // REQUEST
    $model = $query->first();
    
    if($model){
      $model->update($data);
      // sync tables
      $model->coupons()->sync(array_get($data, 'coupons', []));
      //$model->optionValues()->sync(array_get($data, 'optionValues', []));
      $model->products()->sync(array_get($data, 'products', []));
      
    }
    
    return $model;
  }
  
  public function deleteBy($criteria, $params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    // FILTER
    if (isset($params->filter)) {
      $filter = $params->filter;
      
      if (isset($filter->field)) //Where field
        $query->where($filter->field, $criteria);
      else //where id
        $query->where('id', $criteria);
    }
  
    // REQUEST
    $model = $query->first();
  
    if($model) {
      $model->delete();
    }
  }
}
