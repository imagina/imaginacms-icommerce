<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\CartRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
  
class EloquentCartRepository extends EloquentCrudRepository implements CartRepository
  {
  /**
   * Filter names to replace
   * @var array
   */
  protected $replaceFilters = [];
      
  /**
   * Relation names to replace
   * @var array
   */
  protected $replaceSyncModelRelations = [];
      
  /**
   * Filter query
   *
   * @param $query
   * @param $filter
   * @param $params
   * @return mixed
   */
  public function filterQuery($query, $filter, $params)
  {
    if (isset($filter->store)) {
      $query->where('store_id', $filter->store);
      }
      
      if (isset($filter->user)) {
        $query->where('user_id', $filter->userId);
      }
    
    /**
     * Note: Add filter name to replaceFilters attribute before replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */
    if (isset($this->model->tenantWithCentralData) && $this->model->tenantWithCentralData && isset(tenant()->id)) {
      $model = $this->model;
      
      $query->withoutTenancy();
      $query->where(function ($query) use ($model) {
        $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
          ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
      });
    }
    
    //Response
    return $query;
    }
  
  /**
   * Method to sync Model Relations
   *
   * @param $model ,$data
   * @return $model
   */
  public function syncModelRelations($model, $data)
  {
    //Get model relations data from attribute of model
    $modelRelationsData = ($model->modelRelations ?? []);
    
    /**
     * Note: Add relation name to replaceSyncModelRelations attribute before replace it
     *
     * Example to sync relations
     * if (array_key_exists(<relationName>, $data)){
     *    $model->setRelation(<relationName>, $model-><relationName>()->sync($data[<relationName>]));
     * }
     *
     */
    
    //Response
    return $model;
      }
  
  public function create($data)
  {
    //Search by user
    if (isset($data['user_id'])) {
      $userCart = $this->model->where('user_id', $data['user_id'])
        // ->where('store_id', $data['store_id'] ?? null)
        ->where('status', 1)->first();
    }
    
    //Create cart
    if (isset($userCart) && $userCart) return $userCart;
	
	$data["status"] = 1;
     return $this->model->create($data);
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
        // ->where('store_id', $data['store_id'] ?? null)
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
      if (count(Arr::get($cartData, 'products', []))) {
        $model->products()->sync(Arr::get($cartData, 'products', []));
      }
    }
    
    //Response
    return $model;
  }
}
