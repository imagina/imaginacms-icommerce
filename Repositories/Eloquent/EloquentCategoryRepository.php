<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Kalnoy\Nestedset\Collection;

//Events media

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{
  public function getItemsBy($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with(['translations', 'files']);
    } else {//Especific relationships
      $includeDefault = ['translations', 'files'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include ?? []);
      $query->with($includeDefault);//Add Relationships to query
    }
    
    // FILTERS
    if (isset($params->filter)) {
      $filter = $params->filter;
      
      //add filter by id
      if(isset($filter->id)){
        !is_array($filter->id) ? $filter->id = [$filter->id] : false;
        $query->whereIn("icommerce__categories.id",$filter->id);
      }
      
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
      
      //add filter by store
      if (isset($filter->store)) {
        $query->where('store_id', $filter->store);
      }
      
      //add filter by showMenu
      if (isset($filter->showMenu) && is_bool($filter->showMenu)) {
        $query->where('show_menu', $filter->showMenu);
      }
      
      //add filter by ids
      if (isset($filter->ids)) {
        is_array($filter->ids) ? true : $filter->ids = [$filter->ids];
        $query->whereIn('icommerce__categories.id', $filter->ids);
      }
      
      //add filter by ids
      if (isset($filter->id)) {
        is_array($filter->id) ? true : $filter->id = [$filter->id];
        $query->whereIn('icommerce__categories.id', $filter->id);
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
        
        if (in_array($orderByField, ["slug", "title"])) {
          $query->join('icommerce__category_translations as translations', 'translations.category_id', '=', 'icommerce__categories.id');
          $query->orderBy("translations.{$orderByField}", $orderWay);
        } else $query->orderBy("icommerce__categories." . $orderByField, $orderWay);//Add order to query
      }
      if (isset($filter->store)) {
        $query->where("store_id", $filter->store);
      }
      
      if (isset($filter->featured) && is_bool($filter->featured)) {
        $query->where("featured", $filter->featured);
      }
      
      //Filter by parent ID
      if (isset($filter->parentId)) {
        if ($filter->parentId == 0) {
          $query->whereNull("parent_id");
        } else {
          $query->where("parent_id", $filter->parentId);
        }
      }
    }
    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {
    
    } else {
      
      //pre-filter status
      $query->where("status", 1);
    }
    
    // ORDER
    if (isset($params->order) && $params->order) {
      
      $order = is_array($params->order) ? $params->order : [$params->order];
      
      foreach ($order as $orderObject) {
        if (isset($orderObject->field) && isset($orderObject->way))
          $query->orderBy("icommerce__categories." . $orderObject->field, $orderObject->way);
      }
    } else {
      $query->orderBy('sort_order', 'desc');//Add order to query
    }
    
    /*== FIELDS ==*/
    if (isset($params->fields) && is_array($params->fields) && count($params->fields) && $params->fields)
      $query->select($params->fields);
  
    $entitiesWithCentralData = json_decode(setting("icommerce::tenantWithCentralData",null,"[]"));
    $tenantWithCentralData = in_array("categories",$entitiesWithCentralData);
    
    if ($tenantWithCentralData && isset(tenant()->id)) {
      $model = $this->model;
      
      $query->withoutTenancy();
      $query->where(function ($query) use ($model) {
        $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
          ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
      });
    }
    
    
    /*== REQUEST ==*/
    //dd($query->toSql(),$query->getBindings());
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take);
    } else {
      isset($params->take) && $params->take ? $query->take($params->take) : false;//Take
      return $query->get();
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
  
  public function getItem($criteria, $params = false)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    
    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with(['translations', 'files']);
    } else {//Especific relationships
      $includeDefault = ['translations', 'files'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include ?? []);
      $query->with($includeDefault);//Add Relationships to query
    }
    
    /*== FIELDS ==*/
    if (isset($params->fields) && is_array($params->fields) && count($params->fields))
      $query->select($params->fields);
    
    
    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;
      
      if (isset($filter->field))//Filter by specific field
        $field = $filter->field;
      
      // find translatable attributes
      $translatedAttributes = $this->model->translatedAttributes;
      
      // filter by translatable attributes
      if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
        $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
          $query->where('locale', $filter->locale)
            ->where($field, $criteria);
        });
      else {
        // find by specific attribute or by id
        $query->where($field ?? 'id', $criteria);
      }
      
      
    }
    
    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {
    
    } else {
      
      //pre-filter status
      $query->where("status", 1);
      
    }
    
    /*== REQUEST ==*/
    return $query->first();
  }
  
  /**
   * Find a resource by the given slug
   *
   * @param string $slug
   * @return object
   */
  public function findBySlug($slug)
  {
    if (method_exists($this->model, 'translations')) {
      
      
      $query = $this->model->whereHas('translations', function (Builder $q) use ($slug) {
        $q->where('slug', $slug);
      })->with('translations', 'parent', 'children');
      
    } else
      $query = $this->model->where('slug', $slug)->with('translations', 'parent', 'children', 'vehicles');

    $entitiesWithCentralData = json_decode(setting("icommerce::tenantWithCentralData",null,"[]"));
    $tenantWithCentralData = in_array("categories",$entitiesWithCentralData);

    if ($tenantWithCentralData && isset(tenant()->id)) {
      $model = $this->model;

      $query->withoutTenancy();
      $query->where(function ($query) use ($model) {
        $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
          ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
      });
    }
    
    return $query->first();
  }
  
  public function create($data)
  {

    $category = $this->model->create($data);
    //Event to ADD media

    event(new CreateMedia($category, $data));
    
    return $category;
  }
  
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
    
    event(new UpdateMedia($model, $data));//Event to Update media
    return $model ? $model->update((array)$data) : false;
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
    event(new DeleteMedia($model->id, get_class($model)));//Event to Delete media
    $model ? $model->delete() : false;
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
  
}

