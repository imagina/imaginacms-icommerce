<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Entities\Order_Status;
use Modules\Icommerce\Entities\Status;
use Modules\Icommerce\Events\ProductWasCreated;
use Modules\Icommerce\Jobs\BulkloadProducts;
use Modules\Icommerce\Repositories\ProductRepository;


class EloquentProductRepository extends EloquentBaseRepository implements ProductRepository
{


    public function create($data)
    {
        $product = $this->model->create($data);
        event(new ProductWasCreated($product, $data));
        return $product;
    }

    public function all()
    {
        return $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])->whereStatus(Status::ENABLED)->where('date_available', '<=', date('Y-m-d'))->orderBy('order_weight', 'asc')->orderBy('created_at', 'DESC')->paginate(12);
    }

    public function find($id)
    {
        $query = $this->model->query();

        $query = $this->model->where('id', $id);

        $query->with(['category', 'categories', 'tags', 'manufacturer','product_discounts', 'product_option_values', 'product_option_values.option', 'product_option_values.option_value', 'optionsv']);

        return $query->first();
    }

    public function findBySlug($slug, $include = null)
    {
        $query = $this->model->query();


        $query = $this->model->where('slug', $slug);

        /*== RELATIONSHIPS ==*/
        if (count($include)) {
            //Include relationships for default
            $includeDefault = ['product_discounts', 'product_option_values', 'product_option_values.option', 'product_option_values.option_value', 'optionsv'];
            $query->with(array_merge($includeDefault, $include));
        }
        $query->where('date_available', '<=', date('Y-m-d'));
        $query->whereStatus(Status::ENABLED);
        /*=== REQUEST ===*/
        return $query->first();

    }

    public function whereCategory($id)
    {
        is_array($id) ? true : $id = [$id]; //verifica en $id sea un array

        return $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])
            ->leftJoin('icommerce__product_category', 'icommerce__product_category.product_id', '=', 'icommerce__products.id')
            ->select('*', 'icommerce__products.id as id')
            ->whereIn('icommerce__product_category.category_id', $id)
            ->whereStatus(Status::ENABLED)->orderBy('icommerce__products.order_weight', 'asc')->orderBy('icommerce__products.created_at', 'DESC')->paginate(12);
    }

    public function whereParentId($id)
    {
        return $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])
            ->whereStatus(Status::ENABLED)
            ->where('date_available', '<=', date('Y-m-d'))
            ->where('parent_id', $id)
            ->orderBy('order_weight', 'asc')
            ->orderBy('created_at', 'DESC')->paginate(12);

    }

    public function getProductBrother($parent_id, $id)
    {
        return $this->model
            ->where('parent_id', $parent_id)
            ->where('id', '!=', $id)
            ->whereStatus(Status::ENABLED)
            ->get();
    }


    /**
     * Find featured products
     * @return mixed
     */

    public function whereFeaturedProducts($id)
    {

        is_array($id) ? true : $id = [$id];

        return $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])
            ->leftJoin('icommerce__product_category', 'icommerce__product_category.product_id', '=', 'icommerce__products.id')
            ->whereIn('icommerce__product_category.category_id', $id)
            ->whereStatus(Status::ENABLED)->orderBy('icommerce__products.order_weight', 'asc')->orderBy('icommerce__products.created_at', 'DESC')->get();

    }

    /***************************************************** PRODUCTS ICCOMER *****************************************/

    /* GET PRODUCT BY ID */
    public function findById($id)
    {
        return $this->model->where('id', $id)->whereStatus(Status::ENABLED)->get();
    }

    /* FILTER RPRODUCTS BY CATEGORY*/
    public function whereCategoryFilter($id, $filter, $type)
    {
        is_array($id) ? true : $id = [$id]; //verifica en $id sea un array

        $query = null;
        $query2 = null;

        //filtros
        $order = $filter['order'];
        $price = $filter['price'];
        $manufacturer = $filter['manufacturer'];

        $query = $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])
            ->leftJoin('icommerce__product_category', 'icommerce__product_category.product_id',
                '=', 'icommerce__products.id')
            ->whereIn('icommerce__product_category.category_id', $id)
            ->select('*', 'icommerce__products.id as id')
            ->whereStatus(Status::ENABLED)
            ->orderBy('icommerce__products.' . $order->by, $order->type);

        if ($manufacturer) { //si hay que filtrar por manufacturer
            $query->where('icommerce__products.manufacturer_id', $manufacturer);
        }
        if ($price) { //si hay que filtrar por rango de precio
            $query->whereBetween('icommerce__products.price', [$price->min, $price->max]);
        }

        //para poder generar dos consultas con los mismo filtros
        $query2 = $query;

        if ($type == 'paginate')
            return $data = [
                'data' => $query->paginate(12), //retorna todos los productos
                'range_price' => $query2->selectRaw(
                    'MAX(icommerce__products.price) as max_price, MIN(icommerce__products.price) as min_price'
                )->first(),
                //obtiene el rango de precio
            ];
        else
            return $data = [
                'data' => $query->get(), //retorna todos los productos
                'range_price' => $query2->selectRaw(
                    'MAX(icommerce__products.price) as max_price, MIN(icommerce__products.price) as min_price'
                )->first(),
                //obtiene el rango de precio
            ];
    }


    /* SEARCHER */
    public function findByName($criterion, $filter, $type)
    {
        $query = null;
        $query2 = null;

        //filtros
        $order = $filter['order'];
        $price = $filter['price'];
        $manufacturer = $filter['manufacturer'];

        $query = $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])
            ->where(function ($query) use ($criterion) {
                $query->where('title', 'like', "%$criterion%")
                    ->orWhere('sku', 'like', "%$criterion%");
            })
            ->whereStatus(Status::ENABLED)
            ->orderBy($order->by, $order->type);

        if ($manufacturer) { //si hay que filtrar por manufacturer
            $query->where('manufacturer_id', $manufacturer);
        }
        if ($price) { //si hay que filtrar por rango de precio
            $query->whereBetween('price', [$price->min, $price->max]);
        }

        //para poder generar dos consultas con los mismo filtros
        $query2 = $query;

        if ($type == 'paginate')
            return $data = [
                'data' => $query->paginate(12), //retorna todos los productos
                'range_price' => $query2->selectRaw(
                    'MAX(price) as max_price, MIN(price) as min_price'
                )->first(), //obtiene el rango de precio
            ];
        else
            return $data = [
                'data' => $query->get(), //retorna todos los productos
                'range_price' => $query2->selectRaw(
                    'MAX(price) as max_price, MIN(price) as min_price'
                )->first(), //obtiene el rango de precio
            ];
    }

    /* SHORTY SEARCH */
    public function findByNameShort($criterion)
    {
        return $this->model
            ->whereStatus(Status::ENABLED)
            ->where('title', 'like', "%$criterion%")
            ->orWhere('sku', 'like', "%$criterion%")
            ->whereStatus(Status::ENABLED)
            ->take(5)
            ->get();
    }

    /* PRODUCTS FREE SHIPPING */
    public function whereFreeshippingProducts()
    {
        return $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])
            ->where('freeshipping', 1)
            ->select('*', 'icommerce__products.id as id')
            ->whereStatus(Status::ENABLED)
            ->orderBy('icommerce__products.created_at', 'DESC')->paginate(12);
    }

    /* PRODUCTS FREE SHIPPING FILTER */
    public function whereFreeshippingProductsFilter($filter)
    {
        $query = null;
        $query2 = null;

        //filtros

        $order = $filter['order'];
        $price = $filter['price'];
        $manufacturer = $filter['manufacturer'];

        //dd($this->model->where('freeshipping', 1)->get());

        $query = $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])
            ->where('freeshipping', 1)
            ->select('*', 'icommerce__products.id as id')
            ->whereStatus(Status::ENABLED)
            ->orderBy('icommerce__products.' . $order->by, $order->type)
            ->orderBy('icommerce__products.order_weight', 'asc');
        if ($manufacturer) { //si hay que filtrar por manufacturer
            $query->where('icommerce__products.manufacturer_id', $manufacturer);
        }
        if ($price) { //si hay que filtrar por rango de precio
            $query->whereBetween('icommerce__products.price', [$price->min, $price->max]);
        }

        //para poder generar dos consultas con los mismo filtros
        $query2 = $query;

        return $data = [
            'data' => $query->paginate(12), //retorna todos los productos
            'range_price' => $query2->selectRaw(
                'MAX(icommerce__products.price) as max_price, MIN(icommerce__products.price) as min_price'
            )->first(), //obtiene el rango de precio
        ];
    }

    public function whereManufacturer($id)
    {
        is_array($id) ? true : $id = [$id]; //verifica en $id sea un array

        return $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])
            ->select('*', 'icommerce__products.id as id')
            ->where('manufacturer_id', $id)
            ->whereStatus(Status::ENABLED)
            ->orderBy('icommerce__products.created_at', 'DESC')
            ->paginate(12);
    }

    /* PRODUCTS FREE SHIPPING FILTER */
    public function whereManufacturerFilter($filter)
    {
        $query = null;
        $query2 = null;

        //filtros

        $order = $filter['order'];
        $price = $filter['price'];
        $manufacturer = $filter['manufacturer'];

        $query = $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])
            ->select('*', 'icommerce__products.id as id')
            ->whereStatus(Status::ENABLED)
            ->orderBy('icommerce__products.' . $order->by, $order->type);

        if ($manufacturer) { //si hay que filtrar por manufacturer
            $query->where('icommerce__products.manufacturer_id', $manufacturer);
        }
        if ($price) { //si hay que filtrar por rango de precio
            $query->whereBetween('icommerce__products.price', [$price->min, $price->max]);
        }

        //para poder generar dos consultas con los mismo filtros
        $query2 = $query;

        return $data = [
            'data' => $query->paginate(12), //retorna todos los productos
            'range_price' => $query2->selectRaw(
                'MAX(icommerce__products.price) as max_price, MIN(icommerce__products.price) as min_price'
            )->first(), //obtiene el rango de precio
        ];
    }

    public function jobs_bulkload($data, $quantity, $info)
    {
        $pos = 0;
        $jobs_bulkload = [];
        $cant = (int)ceil(count($data) / $quantity);
        \Log::error($cant);
        for ($i = 1; $i <= $cant; $i++) {

            array_push($jobs_bulkload, array_slice($data, $pos, $quantity));
            $pos += $quantity;
        }
        foreach ($jobs_bulkload as $data) {
            BulkloadProducts::dispatch($data, $info);
        }


    }


    /**
     * @param object $filter
     * @return mixed
     */
    public function whereFilters($page, $take, $filter, $include)
    {
        try {
            $query = $this->model->query();

            /*== RELATIONSHIPS ==*/
            if (count($include)) {
                //Include relationships for default
                $includeDefault = ['product_discounts', 'product_option_values', 'product_option_values.option', 'product_option_values.option_value', 'optionsv'];
                $query->with(array_merge($includeDefault, $include));
            }

            $query->select('*', 'icommerce__products.id as id');

            if ($filter) {

                if (isset($filter->categories)) {
                  is_array($filter->categories) ? true : $filter->categories = [$filter->categories];
                  $query->whereIn('icommerce__products.id', function($query) use($filter){
                    $query->select('product_id')
                    ->from('icommerce__product_category')
                    ->whereIn('category_id',$filter->categories);
                  });
                }
                if (isset($filter->options)) {
                  is_array($filter->options) ? true : $filter->options = [$filter->options];
                  $query->whereIn('icommerce__products.id', function($query) use($filter){
                    $query->select('product_id')
                    ->from('icommerce__product_option')
                    ->whereIn('option_id',$filter->options);
                  });
                }
                if (isset($filter->options_values)) {
                  is_array($filter->options_values) ? true : $filter->options_values = [$filter->options_values];
                  $query->whereIn('icommerce__products.id', function($query) use($filter){
                    $query->select('product_id')
                    ->from('icommerce__product_option_values')
                    ->whereIn('option_value_id',$filter->options_values);
                  });
                }
                if (isset($filter->manufacturers)) {
                    is_array($filter->manufacturers) ? true : $filter->manufacturers = [$filter->manufacturer];
                    $query->whereIn('icommerce__products.manufacturer_id', $filter->manufacturers);
                }
                if (isset($filter->price)) { //si hay que filtrar por rango de precio
                    $price = $filter->price;
                    $query->whereBetween('icommerce__products.price', [$price->min ?? 0, $price->max ?? 9999999999999999]);
                }

                if (isset($filter->freeshipping)) { //si hay que filtrar por rango de precio

                    $query->where('freeshipping', 1);
                }
                if (isset($filter->search)) { //si hay que filtrar por rango de precio
                    $criterion = $filter->search;
                    $param = explode(' ', $criterion);
                    $query->where(function ($query) use ($param) {
                        foreach ($param as $index => $word) {
                            if ($index == 0) {
                                $query->where('title', 'like', "%" . $word . "%");
                                $query->orWhere('sku', 'like', "%" . $word . "%");
                            } else {
                                $query->orWhere('title', 'like', "%" . $word . "%");
                                $query->orWhere('sku', 'like', "%" . $word . "%");
                            }
                        }

                    });
                }
                if (isset($filter->recent)) { //si hay que filtrar por rango de precio

                    $query->where('date_available', '<=', date('Y-m-d'));
                }
                if (isset($filter->discounts)) { //si hay que filtrar por rango de precio

                    $query->leftJoin('icommerce__product_discounts', 'icommerce__product_discounts.product_id', '=', 'icommerce__products.id');
                }
                if (isset($filter->bestsellers)) { //si hay que filtrar por rango de precio

                    $query->leftJoin('icommerce__order_product', 'icommerce__order_product.product_id', '=', 'icommerce__products.id')
                        ->leftJoin('icommerce__orders', 'icommerce__order_product.order_id', '=', 'icommerce__orders.id')
                        ->where('icommerce__orders.order_status', Order_Status::PROCESSING);
                }
                if (isset($filter->parent)) { //si hay que filtrar por rango de precio
                    $query->where('parent_id', $filter->parent);
                }


                if (isset($filter->skip)) { //si hay que filtrar por rango de precio
                    $query->skip($filter->skip ?? 0);
                }

                /* Filter strictOptionValues 
                This filter was necessary since there are products in which you need to filter
                 by a product that contains all the values ​​of sent options and not at least
                  one of them (What the whereIn does)
                ´*/
                $articlesId=[];
                if(isset($filter->strictOptionValues) && isset($filter->options_values)){
                  $articles=$query->get();
                  foreach($articles as $article){
                    $countOptions=count($filter->options_values);
                    foreach($filter->options_values as $optValue){
                      foreach($article->product_option_values as $productOptValue){
                        if((int)$productOptValue->option_value_id==(int)$optValue){
                          $countOptions--;
                          break;
                        }
                      }
                    }
                    if($countOptions==0)
                    $articlesId[]=$article->id;
                  }
                  $query = $this->model->query();
                  $query->whereIn('id',$articlesId);
                }

                $query->whereStatus(Status::ENABLED);
                $query->where('date_available', '<=', date('Y-m-d'));

                $orderBy = isset($filter->orderBy) ? $filter->orderBy : 'created_at';
                $orderType = isset($filter->orderType) ? $filter->orderType : 'desc';
                $query->orderBy('icommerce__products.' . $orderBy, $orderType);
            }
            /*=== REQUEST ===*/
            if ($page) {//Return request with pagination
                $take ? true : $take = 12; //If no specific take, query default take is 12
                return $query->paginate($take);
            } else {//Return request without pagination
                $take ? $query->take($take) : false; //Set parameter take(limit) if is requesting
                return $query->get();
            }

        } catch (\Exception $e) {


            \Log::Error($e);

            return $e->getMessage();

        }

    }
    public function category($id){
        return $this->model->whereStatus(Status::ENABLED)->where('category_id',$id)->get();
    }
}
