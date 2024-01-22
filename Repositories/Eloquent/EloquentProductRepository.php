<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Illuminate\Support\Arr;
use Modules\Icommerce\Events\ProductWasCreated;
use Modules\Icommerce\Events\ProductWasUpdated;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Entities\Option;
use Modules\Icommerce\Entities\OptionValue;

class EloquentProductRepository extends EloquentCrudRepository implements ProductRepository
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
    'index' => ['category', 'translations', 'files', 'discount', 'organization'],
    'show' => ['category', 'categories', 'manufacturer', 'translations', 'files', 'productOptions', 'discount', 'organization'],
  ];
  
  
  /**
   * Filter query
   *
   * @param $query
   * @param $filter
   * @param $params
   * @return mixed
   */
  
  public function __construct($model)
  {
    try{
  
      parent::__construct($model);
      $priceListEnable = is_module_enabled('Icommercepricelist');
      
      if ($priceListEnable && !in_array('priceList', $this->includeToQuery)){
  
        $this->includeToQuery[] = 'priceLists';
        
      }
      if ($priceListEnable && !in_array('priceList', $this->includeInShowToQuery)){
  
        $this->includeInShowToQuery[] = 'priceLists';
        
      }
    }catch(\Exception $e){}
    
    
  }
  
  public function filterQuery($query, $filter, $params)
  {

    /**
     * Note: Add filter name to replaceFilters attribute before replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */
  
    // add filter by search
    if (isset($filter->search) && !empty($filter->search)) {
    
      $orderSearchResults = json_decode(setting("icommerce::orderSearchResults"));
    
      // removing symbols used by MySQL
      $filter->search = preg_replace("/[^Ñña-zA-Z0-9]+/", " ", $filter->search);
      $words = explode(" ", $filter->search);//Explode
    
      //Search query
      $query->leftJoin(\DB::raw(
        "(SELECT MATCH (" . implode(',', json_decode(setting('icommerce::selectSearchFieldsProducts'))) . ") AGAINST ('(\"" . $filter->search . "\")' IN BOOLEAN MODE) scoreSearch1, product_id, name, " .
        " MATCH (" . implode(',', json_decode(setting('icommerce::selectSearchFieldsProducts'))) . ") AGAINST ('(+" . $filter->search . "*)' IN BOOLEAN MODE) scoreSearch2 " .
        "from icommerce__product_translations " .
        "where `locale` = '" . ($filter->locale ?? locale()) . "') as ptrans"
      ), 'ptrans.product_id', 'icommerce__products.id')
        ->where(function ($query) {
          $query->where('scoreSearch1', '>', 0)
            ->orWhere('scoreSearch2', '>', 0);
        });
    
      foreach ($orderSearchResults ?? [] as $orderSearch) {
        $query->orderBy($orderSearch, 'desc');
      }
    
      //Remove order by
      unset($filter->order);
    }
  
  
    //Filter by catgeory ID
    if (isset($filter->category) && !empty($filter->category)) {
    
      $categories = Category::descendantsAndSelf($filter->category);
    
      if ($categories->isNotEmpty()) {
        $query->where(function ($query) use ($categories) {
          $query->whereRaw("icommerce__products.id IN (SELECT product_id from icommerce__product_category where category_id IN (" . (join(",", $categories->pluck("id")->toArray())) . "))")
            ->orWhereIn('icommerce__products.category_id', $categories->pluck("id"));
        });
      }
    }
  
    if (isset($filter->tagId)) {
      $query->whereTag($filter->tagId, "id");
    }
  
    // Filter by category SLUG
    if (isset($filter->categorySlug) && !empty($filter->categorySlug)) {
      $query->whereHas('categories', function ($query) use ($filter) {
        $query->whereHas('translations', function ($query) use ($filter) {
          $query
            ->where('icommerce__category_translations.locale', $filter->locale)
            ->where('icommerce__category_translations.slug', $filter->categorySlug);
        });
      });
    }
  
    //Filter by stock status
    if (isset($filter->stockStatus)) {
      if ($filter->stockStatus)
        $query->where('quantity', ">", 0);
      else {
        $query->where('quantity', "=", 0);
      }
    }
  
    // add filter by related product Ids
    if (isset($filter->related) && !empty($filter->related)) {
    
      //Check validation array
      is_array($filter->related) ? true : $filter->related = [$filter->related];
    
      //Query
      $query->whereIn('icommerce__products.id', $filter->related);
    
      // If categories exist, search for products in that category as well
      if (isset($filter->categories) && !empty($filter->categories)) {
      
        //Check validation array
        is_array($filter->categories) ? true : $filter->categories = [$filter->categories];
      
        //Query
        $query->orWhere(function ($query) use ($filter) {
          $query->whereRaw("icommerce__products.id IN (SELECT product_id from icommerce__product_category where category_id IN (" . (join(",", $filter->categories)) . "))")
            ->orWhereIn('icommerce__products.category_id', $filter->categories);
        });
      
      
        //Null so it doesn't take the category filter again
        $filter->categories = null;
      
        //Order by to include always related id products
        $query->orderByRaw("FIELD(id," . join($filter->related) . ") DESC, id DESC");
      
        //Null so it doesn't take the order filter again
        $filter->order = null;
      
      }
    }
  
    // add filter by Categories 1 or more than 1, in array/*
    if (isset($filter->categories) && !empty($filter->categories)) {
      is_array($filter->categories) ? true : $filter->categories = [$filter->categories];
      $query->where(function ($query) use ($filter) {
        $query->whereRaw("icommerce__products.id IN (SELECT product_id from icommerce__product_category where category_id IN (" . (join(",", $filter->categories)) . "))")
          ->orWhereIn('icommerce__products.category_id', $filter->categories);
      });
    
    
    }
  
    // add filter by Categories 1 or more than 1, in array
    if (isset($filter->optionValues) && !empty($filter->optionValues)) {
      is_array($filter->optionValues) ? true : $filter->optionValues = [$filter->optionValues];
      if (count($filter->optionValues) > 0) {
        $query->whereHas('optionValues', function ($query) use ($filter) {
          $query->whereIn("option_value_id", $filter->optionValues);
        });
      }
    }//filter->optionValues
  
    //add filter by Manufacturers 1 or more than 1, in array
    if (isset($filter->manufacturers) && !empty($filter->manufacturers)) {
      is_array($filter->manufacturers) ? true : $filter->manufacturers = [$filter->manufacturers];
      $query->whereIn("manufacturer_id", $filter->manufacturers);
    }
  
    // add filter by Tax Class 1 or more than 1, in array
    if (isset($filter->taxClass) && !empty($filter->taxClass)) {
      $query->whereIn("tax_class_id", $filter->taxClass);
    }
  
    // add filter by Price Range
    if (isset($filter->priceRange) && !empty($filter->priceRange)) {
      $query->where("price", '>=', $filter->priceRange->from);
      $query->where("price", '<=', $filter->priceRange->to);
    }
  
    // add filter by Rating
    if (isset($filter->rating) && !empty($filter->rating)) {
      $query->where("rating", '>=', $filter->rating->from);
      $query->where("rating", '<=', $filter->rating->to);
    }
  
    //Order by
    if (isset($filter->order) && !empty($filter->order)) {
      $orderByField = $filter->order->field ?? 'created_at';//Default field
      $orderWay = $filter->order->way ?? 'desc';//Default way
      if (in_array($orderByField, ["slug", "name"])) {
        $query->leftJoin('icommerce__product_translations as translations', 'translations.product_id', '=', 'icommerce__products.id');
        $query->orderBy("translations.{$orderByField}", $orderWay);
      } else
        $query->orderBy($orderByField, $orderWay);//Add order to query
    }
  
    if (isset($filter->visible) && !empty($filter->visible)) {
      $query->where("featured", $filter->visible);
    }
  
    if (isset($filter->soonToSoldOut) && !empty($filter->soonToSoldOut) && $filter->soonToSoldOut) {
      $query->where("quantity", "<=", setting("icommerce::productMinimumQuantityToNotify"))
        ->where("quantity", "!=", 0)
        ->where("subtract", 1);
    }
  
    if (isset($filter->withDiscount) && is_bool($filter->withDiscount) && $filter->withDiscount) {
    
      $query->has('discount');
    
    }
  
    if (isset($filter->productType) && !empty($filter->productType)) {
    
      $type = $filter->productType;
    
      if ($type == "searchable")
        $query->where("price", 0);
    
      if ($type == "affordable")
        $query->where("price", ">", 0);
    
    }
  
    if (isset($filter->exclude) && !empty($filter->exclude)) {
      $exclude = is_array($filter->exclude) ? $filter->exclude : [$filter->exclude];
      $query->whereNotIn('id', $exclude);
    }
  
    if (isset($filter->onlyWithOrganization)) {
      $query->whereNotNull("organization_id");
    }
  
    //Filter Used in Index - List Item - Wishlist
    if(isset($filter->wishlist)){
      $query->whereRaw("icommerce__products.id IN (SELECT wishlistable_id from  wishlistable__wishlistables WHERE wishlistable_type = 'Modules\\\Icommerce\\\Entities\\\Product' AND deleted_at is null AND wishlist_id = ".$filter->wishlist.")");
    }

    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {
    
    } else {
      
      //Pre filters by default
      $this->defaultPreFilters($query, $params);
    }
  
    //Order by "Sort order"
    if (!isset($params->filter->noSortOrder) || !$params->filter->noSortOrder) {
      $query->orderBy('sort_order', 'desc');//Add order to query
    }
  
    // ORDER
    if (isset($params->order) && $params->order) {
    
      $order = is_array($params->order) ? $params->order : [$params->order];
    
      foreach ($order as $orderObject) {
        if (isset($orderObject->field) && isset($orderObject->way)) {
          if (in_array($orderObject->field, $this->model->translatedAttributes)) {
            $query->orderByTranslation($orderObject->field, $orderObject->way);
          } else
            $query->orderBy($orderObject->field, $orderObject->way);
        }
      
      }
    }
  
    $entitiesWithCentralData = json_decode(setting("icommerce::tenantWithCentralData", null, "[]"));
    $tenantWithCentralData = in_array("products", $entitiesWithCentralData);
  
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
  
    if ($model) {
    
      // sync tables
      if (isset($data['categories']))
        $model->categories()->sync(array_merge(Arr::get($data, 'categories', []), [$model->category_id]));
    
      $priceListEnable = is_module_enabled('Icommercepricelist');
    
      if ($priceListEnable) {
        if (isset($data['price_lists']))
          $model->priceLists()->sync(Arr::get($data, 'price_lists', []));
      }
    
    
      if (isset($data['product_options']))
        $model->productOptions()->sync(Arr::get($data, 'product_options', []));
    
      if (isset($data['option_values']))
        $model->optionValues()->sync(Arr::get($data, 'option_values', []));
      if (isset($data['related_products']))
        $model->relatedProducts()->sync(Arr::get($data, 'related_products', []));
    
      if (isset($data['tags']))
        $model->setTags(Arr::get($data, 'tags', []));
    
    }
    
    //Response
    return $model;
  }
  
  public function defaultPreFilters($query, $params)
  {
    
    //Pre filters by default
    //pre-filter date_available
    $query->where(function ($query) {
      $query->where("date_available", "<=", date("Y-m-d", strtotime(now())));
      $query->orWhereNull("date_available");
    });
    
    //pre-filter status
    $query->where("status", 1);
    
    //pre-filter quantity and subtract
    $query->whereRaw("((stock_status = 0) or (subtract = 1 and quantity > 0) or (subtract = 0))");
    
    //pre-filter if the organization is enabled (organization status = 1)
    $query->where(function ($query) {
      $query->whereNull("organization_id")
        ->orWhereRaw("icommerce__products.organization_id IN (SELECT id from isite__organizations where status = 1)");
      
    });
    
    //old
    /*
   $query->whereRaw("icommerce__products.category_id IN (SELECT id from icommerce__categories where status = 1)");
   */
    
    /*
    * Se aplica esto xq cuando se utilizó con reservas, el producto no tenia
    categoria, entonces el carrito no lo obtenia
    */
    $query->where(function ($query) {
      $query->whereNull("category_id")
        ->orWhereRaw("icommerce__products.category_id IN (SELECT id from icommerce__categories where status = 1)");
    });
    
    /*
    * Se aplica para que el carrito pueda encontrar el producto a pesar
    de si el producto es "internal"
    */
    if (isset($params->filter) && !isset($params->filter->ValidationInternal)) {
      $query->where("is_internal", 0);
    }
    
  }
  
  public function create($data)
  {
    $model = parent::create($data); // TODO: Change the autogenerated stub
  
    event(new ProductWasCreated($model));
    
    return $model;
  
  }
  
  public function updateBy($criteria, $data, $params = false)
  {
    $model = parent::updateBy($criteria, $data, $params); // TODO: Change the autogenerated stub
  
    event(new ProductWasUpdated($model));
    
    return $model;
  }
  
  
  public function getPriceRange($params = false)
  {
    isset($params->take) ? $params->take = false : false;
    isset($params->page) ? $params->page = null : false;
    isset($params->include) ? $params->include = [] : false;
    isset($params->filter->priceRange) ? $params->filter->priceRange = null : false;
    if (isset($params->filter->order)) $params->filter->order = false;
    isset($params->filter) ? empty($params->filter) ? $params->filter = (object)["noSortOrder" => true] : $params->filter->noSortOrder = true : false;
    $params->returnAsQuery = true;
    $params->order = false;
    
    $query = $this->getItemsBy($params);
    $query->select(
      \DB::raw("MIN(icommerce__products.price) AS minPrice"),
      \DB::raw("MAX(icommerce__products.price) AS maxPrice")
    );
    
    if (isset($params->filter->search))
      $query->groupBy('scoreSearch1', 'product_id', 'name', 'scoreSearch2');
    
    return $query->first();
  }
  
  public function getManufacturers($params = false)
  {
    
    isset($params->take) ? $params->take = false : false;
    isset($params->page) ? $params->page = null : false;
    !isset($params->include) ? $params->include = [] : false;
    isset($params->filter->manufacturers) ? $params->filter->manufacturers = null : false;
    isset($params->order) ? $params->order = null : false;
    
    $params->returnAsQuery = true;
    
    $query = $this->getItemsBy($params);
    
    $query->has("manufacturer");
    
    $products = $query->get();
    
    $manufacturers = $products->pluck('manufacturer')->unique();
    $manufacturers->all();
    
    return $manufacturers;
    
  }
  
  public function getProductOptions($params = false)
  {
    
    isset($params->take) ? $params->take = false : false;
    isset($params->page) ? $params->page = null : false;
    !isset($params->include) ? $params->include = [] : false;
    isset($params->filter->optionValues) ? $params->filter->optionValues = null : false;
    isset($params->order) ? $params->order = null : false;
    
    $params->returnAsQuery = true;
    
    $query = $this->getItemsBy($params);
    
    $query->has("productOptions");
    
    $products = $query->get();
    
    $productsIds = $products->pluck("id")->toArray();
    
    $productOptions = Option::with('optionValues')->whereHas("products", function ($query) use ($productsIds) {
      $query->whereIn("icommerce__products.id", $productsIds);
    })->get();
    
    $productOptionValues = OptionValue::with("productOptionValues")
      ->whereHas("productOptionValues", function ($query) use ($productsIds) {
        $query->whereIn("product_id", $productsIds);
      })->get();
    
    $productOptionValuesIds = $productOptionValues->pluck('id');
    
    foreach ($productOptions as &$productOption) {
      $productOption->values = $productOption->optionValues->whereIn("id", $productOptionValuesIds);
    }
    
    return $productOptions;
    
  }
  
  public function getProductTypes($params = false)
  {
    
    isset($params->take) ? $params->take = false : false;
    isset($params->page) ? $params->page = null : false;
    !isset($params->include) ? $params->include = [] : false;
    isset($params->order) ? $params->order = null : false;
    
    $params->returnAsQuery = true;
    
    $query = $this->getItemsBy($params);
    
    $products = $query->get();
    
    // At least one product is searchable
    $searchable = $products->contains('is_call', 1);
    
    // At least one product is affordable
    $affordable = $products->contains('is_call', 0);
    
    $showFilter = false;
    if ($searchable && $affordable)
      $showFilter = true;
    
    return $showFilter;
    
  }
}
