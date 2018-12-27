<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\TagRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentTagRepository extends EloquentBaseRepository implements TagRepository
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
    
    /*== FIELDS ==*/
    if (is_array($params->fields) && count($params->fields))
      $query->select($params->fields);
    
    // FILTERS
    //get language translation
    $lang = \App::getLocale();
    
    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;
      
      if (isset($filter->slug) && $filter->slug)//Filter by slug
        $result = $query->whereHas('translations', function ($query) use ($criteria, $lang) {
          $query->where('locale', $lang)
            ->where('slug', $criteria);
        });
      else//Filter by ID
        $query->where('id', $criteria);
      
    }
    return $query->first();
  }
  
  public function create($data)
  {
    
    $tag = $this->model->create($data);
    
    return $tag;
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
    $model = $query->update($data);
    
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
    
    /*== REQUEST ==*/
    $query->delete();
  }
  
}
