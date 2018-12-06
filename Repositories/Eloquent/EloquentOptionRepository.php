<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentOptionRepository extends EloquentBaseRepository implements OptionRepository
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
        //find search in columns Customer_name and Customer_Last_Name
        $query->where('id', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
      }
  
      //add filter by status
      if (isset($filter->status)) {
        $query->whereIn('status_id',$filter->status);
      }
  
      //add filter by customers
      if (isset($filter->customers)) {
        $query->whereIn('customer_id',$filter->customers);
      }
  
      //add filter by added by
      if (isset($filter->addedBy)) {
        $query->whereIn('added_by_id',$filter->addedBy);
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
