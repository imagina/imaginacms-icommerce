<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentManufacturerRepository extends EloquentCrudRepository implements ManufacturerRepository
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
   * Attribute to customize relations by default
   * @var array
   */
  protected $with = ['all' => ['translations', 'files']];

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

    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {

    } else {

      //pre-filter status
      $query->where("status", 1);
    }

    if (!isset($params->order) || empty($params->order)) {
      $query->orderBy('sort_order', 'desc');//Add order to query
      $query->orderByTranslation('name', 'asc');
    }

    //add filter by search
    if (isset($filter->search)) {
      //find search in columns
      $query->where(function ($query) use ($filter) {
        $query->whereHas('translations', function ($query) use ($filter) {
          $query->where('locale', $filter->locale)
            ->where('name', 'like', '%' . $filter->search . '%');
        })->orWhere('icommerce__manufacturers.id', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
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
}
