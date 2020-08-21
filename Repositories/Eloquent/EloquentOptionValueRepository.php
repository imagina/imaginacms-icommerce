<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\OptionValueRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
//Events media
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Modules\Ihelpers\Events\DeleteMedia;

class EloquentOptionValueRepository extends EloquentBaseRepository implements OptionValueRepository
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

      //add filter by search
      if (isset($filter->optionId) && (int)$filter->optionId) {
        //find search in columns
        $query->where('option_id', $filter->optionId);
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
    $model = $this->model->create($data);

    //Event to ADD media
    event(new CreateMedia($model, $data));

    return $model;
  }
    public function update($model, $data)
    {

        $model->update($data);

        //Event to Update media
        event(new UpdateMedia($model, $data));

        return $model;
    }

    public function destroy($model)
    {

        //Event to Delete media
        event(new DeleteMedia($model->id, get_class($model)));

        return  $model->delete();

    }

}
