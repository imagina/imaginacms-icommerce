<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\TaxClassRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Arr;

class EloquentTaxClassRepository extends EloquentBaseRepository implements TaxClassRepository
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
              ->where('name', 'like', '%' . $filter->search . '%');
          })->orWhere('id', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
        });
      }
    }

    //*== FIELDS ==*/
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

  public function create($data)
  {
    $rates = Arr::get($data, 'rates', []);

    unset($data['rates']);

    $taxClass = $this->model->create($data);
    // sync tables
    $taxClass->rates()->sync($rates);


    return $tagClass;
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
            $rates = Arr::get($data, 'rates', []);
            unset($data['rates']);
            $model->update($data);
            // sync tables
            if($rates)
                //$model->rates()->detach();
                $model->rates()->sync($rates);
        }
        return $model;
    }



}
