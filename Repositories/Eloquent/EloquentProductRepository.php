<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepository
{
  public function index($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    // RELATIONSHIPS
    $defaultInclude = ['translations'];
    $query->with(array_merge($defaultInclude, $params->include));
    
    // FILTERS
    if($params->filter) {
      $filter = $params->filter;
      // set language translation
      \App::setLocale($filter->locale ?? null);
      $lang = \App::getLocale();
      
      // default filter by Stock
      $query->where('stock_status', 1);
  
      // add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where(function ($query) use ($filter, $lang) {
          $query->whereHas('translations', function ($query) use ($filter, $lang) {
            $query->where('locale', $lang)
              ->where('title', 'like', '%' . $filter->search . '%');
          })->orWhere('id', 'like', '%' . $filter->search . '%')
            ->orWhere('price', 'like', '%' . $filter->search . '%')
            ->orWhere('sku', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
        });
      }
      // add filter by Categories 1 or more than 1, in array
      if (isset($filter->categories)) {
        $query->whereIn("category_id", $filter->categories);
      }
  
      //add filter by Manufacturers 1 or more than 1, in array
      if (isset($filter->manufacturers)) {
        $query->whereIn("manufacturer_id", $filter->manufacturers);
      }
  
      // add filter by Tax Class 1 or more than 1, in array
      if (isset($filter->taxClass)) {
        $query->whereIn("tax_class_id", $filter->taxClass);
      }
  
      // add filter by Price Range
      // parameters {from: decimal, to:decimal}
      if (isset($filter->priceRange)) {
        $query->where("price", '>=', $filter->priceRange->from);
        $query->where("price", '<=', $filter->priceRange->to);
      }
  
      // add filter by Rating
      // parameters {from: decimal, to:decimal}
      if (isset($filter->priceRange)) {
        $query->where("rating", '>=', $filter->rating->from);
        $query->where("rating", '<=', $filter->rating->to);
      }
  
      // add filter by Freeshipping
      if (isset($filter->freeshipping)) {
        $query->where("freeshipping", $filter->freeshipping);
      }
    }
    // FIELDS
    if ($params->fields) {
      $query->select($params->fields);
    }
    
    // PAGE & TAKE
    // return request with pagination
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
  
    // RELATIONSHIPS
    $includeDefault = ['translations'];
    $query->with(array_merge($includeDefault, $params->include));
  
    // FIELDS
    if ($params->fields) {
      $query->select($params->fields);
    }
    
    // FILTERS
    //set language translation
    \App::setLocale($params->filter->locale ?? null);
    $lang = \App::getLocale();
    
    // First, find record by ID
    $duplicate = $query;
    $result = $duplicate->where('id', $criteria)->first();
  
    // If not give results, find by slug
    if(!$result)
      $result = $query->whereHas('translations', function ($query) use ($criteria, $lang) {
        $query->where('locale', $lang)
          ->where('slug', $criteria);
      })->first();
    
    return $result;
    
  }
}
