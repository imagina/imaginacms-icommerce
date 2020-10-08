<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\CartRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

use Modules\Icommerce\Entities\CartProduct;

class EloquentCartRepository extends EloquentBaseRepository implements CartRepository
{

    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = ['products'];//Default relationships
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
                    $query->where('id', 'like', '%' . $filter->search . '%')
                        ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
                        ->orWhere('created_at', 'like', '%' . $filter->search . '%');
                });
            }

            if (isset($filter->ip)) {
                $query->where('ip', $filter->ip);
            }

            if (isset($filter->user)) {
                $query->where('user_id', $filter->userId);
            }
            if (isset($filter->store)) {
                $query->where('store_id', $filter->store);
            }
            if (isset($filter->status)) {
                $query->whereStatus($filter->status);
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
            $includeDefault = ['products'];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;
            if (isset($filter->user)) {
                $query->where('user_id', $filter->user);
            }
            if (isset($filter->status)) {
                $query->whereStatus($filter->status);
            }
            if (isset($filter->ip)) {
                $query->where('ip',$filter->ip);
            }
            if (isset($filter->store)) {
                $query->where('store_id',$filter->store);
            }
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
    //Search by userñ
    if (isset($data['user_id'])) {
      $userCart = $this->model->where('user_id', $data['user_id'])
        ->where('store_id', $data['store_id'])
        ->where('status', 1)->first();
    }
    
    //Create cart
    if (isset($userCart) && $userCart) return $userCart;
    else return $this->model->create($data);
  }
  

  
  public function updateBy($criteria, $data, $params = false)
  {
    //Get only data permit to update
    $cartData = [];
    if (isset($data['status'])) $cartData['status'] = $data['status'];
    if (isset($data['user_id'])) $cartData['user_id'] = $data['user_id'];
    if (isset($data['products'])) $cartData['products'] = $data['products'];
    
    //Get cart by criteria
    $field = isset($params->filter) && isset($params->filter->field) ? $params->filter->field : 'id';
    $cart = $this->model->where($field, $criteria)->first();

    //Search cart by user
    $userCart = !$data['user_id'] ? false :
      $this->model->where('user_id', $data['user_id'])
        ->where('store_id', $data['store_id'])
        ->where('status', 1)->first();
    
    //Validate cart
    if ($cart) {
      //Move cart to user cart
      if (!$cart->user_id && $userCart) {
        //move products to user cart
        \DB::table('icommerce__cart_product')->where('cart_id', $cart->id)->update(['cart_id' => $userCart->id]);
        $cart->delete();//Drop cart
        $model = $userCart;//Set user cart as model
      } else {
        //Set cart as model
        $model = $cart;
        //No permit change user id of cart
        if (isset($cartData["user_id"]) && $model->user_id) unset($cartData["user_id"]);
      }

      //Update data
      $model->update((array)$cartData);
      //sync products
      if (count(array_get($cartData, 'products', []))) {
        $model->products()->sync(array_get($cartData, 'products', []));
      }
    }
    
    //Response
        return $model;
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
