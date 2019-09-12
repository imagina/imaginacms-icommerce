<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
//Events media
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Modules\Ihelpers\Events\DeleteMedia;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepository
{
  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = ['translations'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter

      // add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where(function ($query) use ($filter) {
          $query->whereHas('translations', function ($query) use ($filter) {
            $query->where('locale', $filter->locale)
              ->where('name', 'like', '%' . $filter->search . '%');
          })->orWhere('id', 'like', '%' . $filter->search . '%')
            ->orWhere('price', 'like', '%' . $filter->search . '%')
            ->orWhere('sku', 'like', '%' . $filter->search . '%');
        });
      }

      //Filter by catgeory ID
      if (isset($filter->categoryId) && $filter->categoryId) {
        $query->where('category_id', $filter->categoryId);
      }

      // Filter by category SLUG
      if (isset($filter->categorySlug) && $filter->categorySlug) {
        $query->whereHas('categories', function ($query) use ($filter) {
          $query->whereHas('translations', function ($query) use ($filter) {
            $query
              ->where('icommerce__category_translations.locale', $filter->locale)
              ->where('icommerce__category_translations.slug', $filter->categorySlug);
          });
        });
      }

      //Filter by stock status
      if (isset($filter->stockStatus)) {
        $query->where('stock_status', $filter->stockStatus);
      }

      //Filter by stock status
      if (isset($filter->status)) {
        $query->where('status', $filter->status);
      }

      // add filter by Categories 1 or more than 1, in array
      if (isset($filter->categories)) {
        is_array($filter->categories) ? true : $filter->categories = [$filter->categories];
        $query->whereIn('icommerce__products.id', function($query) use($filter){
          $query->select('product_id')
          ->from('icommerce__product_category')
          ->whereIn('category_id',$filter->categories);
        });
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
      if (isset($filter->priceRange)) {
        $query->where("price", '>=', $filter->priceRange->from);
        $query->where("price", '<=', $filter->priceRange->to);
      }

      // add filter by Rating
      if (isset($filter->priceRange)) {
        $query->where("rating", '>=', $filter->rating->from);
        $query->where("rating", '<=', $filter->rating->to);
      }

      // add filter by Freeshipping
      if (isset($filter->freeshipping)) {
        $query->where("freeshipping", $filter->freeshipping);
      }

      //Filter by date
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
      }

      //Order by
      if (isset($filter->order)) {
        $orderByField = $filter->order->field ?? 'created_at';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
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


  public function getItem($criteria, $params = false)
  {
    //Initialize query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = ['translations'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      // find translatable attributes
      $translatedAttributes = $this->model->translatedAttributes;

      if(isset($filter->field))
        $field = $filter->field;

      // filter by translatable attributes
      if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
        $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
          $query->where('locale', $filter->locale)
            ->where($field, $criteria);
        });
      else
        // find by specific attribute or by id
        $query->where($field ?? 'id', $criteria);

    }
    /*== REQUEST ==*/
    return $query->first();
  }

  public function create($data)
  {
    $product = $this->model->create($data);

    if ($product) {
      // sync tables
      $product->categories()->sync(array_get($data, 'categories', []));

      //$product->productOptions()->sync(array_get($data, 'product_options', []));

      //$product->optionValues()->sync(array_get($data, 'option_values', []));

      $product->relatedProducts()->sync(array_get($data, 'related_products', []));

      //$product->discounts()->sync(array_get($data, 'discounts', []));

      $product->tags()->sync(array_get($data, 'tags', []));
    }

    //Event to ADD media
    event(new CreateMedia($product, $data));

    return $product;
  }

  public function updateBy($criteria, $data, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      //Update by field
      if (isset($filter->field))
        $field = $filter->field;
    }

    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();

    if ($model) {
      $model->update($data);

      // sync tables
      $model->categories()->sync(array_get($data, 'categories', []));

      //$model->productOptions()->sync(array_get($data, 'productOptions', []));

      //$model->optionValues()->sync(array_get($data, 'optionValues', []));

      $model->relatedProducts()->sync(array_get($data, 'related_products', []));

      //$model->discounts()->sync(array_get($data, 'discounts', []));

      $model->tags()->sync(array_get($data, 'tags', []));
    }

    //Event to Update media
    event(new UpdateMedia($model, $data));

    return $model ?? false;
  }

  public function deleteBy($criteria, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      if (isset($filter->field))//Where field
        $field = $filter->field;
    }

    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();
    $model ? $model->delete() : false;

    //Event to Delete media
    event(new DeleteMedia($model->id, get_class($model)));
  }
}
