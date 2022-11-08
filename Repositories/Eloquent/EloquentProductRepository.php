<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Entities\Option;
use Modules\Icommerce\Entities\OptionValue;
use Modules\Icommerce\Entities\ProductableEntity;
use Modules\Icommerce\Entities\Status;
use Modules\Icommerce\Events\ProductWasCreated;
use Modules\Icommerce\Events\ProductWasUpdated;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
//Events media

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepository
{
  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();
    $priceListEnable = is_module_enabled('Icommercepricelist');

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
        $includeDefault = ['category','translations','files','discount','organization'];
        if($priceListEnable)
            $includeDefault[] = 'priceLists';
        $query->with($includeDefault);
    } else {//Especific relationships
        $includeDefault = ['category','translations','files','discount','organization'];//Default relationships
        if (isset($params->include))//merge relations with default relationships
            $includeDefault = array_merge($includeDefault, $params->include ?? []);
        if($priceListEnable){
          $includeDefault[] = 'priceLists';
        }
        else{
          //removing priceList if exist in the include
          if (($key = array_search('priceLists', $includeDefault)) !== false) {
            unset($includeDefault[$key]);
          }
        }
        $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter

      // add filter by search
      if (isset($filter->search) && !empty($filter->search)) {
        // removing symbols used by MySQL
        $filter->search = preg_replace("/[^a-zA-Z0-9]+/", " ", $filter->search);
        $words = explode(" ", $filter->search);//Explode

        //Validate words of minum 3 length
        foreach ($words as $key => $word) {
          if (strlen($word) >= 3) {
            $words[$key] = '+' . $word . '*';
          }
        }

        //Search query
        $query->leftJoin(\DB::raw(
          "(SELECT MATCH (name) AGAINST ('(" . implode(" ", $words) . ") (" . $filter->search . ")' IN BOOLEAN MODE) scoreSearch, product_id, name " .
          "from icommerce__product_translations " .
          "where `locale` = '{$filter->locale}') as ptrans"
        ), 'ptrans.product_id', 'icommerce__products.id')
          ->where('scoreSearch', '>', 0)
          ->orderBy('scoreSearch', 'desc');

        //Remove order by
        unset($filter->order);
      }
      //Filter by catgeory ID
      if (isset($filter->category) && !empty($filter->category)) {
	
				$categories = Category::descendantsAndSelf($filter->category);
	
				if ($categories->isNotEmpty()) {
						$query->where(function ($query) use ($categories) {
							$query->whereRaw("icommerce__products.id IN (SELECT product_id from icommerce__product_category where category_id IN (".(join(",",$categories->pluck("id")->toArray()))."))")
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

      if (isset($filter->storeSlug) && is_module_enabled('Marketplace')) {
        $query->whereHas('store', function ($query) use ($filter) {
          $query->whereHas('translations', function ($query) use ($filter) {
            $query
              ->where('marketplace__store_translations.locale', $filter->locale)
              ->where('marketplace__store_translations.slug', $filter->storeSlug);
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


      //Filter by stock status
      if (isset($filter->status)) {

        $query->where('status', ($filter->status ? 1 : 0));
      }

      if (isset($filter->id) && !empty($filter->id)) {
        is_array($filter->id) ? true : $filter->id = [$filter->id];
        $query->whereIn('icommerce__products.id', $filter->id);
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
          $query->orWhere(function ($query) use ($filter){
            $query->whereRaw("icommerce__products.id IN (SELECT product_id from icommerce__product_category where category_id IN (".(join(",",$filter->categories))."))")
            ->orWhereIn('icommerce__products.category_id', $filter->categories);
          });
          

          //Null so it doesn't take the category filter again
          $filter->categories = null;

          //Order by to include always related id products
          $query->orderByRaw("FIELD(id,".join($filter->related).") DESC, id DESC");

          //Null so it doesn't take the order filter again
          $filter->order = null;

        }
        

      }

      // add filter by Categories 1 or more than 1, in array/*
      if (isset($filter->categories) && !empty($filter->categories)) {
				is_array($filter->categories) ? true : $filter->categories = [$filter->categories];
				$query->where(function ($query) use ($filter){
					$query->whereRaw("icommerce__products.id IN (SELECT product_id from icommerce__product_category where category_id IN (".(join(",",$filter->categories))."))")
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

      if (isset($filter->store) && !empty($filter->store)) {
        $query->where('store_id', $filter->store);
      }

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

      // add filter by Freeshipping
      if (isset($filter->freeshipping) && !empty($filter->freeshipping) && $filter->freeshipping) {
        $query->where("freeshipping", $filter->freeshipping);
      }

      //Filter by date
      if (isset($filter->date) && !empty($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
      }

      //Order by
      if (isset($filter->order) && !empty($filter->order)) {
        $orderByField = $filter->order->field ?? 'created_at';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        if (in_array($orderByField, ["slug","name"])) {
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
        ->where("quantity","!=",0)
        ->where("subtract",1);
      }

      if (isset($filter->featured) && is_bool($filter->featured)) {
        $query->where("featured", $filter->featured);
      }
      if (isset($filter->rating) && !empty($filter->rating)) {
        $rating = $filter->rating;
        if ($rating === 'top') {
          $query->orderBy('sum_rating', 'desc');
        }
        if ($rating === 'worst') {
          $query->orderBy('sum_rating', 'asc');
        }
      }

      if (isset($filter->withDiscount) && is_bool($filter->withDiscount) && $filter->withDiscount) {

        $query->has('discount');

      }

      if(isset($filter->productType) && !empty($filter->productType)){

        $type = $filter->productType;

        if($type=="searchable")
          $query->where("price",0);

        if($type=="affordable")
          $query->where("price",">",0);

      }

      if (isset($filter->isCall)) {
        $query->where("is_call", $filter->isCall);
      }

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


    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);
    //if(isset($filter->search))
    //\Log::info([$query->toSql(),$query->getBindings()]);

	  //	return $query->get();
    /*== REQUEST ==*/
    if (isset($params->onlyQuery) && $params->onlyQuery) {
      return $query;
    } else
      if (isset($params->page) && $params->page) {
        //return $query->paginate($params->take);
        return $query->paginate($params->take, ['*'], null, $params->page);
      } else {
        isset($params->take) && $params->take ? $query->take($params->take) : false;//Take
        return $query->get();
      }
  }
  
  public function defaultPreFilters($query, $params){
	
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
	
		$query->whereRaw("icommerce__products.category_id IN (SELECT id from icommerce__categories where status = 1)");
	}
	
  public function getItem($criteria, $params = false)
  {

    //Initialize query
    $query = $this->model->query();
    $priceListEnable = is_module_enabled('Icommercepricelist');

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
        $includeDefault = ['category','categories','manufacturer','translations','files','productOptions','discount','organization'];
        if($priceListEnable)
            $includeDefault[] = 'priceLists';
        $query->with($includeDefault);
    } else {//Especific relationships
      $includeDefault = ['category','categories','manufacturer','translations','files','productOptions','discount'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include ?? []);
      if($priceListEnable){
        $includeDefault[] = 'priceLists';
      }
      else{
        //removing priceList if exist in the include
        if (($key = array_search('priceLists', $includeDefault)) !== false) {
          unset($includeDefault[$key]);
        }
      }
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      // find translatable attributes
      $translatedAttributes = $this->model->translatedAttributes;

      if (isset($filter->field))
        $field = $filter->field;

      //Filter by catgeory ID
      if (isset($filter->categoryId) && $filter->categoryId) {
        $query->where('category_id', $filter->categoryId);
      }

      // Filter by category SLUG
      if (isset($filter->categorySlug)) {
        $query->whereHas('categories', function ($query) use ($filter) {
          $query->whereHas('translations', function ($query) use ($filter) {
            $query
              ->where('icommerce__category_translations.slug', $filter->categorySlug);
          });
        });
      }

      if (isset($filter->store)) {
        $query->where('store_id', $filter->store);
      }

      // filter by translatable attributes
      if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
        $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
          $query->where('locale', $filter->locale ?? \App::getLocale())
            ->where($field, $criteria);
        });
      else
        // find by specific attribute or by id
        $query->where($field ?? 'id', $criteria);

    }

    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {

    } else {

      //Pre filters by default
      //pre-filter date_available
			//Pre filters by default
			$this->defaultPreFilters($query, $params);

    }

    if (!isset($params->filter->field)) {
      $query->where('id', $criteria);
    }
  
    $entitiesWithCentralData = json_decode(setting("icommerce::tenantWithCentralData",null,"[]"));
    $tenantWithCentralData = in_array("products",$entitiesWithCentralData);
  
    if ($tenantWithCentralData && isset(tenant()->id)) {
      $model = $this->model;
    
      $query->withoutTenancy();
      $query->where(function ($query) use ($model) {
        $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
          ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
      });
    }

    /*== REQUEST ==*/
    return $query->first();

  }

  public function create($data)
  {
    $product = $this->model->create($data);

    if ($product) {

      // sync tables
      if (isset($data['categories']))
        $product->categories()->sync(array_merge(Arr::get($data, 'categories', []), [$product->category_id]));

      $priceListEnable = is_module_enabled('Icommercepricelist');

      if($priceListEnable) {
          if (isset($data['price_lists']))
              $product->priceLists()->sync(Arr::get($data, 'price_lists', []));
      }


      if (isset($data['product_options']))
        $product->productOptions()->sync(Arr::get($data, 'product_options', []));

      if (isset($data['option_values']))
        $product->optionValues()->sync(Arr::get($data, 'option_values', []));
      if (isset($data['related_products']))
        $product->relatedProducts()->sync(Arr::get($data, 'related_products', []));

      if (isset($data['tags']))
        $product->setTags(Arr::get($data, 'tags', []));

    }

    //Event to ADD media
    event(new CreateMedia($product, $data));

    event(new ProductWasCreated($product));

    return $product;
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

    if ($model) {
        $model->update($data);

        // sync tables
        $model->categories()->sync(array_merge(Arr::get($data, 'categories', []), [$model->category_id]));

        $priceListEnable = is_module_enabled('Icommercepricelist');

        if ($priceListEnable) {
            if (isset($data['price_lists']))
                $model->priceLists()->sync(Arr::get($data, 'price_lists', []));
        }


        if (isset($data['related_products']))
            $model->relatedProducts()->sync(Arr::get($data, 'related_products', []));


        if (isset($data['tags']))
            $model->tags()->sync(Arr::get($data, 'tags', []));

        //Event to Update media
        event(new UpdateMedia($model, $data));

        event(new ProductWasUpdated($model));
        return $model;
    }

    return false;
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

    //Event to Delete media

    if(isset($model->id))
      event(new DeleteMedia($model->id, get_class($model)));
  }

  /**
   * @inheritdoc
   */
  public function findBySlug($slug)
  {
    if (method_exists($this->model, 'translations')) {
      return $this->model->whereHas('translations', function (Builder $q) use ($slug) {
        $q->where('slug', $slug);
      })->with('translations', 'category', 'categories', 'tags', 'addedBy')->whereStatus(Status::ENABLED)->firstOrFail();
    }

    return $this->model->where('slug', $slug)->with('category', 'categories', 'tags', 'addedBy')->whereStatus(Status::ENABLED)->firstOrFail();;
  }

  public function whereCategory($id)
  {
    $query = $this->model->with('categories', 'category', 'tags', 'addedBy', 'translations');
    $query->whereHas('categories', function ($q) use ($id) {
      $q->where('category_id', $id);
    })->whereStatus(Status::ENABLED)->where('created_at', '<', date('Y-m-d H:i:s'))->orderBy('created_at', 'DESC');

    return $query->paginate(setting('icommerce::product-per-page'));
  }

  public function getPriceRange($params = false)
  {
    isset($params->take) ? $params->take = false : false;
    isset($params->page) ? $params->page = null : false;
    isset($params->include) ? $params->include = [] : false;
    isset($params->filter->priceRange) ? $params->filter->priceRange = null : false;
    if (isset($params->filter->order)) $params->filter->order = false;
    isset($params->filter) ? empty($params->filter) ? $params->filter = (object)["noSortOrder" => true] : $params->filter->noSortOrder = true : false;
    $params->onlyQuery = true;
    $params->order = false;

    $query = $this->getItemsBy($params);
    $query->select(
      \DB::raw("MIN(icommerce__products.price) AS minPrice"),
      \DB::raw("MAX(icommerce__products.price) AS maxPrice")
    );

    return $query->first();
  }

  public function getManufacturers($params = false)
  {

    isset($params->take) ? $params->take = false : false;
    isset($params->page) ? $params->page = null : false;
    !isset($params->include) ? $params->include = [] : false;
    isset($params->filter->manufacturers) ? $params->filter->manufacturers = null : false;
    isset($params->order) ? $params->order = null : false;

    $params->onlyQuery = true;

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

    $params->onlyQuery = true;

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

    $params->onlyQuery = true;

    $query = $this->getItemsBy($params);

    $products = $query->get();

    // At least one product is searchable
    $searchable = $products->contains('is_call', 1);

    // At least one product is affordable
    $affordable = $products->contains('is_call',0);

    $showFilter = false;
    if($searchable && $affordable)
       $showFilter = true;

    return $showFilter;

  }

}
