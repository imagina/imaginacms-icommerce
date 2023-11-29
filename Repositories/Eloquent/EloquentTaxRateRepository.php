<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\TaxRateRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Arr;

class EloquentTaxRateRepository extends EloquentBaseRepository implements TaxRateRepository
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

      //get language translation
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
    // INITIALIZE QUERY
    $query = $this->model->query();

    $query->where('id', $criteria);

    // RELATIONSHIPS
    $includeDefault = ['translations'];
    $query->with(array_merge($includeDefault, $params->include));

    // FIELDS
    if ($params->fields) {
      $query->select($params->fields);
    }
    return $query->first();

  }

  public function create($data)
  {

    $taxRate = $this->model->create($data);

    //$taxRate->rates()->sync(Arr::get($data, 'rates', []));


    return $taxRate;
  }

  public function updateBy($criteria, $data, $params = false){

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

    if($model){
      $model->update($data);
    }
    return $model;
  }

  public function deleteBy($criteria, $params = false)
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
