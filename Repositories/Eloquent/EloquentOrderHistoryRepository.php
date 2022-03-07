<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Events\OrderWasProcessed;
use Modules\Icommerce\Repositories\OrderHistoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Events\OrderStatusHistoryWasCreated;

class EloquentOrderHistoryRepository extends EloquentBaseRepository implements OrderHistoryRepository
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
          ->orWhere('notify', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
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

    $orderhistory = $this->model->create($data);
    
    //====== Update Order
    $orderhistory->order->update([
      'status_id' => $orderhistory->status
    ]);
    event(new OrderWasUpdated($orderhistory->order));
    //====== End Update Order

    event(new OrderStatusHistoryWasCreated($orderhistory));
  
    if($orderhistory->status == 13) {// Processed
      event(new OrderWasProcessed($orderhistory->order));
    }

    return $orderhistory;
  }
}
