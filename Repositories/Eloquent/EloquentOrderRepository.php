<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

// Events
use Modules\Icommerce\Events\OrderWasCreated;
use Modules\Icommerce\Events\OrderWasUpdated;

class EloquentOrderRepository extends EloquentBaseRepository implements OrderRepository
{
  public function getItemsBy($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();

    // RELATIONSHIPS
    $defaultInclude = [];
    $query->with(array_merge($defaultInclude, $params->include));

    // FILTERS
    if($params->filter) {
      $filter = $params->filter;

      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where('id', 'like', '%' . $filter->search . '%')
          ->orWhere('invoice_nro', 'like', '%' . $filter->search . '%')
          ->orWhere('status_id', 'like', '%' . $filter->search . '%')
          ->orWhere('first_name', 'like', '%' . $filter->search . '%')
          ->orWhere('last_name', 'like', '%' . $filter->search . '%')
          ->orWhere('email', 'like', '%' . $filter->search . '%')
          ->orWhere('payment_first_name', 'like', '%' . $filter->search . '%')
          ->orWhere('payment_last_name', 'like', '%' . $filter->search . '%')
          ->orWhere('shipping_first_name', 'like', '%' . $filter->search . '%')
          ->orWhere('shipping_last_name', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
      }
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
            $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
            $query->whereDate($date->field, '<=', $date->to);
      }
      if (isset($filter->status)){
          $query->where('status_id', $filter->status);
      }

      if (isset($filter->store)){
        $query->where('store_id', $filter->store);
      }

      if (isset($filter->user)){
        $query->where('added_by_id', $filter->user);
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

    $query->where('id', $criteria);

    // RELATIONSHIPS
    $includeDefault = [];
    $query->with(array_merge($includeDefault, $params->include));

    // FIELDS
    if ($params->fields) {
      $query->select($params->fields);
    }
    return $query->first();

  }

  public function create($data)
  {

    // Create Order
    $order = $this->model->create($data);

    // Create Order History
    $order->orderHistory()->create($data['orderHistory']);

    // Event To create OrderItems, OrderOptions, next send email
    event(new OrderWasCreated($order,$data['orderItems']));

   
    return $order;

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

    if($model){

      $model->update($data);

      // Create Order History
      $model->orderHistory()->create($data['orderHistory']);
     
      // Event to send Email
      event(new OrderWasUpdated($model));

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
