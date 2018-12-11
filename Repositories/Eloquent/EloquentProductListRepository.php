<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ProductListRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentProductListRepository extends EloquentBaseRepository implements ProductListRepository
{
  public function index($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    // RELATIONSHIPS
    $defaultInclude = ['products'];
    $query->with(array_merge($defaultInclude,$params->include));
    
    // FILTERS
    if($params->filter) {
      $filter = $params->filter;
      
      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where('id', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
      }
  
      //add filter by product Ids
      if(isset($filter->productIds)){
        $query->whereIn('product_id', $filter->productIds);
      }
  
      //add filter by product option Ids
      if(isset($filter->productOptionIds)){
        $query->whereIn('product_option_id', $filter->productOptionIds);
      }
      
      //add filter by product option value Ids
      if(isset($filter->productOptionValueIds)){
        $query->whereIn('product_option_value_id', $filter->productOptionValueIds);
      }
    }
    
    
    // FIELDS
    if ($params->fields) {
      $query->select($params->fields);
    }
    
    // PAGE & TAKE
    // Return request with pagination
    if ($params->page) {
      $params->take ? true : $params->take = 12; //If no specific take, query take 12 for default
      return $query->paginate($params->take);
    }
    
    // Return request without pagination
    if (!$params->page) {
      $params->take ? $query->take($params->take) : false; //if request to take a limit
      return $query->get();
    }
  }
  
  
  public function show($criteria, $params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    $query->where('id', $criteria);
    
    // RELATIONSHIPS
    $includeDefault = ['products'];
    $query->with(array_merge($includeDefault, $params->include));
    
    // FIELDS
    if ($params->fields) {
      $query->select($params->fields);
    }
    return $query->first();
    
  }
  
}
