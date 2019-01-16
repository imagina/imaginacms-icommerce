<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepository
{
  public function getItemsBy($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();

    // RELATIONSHIPS
    $defaultInclude = ['translations'];
    $query->with(array_merge($defaultInclude, $params->include));

    // FILTERS
    if ($params->filter) {
      $filter = $params->filter;

      // get language translation
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

      // add filter by date
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
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

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take);
    } else {
      $params->take ? $query->take($params->take) : false;//Take
      return $query->get();
    }

  }

  public function getItem($criteria, $params)
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

    $product = $this->model->create($data);

    if($product){
      // sync tables
      $product->categories()->sync(array_get($data, 'categories', []));

      $product->productOptions()->sync(array_get($data, 'productOptions', []));

      $product->optionValues()->sync(array_get($data, 'optionValues', []));

      $product->relatedProducts()->sync(array_get($data, 'relatedProducts', []));

//      $product->discounts()->sync(array_get($data, 'discounts', []));

      $product->tags()->sync(array_get($data, 'tags', []));
    }

    return $product;
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

    $model = $query->first();

    if($model){
      $model->update($data);

      // sync tables
       $model->categories()->sync(array_get($data, 'categories', []));

       $model->productOptions()->sync(array_get($data, 'productOptions', []));

       $model->optionValues()->sync(array_get($data, 'optionValues', []));

       $model->relatedProducts()->sync(array_get($data, 'relatedProducts', []));

      //$model->discounts()->sync(array_get($data, 'discounts', []));

      $model->tags()->sync(array_get($data, 'tags', []));
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
