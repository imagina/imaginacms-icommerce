<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\WishlistRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentWishlistRepository extends EloquentBaseRepository implements WishlistRepository
{
  public function getItemsBy($params)
  {

      /*== initialize query ==*/
      $query = $this->model->query();

      /*== RELATIONSHIPS ==*/
      if (in_array('*', $params->include)) {//If Request all relationships
          $query->with([]);
      } else {//Especific relationships
          $includeDefault = [];//Default relationships
          if (isset($params->include))//merge relations with default relationships
              $includeDefault = array_merge($includeDefault, $params->include);
          $query->with($includeDefault);//Add Relationships to query
      }

      /*== FILTERS ==*/
      if (isset($params->filter)) {
          $filter = $params->filter;//Short filter

          //Filter by date
          if (isset($filter->date)) {
              $date = $filter->date;//Short filter date
              $date->field = $date->field ?? 'created_at';
              if (isset($date->from))//From a date
                  $query->whereDate($date->field, '>=', $date->from);
              if (isset($date->to))//to a date
                  $query->whereDate($date->field, '<=', $date->to);
          }

          //add filter by search
          if (isset($filter->search)) {
              //find search in columns
              $query->where('id', 'like', '%' . $filter->search . '%')
                  ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
                  ->orWhere('created_at', 'like', '%' . $filter->search . '%');
          }
          //add filter by user
          if (isset($filter->user)) {
              $query->where('user_id', $filter->user);
          }

          if (isset($filter->store)) {
              $query->where('store_id', $filter->store);
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
  
  public function getItem($criteria, $params)
  {
      //Initialize query
      $query = $this->model->query();

      /*== RELATIONSHIPS ==*/
      if (in_array('*', $params->include)) {//If Request all relationships
          $query->with([]);
      } else {//Especific relationships
          $includeDefault = [];//Default relationships
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
    
    $wishlist = $this->model->create($data);
    
    return $wishlist;
  }

}