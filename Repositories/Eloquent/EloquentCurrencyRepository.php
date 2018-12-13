<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCurrencyRepository extends EloquentBaseRepository implements CurrencyRepository
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
            ->orWhere('code', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
        });
      }
      
      //add filter by status
      if (!empty($filter->status)) {
        $query->where('status', $filter->status);
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
    
    $query->where('id', $criteria);
    
    // RELATIONSHIPS
    $includeDefault = ['translations'];
    $query->with(array_merge($includeDefault, $params->include));
    
    // FILTERS
    //set language translation
    if (isset($params->filter->locale))
      \App::setLocale($params->filter->locale ?? null);
    
    // FIELDS
    if ($params->fields) {
      $query->select($params->fields);
    }
    return $query->first();
    
  }
}
