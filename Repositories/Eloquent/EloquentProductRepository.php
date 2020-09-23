<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Entities\Status;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Illuminate\Database\Eloquent\Builder;

//Events media

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepository
{
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['translations', 'store']);
        } else {//Especific relationships
            $includeDefault = ['translations', 'store'];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;//Short filter
  
          // add filter by search
          if (isset($filter->search) && !empty($filter->search)) {
            // removing symbols used by MySQL
            $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
            $filter->search = str_replace($reservedSymbols, " ", $filter->search);
            $words = explode(" ",$filter->search);//Explode
    
            //Validate words of minum 3 length
            foreach($words as $key => $word) {
              if(strlen($word) >= 3) {
                $words[$key] = '+' . $word . '*';
              }
            }
    
            //Search query
            $query->leftJoin(\DB::raw(
              "(SELECT MATCH (name) AGAINST ('(".implode(" ",$words).") (".$filter->search.")' IN BOOLEAN MODE) scoreSearch, product_id, name ".
              "from icommerce__product_translations ".
              "where `locale` = '{$filter->locale}') as ptrans"
            ),'ptrans.product_id','icommerce__products.id')
              ->where('scoreSearch','>', 0)
              ->orderBy('scoreSearch','desc');
    
            //Remove order by
            unset($filter->order);
          }
            //Filter by catgeory ID
          /*
            if (isset($filter->categoryId) && !empty($filter->categoryId)) {
                $query->where('category_id', $filter->categoryId);
            }
          */
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
              if($filter->stockStatus)
                $query->where('quantity', ">", 0);
              else{
                $query->where('quantity', "=", 0);
              }
            }

            //Filter by stock status
            if (isset($filter->status) && !empty($filter->status)) {
                if ($filter->status != null)
                    $query->where('status', $filter->status);
            }

            // add filter by Categories 1 or more than 1, in array
            if (isset($filter->categories) && !empty($filter->categories)) {
                is_array($filter->categories) ? true : $filter->categories = [$filter->categories];
                $query->whereIn('icommerce__products.id', function ($query) use ($filter) {
                    $query->select('product_id')
                        ->from('icommerce__product_category')
                        ->whereIn('category_id', $filter->categories);
                });
            }

            // add filter by Categories 1 or more than 1, in array
            if (isset($filter->optionValues) && !empty($filter->optionValues)) {
                is_array($filter->optionValues) ? true : $filter->optionValues = [$filter->optionValues];
                if(count($filter->optionValues)>0){
                    $query->whereHas('optionValues', function ($query) use ($filter) {
                        $query->whereIn("option_value_id",$filter->optionValues);
                    });
                }
            }//filter->optionValues

            if (isset($filter->store) && !empty($filter->store)) {
                $query->where('store_id', $filter->store);
            }

            //add filter by Manufacturers 1 or more than 1, in array
            if (isset($filter->manufacturers) && !empty($filter->manufacturers)) {
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
            if (isset($filter->freeshipping) && !empty($filter->freeshipping)) {
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
                if($orderByField=="slug"){
                  $query->join('icommerce__product_translations as translations', 'translations.product_id', '=', 'icommerce__products.id');
                  $query->orderBy('translations.slug',$orderWay);
                }else
                $query->orderBy($orderByField, $orderWay);//Add order to query
            }

            if (isset($filter->visible)&& !empty($filter->visible)) {
                $query->where("visible", $filter->visible);
            }
            
          if (isset($filter->featured)&& is_numeric($filter->featured)) {
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

            if( isset($filter->discount) && !empty($filter->discount)){
              $query->whereHas('discounts', function ($query) use ($filter)  {
                $now = date('Y-m-d');
                $query->whereDate('date_start', '>=', $now)
                  ->whereDate('date_end', '<=', $now);
              });
            }
        }
        
          if(isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin){
          
          }else{
          
            $query->where("date_available", "<=", date("Y-m-d",strtotime(now())));
          }
          
        

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        //dd($query->toSql());
        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false;//Take
            return $query->get();
        }
    }


    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include ?? [])) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = ['translations'];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include ?? []);
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
  
      if(isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin){
    
      }else{
    
        $query->where("date_available", "<=", date("Y-m-d",strtotime(now())));
      }
  
      
      /*== REQUEST ==*/
        return $query->first();
    }

    public function create($data)
    {
        $product = $this->model->create($data);

        if ($product) {

            // sync tables
            $product->categories()->sync(array_merge(array_get($data, 'categories', []), [$product->category_id]));

            if (isset($data['product_options']))
              $product->productOptions()->sync(array_get($data, 'product_options', []));

            if (isset($data['option_values']))
                $product->optionValues()->sync(array_get($data, 'option_values', []));
            if (isset($data['related_products']))
                $product->relatedProducts()->sync(array_get($data, 'related_products', []));

            /*
            if(isset($data['discounts']))
            $product->discounts()->sync(array_get($data, 'discounts', []));
*/
            if (isset($data['tags']))
                $product->setTags(array_get($data, 'tags', []));
        }

        //Event to ADD media
        event(new CreateMedia($product, $data));

        return $product;
    }

    public function update($model, $data)
    {

        $model->update($data);
  
      // sync tables
      $model->categories()->sync(array_merge(array_get($data, 'categories', []), [$model->category_id]));
        /*
        if (isset($data['product_options']))
        $model->productOptions()->sync(array_get($data, 'product_options', []));

        if (isset($data['option_values']))
            $model->optionValues()->sync(array_get($data, 'option_values', []));
        */
        if (isset($data['related_products']))
            $model->relatedProducts()->sync(array_get($data, 'related_products', []));


        if (isset($data['tags']))
            $model->setTags(array_get($data, 'tags', []));

        //Event to Update media
        event(new UpdateMedia($model, $data));

        return $model;
    }

    public function destroy($model)
    {

        //Event to Delete media
        event(new DeleteMedia($model->id, get_class($model)));

        return  $model->delete();

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


}
