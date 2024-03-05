<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Kalnoy\Nestedset\Collection;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class EloquentCategoryRepository extends EloquentCrudRepository implements CategoryRepository
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
    //add filter by search
    if (isset($filter->search)) {
      //find search in columns
      $query->where(function ($query) use ($filter) {
        $query->whereHas('translations', function ($query) use ($filter) {
          $query->where('locale', $filter->locale)
            ->where('title', 'like', '%' . $filter->search . '%');
        })->orWhere('icommerce__categories.id', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
      });
    }
  
    //add filter by manufacturers
    if (isset($filter->manufacturers) && $filter->manufacturers) {
      is_array($filter->manufacturers) ? true : $filter->manufacturers = [$filter->manufacturers];
      $query->whereHas('products', function ($query) use ($filter) {
        return $query->whereHas('manufacturer', function ($query) use ($filter) {
          $query->whereIn('icommerce__manufacturers.id', $filter->manufacturers);
        });
      });
    }
  
    //add filter by manufacturers
    if (isset($filter->organizations) && $filter->organizations) {
      is_array($filter->organizations) ? true : $filter->organizations = [$filter->organizations];
      $query->whereHas('products', function ($query) use ($filter) {
        $query->whereIn('icommerce__products.organization_id', $filter->organizations);
      });
    }
  
    if (isset($filter->onlyWithOrganization)) {
      $query->whereNotNull("organization_id");
    }
  
    //Filter by parent ID
    if (isset($filter->parentId)) {
      if ($filter->parentId == 0) {
        $query->whereNull("parent_id");
      } else {
        $query->where("parent_id", $filter->parentId);
      }
    }
  
    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {
    
    } else {
    
      //Pre filters by default
      $this->defaultPreFilters($query, $params);
    
    }
    
    if(!isset($params->order) || empty($params->order)){
      $query->orderBy('sort_order', 'desc');//Add order to query
    }
  
    $entitiesWithCentralData = json_decode(setting("icommerce::tenantWithCentralData", null, "[]"));
    $tenantWithCentralData = in_array("categories", $entitiesWithCentralData);
  
    if ($tenantWithCentralData && isset(tenant()->id)) {
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
  
  public function defaultPreFilters($query, $params)
  {
    
    //pre-filter status
    $query->where("status", 1);
    
    //pre-filter if the organization is enabled (organization status = 1)
    $query->where(function ($query) {
      $query->whereNull("organization_id")
        ->orWhereRaw("icommerce__categories.organization_id IN (SELECT id from isite__organizations where status = 1)");
      
    });
    
  }
  
  private function getParents($categoryManufacturer, &$parents = [], $categories)
  {
    foreach ($categories as $category) {
      if ($categoryManufacturer->parent_id == $category->id) {
        array_push($parents, $category);
        $this->getParents($category, $parents, $categories);
      }
    }
  }
  
  public function getItemsByForTheTreeFilter($params)
  {
    $categories = $this->getItemsBy($params);
    
    if (isset($params->filter->manufacturers) && !empty($params->filter->manufacturers)) {
      $params->filter->manufacturers = null;
      
      $categoriesWithoutManufacturersFilter = $this->getItemsBy($params);
      
      $parents = [];
      foreach ($categories as $category) {
        $this->getParents($category, $parents, $categoriesWithoutManufacturersFilter);
      }
      
      $categories = collect($parents)->merge($categories)->keyBy("id");
    }
    
    if (isset($params->filter->organizations) && !empty($params->filter->organizations)) {
      $params->filter->organizations = null;
      
      $categoriesWithoutOrganizationsFilter = $this->getItemsBy($params);
      
      $parents = [];
      foreach ($categories as $category) {
        $this->getParents($category, $parents, $categoriesWithoutOrganizationsFilter);
      }
      
      $categories = collect($parents)->merge($categories)->keyBy("id");
    }
    
    return new Collection($categories);
  }
}
