<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{
  
  public function index($params)
  {
    
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    // RELATIONSHIPS
    $defaultInclude = ['translations'];
    $query->with(array_merge($defaultInclude, $params->include));
    
    // FILTERS
    if ($params->filter) {
      $filter = $params->filter;
      
      //set language translation
      if (isset($params->filter->locale))
        \App::setLocale($filter->locale ?? null);
      $lang = \App::getLocale();
      
      //add filter by search
      if (isset($filter->search)) {
        
        //find search in columns
        $query->where(function ($query) use ($filter, $lang) {
          $query->whereHas('translations', function ($query) use ($filter, $lang) {
            $query->where('locale', $lang)
              ->where('title', 'like', '%' . $filter->search . '%');
          })->orWhere('id', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
        });
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
  
  public function show($criteria, $params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    // RELATIONSHIPS
    $includeDefault = ['translations'];
    $query->with(array_merge($includeDefault, $params->include));
    
    // FIELDS
    if ($params->fields) {
      $query->select($params->fields);
    }
    
    // FILTERS
    //set language translation
    if (isset($params->filter->locale))
      \App::setLocale($params->filter->locale ?? null);
    $lang = \App::getLocale();
    
    // First, find record by ID
    $duplicate = $query;
    $result = $duplicate->where('id', $criteria)->first();
    
    // If not give results, find by slug
    if (!$result)
      $result = $query->whereHas('translations', function ($query) use ($criteria, $lang) {
        $query->where('locale', $lang)
          ->where('slug', $criteria);
      })->first();
    
    return $result;
    
  }
  
  
}
