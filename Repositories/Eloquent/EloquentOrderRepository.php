<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

// Events
use Modules\Icommerce\Events\OrderWasCreated;


class EloquentOrderRepository extends EloquentBaseRepository implements OrderRepository
{
  public function getItemsBy($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();

    // RELATIONSHIPS
    $defaultInclude = ['customer','addedBy'];
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
      if (isset($filter->customer)){
        // if has permission
        $indexPermission = $params->permissions['icommerce.orders.index'] ?? false; // index orders
        $showOthersPermission = $params->permissions['icommerce.orders.show-others'] ?? false; // show orders of others
        $user = $params->user;
        if($showOthersPermission || ($filter->customer == $user->id && $indexPermission)){
          $query->where('customer_id', $filter->customer);
        }
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
      // $params->take ?? $query->take($params->take);//Take
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
        $includeDefault = ['customer','addedBy'];//Default relationships
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
        if(isset($filter->customer)){
          $query->where('customer_id', $filter->customer);
        }
        //By key
        if (isset($filter->key)){
          $query->where('key', $filter->key);
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
          $query->select($params->fields);

        /*== REQUEST ==*/
        return $query->where($field ?? 'id', $criteria)->first();
      }


  public function create($data)
  {

    // Create Order
    $order = $this->model->create($data);

    // Create Order History
    $order->orderHistory()->create($data['orderHistory']);




    return $order;

  }

}
