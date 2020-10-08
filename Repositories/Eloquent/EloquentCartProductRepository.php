<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
// Entities
use Modules\Icommerce\Entities\CartProduct;

class EloquentCartProductRepository extends EloquentBaseRepository implements CartProductRepository
{

  public function getItemsBy($params = false)
    {
      /*== initialize query ==*/
      $query = $this->model->query();

      /*== RELATIONSHIPS ==*/
      if(in_array('*',$params->include)){//If Request all relationships
        $query->with([]);
      }else{//Especific relationships
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

        if (isset($filter->cartId)){
          $query->where('cart_id', $filter->cartId);
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
    $includeDefault = ['productOptionValues'];
    $query->with(array_merge($includeDefault, $params->include));

    // FIELDS
    if ($params->fields) {
      $query->select($params->fields);
    }
    return $query->first();

  }

  public function create($data){

    // if the request has product without options
    $cartProduct = $this->findByAttributesOrOptions($data);

    //if not found product into cart with the same options
    if(!$cartProduct) {
      $cartProduct = $this->model->create($data);
      $cartProduct->productOptionValues()->sync(array_column(array_get($data, 'product_option_values', []),'id'));

    }else {
      // get product options
      $productOptionValues = $cartProduct->productOptionValues;

      // get options from front
      $productOptionValuesFront = array_get($data, 'product_option_values', []);

      // if product doesn't have the same options wil be created and sync options

      $productOptionValuesIds = $productOptionValues->pluck('id')->toArray();
      $productOptionValuesIdsFront = array_column($productOptionValuesFront,'id');

      if( array_diff($productOptionValuesIds, $productOptionValuesIdsFront) !== array_diff($productOptionValuesIdsFront, $productOptionValuesIds)){

          $cartProduct = $this->model->create($data);
          $cartProduct->productOptionValues()->sync(array_column(array_get($data, 'product_option_values', []),'id'));


      }else{
        // if product have the same options update quantity and update
        $data['quantity'] += $cartProduct->quantity;
          $cartProduct->update($data);

      }

    }
    return $cartProduct;
  }

  public function updateBy($criteria, $data, $params){

    // INITIALIZE QUERY
    $cartProduct = $this->findByAttributesOrOptions($data);
    
    if($cartProduct) {
  
      // get product options
      $productOptionValues = $cartProduct->productOptionValues;
  
      // get options from front
      $productOptionValuesFront = array_get($data, 'product_option_values', []);
  
      $productOptionValuesIds = $productOptionValues->pluck('id')->toArray();
      $productOptionValuesIdsFront = array_column($productOptionValuesFront,'id');
      // if is the same option values ids
      if( array_diff($productOptionValuesIds, $productOptionValuesIdsFront) === array_diff($productOptionValuesIdsFront, $productOptionValuesIds)){
        $cartProduct->update($data);
        
      }else{ // if not the same options create cart product
        $cartProduct = $this->model->create($data);
      }
      
      
    }
    return $cartProduct;
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
  
  public function findByAttributesOrOptions($data){
    // if the request has product without options
    if(!count(array_get($data, 'product_option_values', []))) {
      // find product into cart by attributes
      $cartProduct = CartProduct::where('cart_id',$data['cart_id'])
        ->where('product_id', $data['product_id'])
        ->has('productOptionValues', 0)->first();
    }else{
      // get options from front
      $productOptionValuesIdsFront = array_column(array_get($data, 'product_option_values', []),'id');

      // find product into cart where has the same options
      $cartProducts = CartProduct::where('cart_id',$data['cart_id'])
        ->where('product_id', $data['product_id'])
        ->whereHas('productOptionValues', function ($query) use ($productOptionValuesIdsFront) {
          $query->whereIn("product_option_value_id",$productOptionValuesIdsFront);
        })->get();

      foreach ($cartProducts as $cartProductQuery){
        // get product options
        $productOptionValuesIds = $cartProductQuery->productOptionValues->pluck('id')->toArray();

          if( array_diff($productOptionValuesIds, $productOptionValuesIdsFront) === array_diff($productOptionValuesIdsFront, $productOptionValuesIds)){

            $cartProduct = $cartProductQuery;
          }
      }
    }

    return $cartProduct ?? false;
  }
}
