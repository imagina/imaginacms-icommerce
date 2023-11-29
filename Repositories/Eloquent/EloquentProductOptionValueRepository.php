<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ProductOptionValueRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentProductOptionValueRepository extends EloquentCrudRepository implements ProductOptionValueRepository
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

    /**
     * Note: Add filter name to replaceFilters attribute before replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */
  
    /*== By parent Option Value ==*/
    if (isset($filter->parentOptionValue))
      $query->where('parent_option_value_id', $filter->parentOptionValue);
  
  
    
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
    $productOptionValue = parent::create($data); // TODO: Change the autogenerated stub
  
    if(!empty($productOptionValue->parent_prod_opt_val_id)){
      $parent = ProductOptionValue::find($productOptionValue->parent_prod_opt_val_id);
    
      //Verificacion y posible actualizacion de status y stock de padre
      $parent->updateStockByChildren();
    
    }
  
    return $productOptionValue;
  }
  
  public function updateBy($criteria, $data, $params = false)
  {
    $model = parent::updateBy($criteria, $data, $params); // TODO: Change the autogenerated stub
  
    if(isset($model->id) && !empty($model->parent_option_value_id)){
      $parent = $model->parentProductOptionValue;
      //Verificacion y posible actualizacion de status y stock de padre
      $parent->updateStockByChildren();
    }
    return $model;
  }
}
