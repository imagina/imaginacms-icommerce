<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\CartRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCartRepository extends EloquentBaseRepository implements CartRepository
{
  public function index($page, $take, $filter, $include, $fields)
  {
    //set language translation
    \App::setLocale($filter->locale ?? null);
    
    //Initialize Query
    $query = $this->model->query();
    
    //Relationships
    $defaultInclude = ['products'];
    $query->with(array_merge($defaultInclude,$include));
    
    //add filter by search
    if (isset($filter->search)) {
      //find search in columns Customer_name and Customer_Last_Name
      $query->where('id', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
    }
    
    /*== FIELDS ==*/
    if ($fields) {
      /*filter by user*/
      $query->select($fields);
    }
    
    //Return request with pagination
    if ($page) {
      $take ? true : $take = 12; //If no specific take, query take 12 for default
      return $query->paginate($take);
    }
    
    //Return request without pagination
    if (!$page) {
      $take ? $query->take($take) : false; //if request to take a limit
      return $query->get();
    }
  }
  
  public function show($filter, $include, $fields, $id)
  {
    //set language translation
    \App::setLocale($filter->locale ?? null);
    
    
    //Initialize Query
    $query = $this->model->query();
    
    $query->where('id', $id);
    
    /*== RELATIONSHIPS ==*/
    $includeDefault = ['products'];
    $query->with(array_merge($includeDefault, $include));
    
    
    /*== FIELDS ==*/
    if ($fields) {
      /*filter by user*/
      $query->select($fields);
    }
    return $query->first();
    
  }
  
}
