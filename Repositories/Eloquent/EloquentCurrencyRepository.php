<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Entities\Status;

class EloquentCurrencyRepository extends EloquentBaseRepository implements CurrencyRepository
{
  public function getItemsBy($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    // RELATIONSHIPS
    $defaultInclude = ['translations'];
    $query->with(array_merge($defaultInclude, $params->include ?? []));
    
    // FILTERS
    if (isset($params->filter)) {
      $filter = $params->filter;
      
      //get language translation
      $lang = \App::getLocale();
      
      //add filter by search
      if (isset($filter->search)) {
        
        //find search in columns
        $query->where(function ($query) use ($filter, $lang) {
          $query->whereHas('translations', function ($query) use ($filter, $lang) {
            $query->where('locale', $lang)
              ->where('title', 'like', '%' . $filter->search . '%');
          })->orWhere('id', 'like', '%' . $filter->search . '%')
            ->orWhere('code', 'like', '%' . $filter->search . '%');
        });
      }
        if (isset($filter->store)) {
            $query->where('store_id', $filter->store);
        }
      //add filter by status
      if (!empty($filter->status)) {
        $query->where('status', $filter->status);
      }
    }
  
    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {
    
    } else {
    
      //Pre filters by default
      $this->defaultPreFilters($query, $params);
    }
  
  
    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);
  
    /*== REQUEST ==*/
    if (isset($params->onlyQuery) && $params->onlyQuery) {
      return $query;
    } else
      if (isset($params->page) && $params->page) {
        //return $query->paginate($params->take);
        return $query->paginate($params->take, ['*'], null, $params->page);
      } else {
        isset($params->take) && $params->take ? $query->take($params->take) : false;//Take
        return $query->get();
      }
  }
  
  public function getItem($criteria, $params = false)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
        $filter = $params->filter;
        if (isset($filter->field))
            $field = $filter->field;
    }

    // RELATIONSHIPS
    $includeDefault = ['translations'];
    $query->with(array_merge($includeDefault, $params->include ?? []));


    // FIELDS
    if (isset($params->fields) && !empty($params->fields)) {
      
      $query->select($params->fields);
    }
  
    $query->where($field ?? 'id', $criteria);

    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {
    
    } else {
    
      //Pre filters by default
      $this->defaultPreFilters($query, $params);
    }

    return $query->first();
    
  }
  
  public function create($data){
    
    $currency = $this->model->create($data);
    
  
    return $currency;
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

    if($model) {
      if (isset($data["default_currency"]) && $data["default_currency"]) {
        $defaultCurrency = $this->findByAttributes(["default_currency" => true]);
        if (isset($defaultCurrency->id)) {
          $defaultCurrency->default_currency = false;
          $defaultCurrency->save();
        }
      }
      
      $model->update($data);
      
      
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

  public function getActive(){
    return $this->model->where("default_currency",1)->first();
  }
  
  public function defaultPreFilters(&$query, $params){
    
    //Pre filters by default
    //pre-filter status
    $query->where("status", 1);
    
  
    
  }
}
