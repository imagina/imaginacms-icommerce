<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\CouponRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentCouponRepository extends EloquentCrudRepository implements CouponRepository
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
  protected $with = [
    'show' => ['product', 'category', 'customer', 'orders', 'couponHistories']
  ];

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

    //add filter by search
    if (isset($filter->search)) {

      //find search in columns
      $query->where(function ($query) use ($filter, $lang) {
        $query->whereHas('translations', function ($query) use ($filter, $lang) {
          $query->where('locale', $lang)
            ->where('name', 'like', '%' . $filter->search . '%');
        })->orWhere('id', 'like', '%' . $filter->search . '%')
          ->orWhere('code', 'like', '%' . $filter->search . '%')
          ->orWhere('type', 'like', '%' . $filter->search . '%');
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


  /**
   * @param $filter = {"field":"code","criteria":123456}
   * @return $coupon or null
   */
  public function validateCoupon($params)
  {

    $criteria = $params->filter->criteria;
    $result = null;

    // Get Coupon
    $coupon = $this->getItem($criteria, $params);

    if (!empty($coupon) && $coupon->isValid)
      $result = $coupon;

    return $result;

  }
}
