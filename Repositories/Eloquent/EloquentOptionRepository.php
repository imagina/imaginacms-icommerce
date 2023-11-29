<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentOptionRepository extends EloquentBaseRepository implements OptionRepository
{

  public function getItemsBy($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();

    // RELATIONSHIPS
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = ['translations'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    // FILTERS
    if ($params->filter) {
      $filter = $params->filter;

      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where(function ($query) use ($filter) {
          $query->whereHas('translations', function ($query) use ($filter) {
            $query->where('locale', $filter->locale)
              ->where('description', 'like', '%' . $filter->search . '%');
          })->orWhere('id', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
        });
      }

      //add filter by type
      if (isset($filter->type)) {
        if (is_array($filter->type))
          $query->whereIn('type', $filter->type);
        else
          $query->where('type', $filter->type);
      }

      //add filter by status
      if (isset($filter->status)) {
        $query->whereIn('status_id', $filter->status);
      }

      //add filter by customers
      if (isset($filter->customers)) {
        $query->whereIn('customer_id', $filter->customers);
      }

      //add filter by added by
      if (isset($filter->addedBy)) {
        $query->whereIn('added_by_id', $filter->addedBy);
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
    if(in_array('*',$params->include)){//If Request all relationships
      $query->with([]);
    }else{//Especific relationships
      $includeDefault = ['translations'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

      /*== FILTER ==*/
      if (isset($params->filter)) {
        $filter = $params->filter;

        if (isset($filter->field))//Filter by specific field
          $field = $filter->field;
      }

      /*== FIELDS ==*/
      if (isset($params->fields) && count($params->fields))
        $query->select($params->fields);

      /*== REQUEST ==*/
      return $query->where($field ?? 'id', $criteria)->first();
    }


  public function create($data)
  {
    $option = $this->model->create($data);

    return $option;
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
    return $model ? $model->update((array)$data) : false;
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
  }

}
