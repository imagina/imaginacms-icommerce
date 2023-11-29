<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\LengthClassRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentLengthClassRepository extends EloquentCrudRepository implements LengthClassRepository
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
    $this->checkDefault($data);
    return parent::create($data); // TODO: Change the autogenerated stub
  }
  
  public function updateBy($criteria, $data, $params = false)
  {
    $this->checkDefault($data, $criteria);
    return parent::updateBy($criteria, $data, $params); // TODO: Change the autogenerated stub
  }
  
  private function checkDefault($data, $criteria = null){
    if (isset($data["default"]) && $data["default"]) {
      $defaultLength = $this->findByAttributes(["default" => true]);
      if (isset($defaultLength->id) && $criteria != $defaultLength->id) {
        $defaultLength->default = false;
        $defaultLength->save();
      }
    }
  }
}
