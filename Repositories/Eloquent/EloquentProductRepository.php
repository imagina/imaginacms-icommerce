<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Entities\Order_Status;
use Modules\Icommerce\Entities\Status;
use Modules\Icommerce\Jobs\BulkloadProducts;
use Modules\Icommerce\Repositories\ProductRepository;

//use Modules\Icommerce\Events\ProductWasCreated;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepository
{

    /*
    public function create($data)
    {
        $product = $this->model->create($data);
        event(new ProductWasCreated($product, $data));
        return $product;
    }
    */

    public function all()
    {
       return $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])->whereStatus(Status::ENABLED)->where('date_available', '<=', date('Y-m-d'))->orderBy('order_weight','desc')->orderBy('created_at', 'DESC')->paginate(12);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findBySlug($slug)
    {
        return $this->model
            ->whereStatus(Status::ENABLED)
            ->where([
                ['date_available', '<=', date('Y-m-d')],
                ['slug', '=', $slug]
            ])
            ->firstOrFail();
    }


    public function whereCategory($id)
    {
        is_array($id) ? true : $id = [$id]; //verifica en $id sea un array

        return $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])
            ->leftJoin('icommerce__product_category', 'icommerce__product_category.product_id', '=', 'icommerce__products.id')
            ->select('*', 'icommerce__products.id as id')
            ->whereIn('icommerce__product_category.category_id', $id)
            ->whereStatus(Status::ENABLED)->orderBy('icommerce__products.order_weight','desc')->orderBy('icommerce__products.created_at', 'DESC')->paginate(12);
    }

    public function whereParentId($id)
    {
        return $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])
            ->whereStatus(Status::ENABLED)
            ->where('date_available', '<=', date('Y-m-d'))
            ->where('parent_id', $id)
            ->orderBy('order_weight','desc')
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
            ->whereStatus(Status::ENABLED)->orderBy('icommerce__products.order_weight','desc')->orderBy('icommerce__products.created_at', 'DESC')->get();

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
    public function whereFilters($filter)
    {
        try {
            $query = $this->model->with(['category', 'categories', 'tags', 'manufacturer', 'product_discounts'])
                ->select('*', 'icommerce__products.id as id');
            if (isset($filter->categories)) {
                is_array($filter->categories) ? true : $filter->categories = [$filter->categories];
                $query->leftJoin('icommerce__product_category', 'icommerce__product_category.product_id',
                    '=', 'icommerce__products.id')
                    ->whereIn('icommerce__product_category.category_id', $filter->categories);
            }
            if (isset($filter->manufacturer)) {
                is_array($filter->manufacturer) ? true : $filter->manufacturer = [$filter->manufacturer];
                $query->whereIn('icommerce__products.manufacturer_id', $filter->manufacturer);
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
                            $query->where('title', 'like', "%".$word."%");
                            $query->orWhere('sku', 'like', "%".$word."%");
                        } else {
                            $query->orWhere('title', 'like', "%".$word."%");
                            $query->orWhere('sku', 'like', "%".$word."%");
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
            if (isset($filter->parents)) { //si hay que filtrar por rango de precio
                $query->where('parent_id', $filter->parents);
            }

            if (isset($filter->order)) { //si hay que filtrar por rango de precio

                $orderby = $filter->order->by ?? 'created_at';
                $ordertype = $filter->order->type ?? 'desc';
            } else {
                $orderby = 'created_at';
                $ordertype = 'desc';
            }
            if (isset($filter->skip)) { //si hay que filtrar por rango de precio
                $query->skip($filter->skip ?? 0);
            }
            $query->orderBy('icommerce__products.' . $orderby, $ordertype);
            $query->whereStatus(Status::ENABLED);
            $query->where('date_available', '<=', date('Y-m-d'));

            if (isset($filter->take)) {
                $query->take($filter->take ?? 5);
                return $query->get();
            }elseif(isset($filter->paginate)&& is_integer($filter->paginate))
            {
                return $query->paginate($filter->paginate);
            }else{
                return $query->paginate(12);
            }

        } catch (\Exception $e) {
            \Log::Error($e);
            return $e->getMessage();
        }

    }
}
