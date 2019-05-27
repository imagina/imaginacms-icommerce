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
    if(in_array('*',$params->include)){//If Request all relationships
      $query->with([]);
    }else{//Especific relationships
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
  
      if (isset($filter->ip)){
        $query->where('ip', $filter->ip);
      }
  
      if (isset($filter->userId)){
        $query->where('user_id', $filter->userId);
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
        $includeDefault = ['products'];//Default relationships
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
  
        //$model->products()->sync(array_get($data, 'products', []));
        
        return $model;
      }
      
      /*
  public function create($data){
    if (isset($data['cart_id'])){
        $cart = $this->model->find($data['cart_id']);
    }else {
        $cart = $this->model->create($data);
    }
    $product = array_get($data, 'cart_products', []);
    $cartProduct = CartProduct::where('product_id', $product['product_id'])->where('cart_id', $cart->id)->first();
    if ($cartProduct){
        $cartProduct->update($product);
        $cartProduct->cartproductoption()->sync(array_get($data, 'cart_product_option', [])); 
    } else {
        $product['cart_id'] = $cart->id;
        $product = CartProduct::create($product);
        $product->cartproductoption()->sync(array_get($data, 'cart_product_option', [])); 
    }
    return $cart;
  }*/
  
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
        if($model){
          $model->update((array)$data);
          //sync tables
          $model->products()->sync(array_get($data, 'products', []));
        }
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
