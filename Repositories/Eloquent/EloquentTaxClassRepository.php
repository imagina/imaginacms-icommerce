<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\TaxClassRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentTaxClassRepository extends EloquentBaseRepository implements TaxClassRepository
{
  public function index($page, $take, $filter, $include, $fields)
  {
    //set language translation
    \App::setLocale($filter->locale ?? null);
    //Initialize Query
    $query = $this->model->query();
    
    //Relationships
    $defaultInclude = ['translations'];
    $query->with(array_merge($defaultInclude, $include));
    
    //add filter by search
    if (isset($filter->search)) {
      $lang = \App::getLocale();
      //find search in columns
      $query->where(function ($query) use ($filter, $lang) {
        $query->whereHas('translations', function ($query) use ($filter, $lang) {
          $query->where('locale', $lang)
            ->where('name', 'like', '%' . $filter->search . '%');
        })->orWhere('id', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
      });
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
    $lang = \App::getLocale();
    
    //Initialize Query
    $query = $this->model->query();
    
      $query->where('id', $id);

    
    /*== RELATIONSHIPS ==*/
    $includeDefault = ['translations'];
    if (count($include))
      $query->with(array_merge($includeDefault, $include));
    else
      $query->with($includeDefault);
    
    /*== FIELDS ==*/
    if ($fields) {
      /*filter by user*/
      $query->select($fields);
    }
    return $query->first();
    
  }
}
