<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

use Modules\Icommerce\Entities\Status;
use Modules\Icommerce\Jobs\BulkloadProducts;

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
        $this->model->with(['category','categories','tags','manufacturer','product_discounts'])->whereStatus(Status::ENABLED)->where('date_available','<=',date('Y-m-d'))->orderBy('created_at', 'DESC')->paginate(12);
    }

    public function find($id){
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
        is_array ($id) ? true : $id = [$id]; //verifica en $id sea un array

    	return $this->model->with(['category','categories','tags','manufacturer','product_discounts'])
            ->leftJoin('icommerce__product_category', 'icommerce__product_category.product_id', '=', 'icommerce__products.id')
            ->select('*','icommerce__products.id as id')
            ->whereIn('icommerce__product_category.category_id', $id)
            ->whereStatus(Status::ENABLED)->orderBy('icommerce__products.created_at', 'DESC')->paginate(12);
    }

    public function whereParentId($id)
    {
        return $this->model->with(['category','categories','tags','manufacturer','product_discounts'])
            ->whereStatus(Status::ENABLED)
            ->where('date_available','<=',date('Y-m-d'))
            ->where('parent_id', $id)
            ->orderBy('created_at', 'DESC')->paginate(12);

    }

    public function getProductBrother($parent_id, $id){
        return $this->model
            ->where('parent_id',$parent_id)
            ->where('id', '!=', $id)
            ->whereStatus(Status::ENABLED)
            ->get();
    }


    /**
     * Find featured products
     * @return mixed
     */

    public function whereFeaturedProducts($id) {

        is_array ($id) ? true : $id = [$id];

        return $this->model->with(['category','categories','tags','manufacturer','product_discounts'])
            ->leftJoin('icommerce__product_category', 'icommerce__product_category.product_id', '=', 'icommerce__products.id')
            ->whereIn('icommerce__product_category.category_id', $id)
            ->whereStatus(Status::ENABLED)->orderBy('icommerce__products.created_at', 'DESC')->get();

    }

    /***************************************************** PRODUCTS ICCOMER *****************************************/

    /* GET PRODUCT BY ID */
    public function findById($id){
        return $this->model->where('id',$id)->whereStatus(Status::ENABLED)->get();
    }

    /* FILTER RPRODUCTS BY CATEGORY*/
    public function whereCategoryFilter($id,$filter,$type)
    {
        is_array ($id) ? true : $id = [$id]; //verifica en $id sea un array

        $query = null;
        $query2 = null;

        //filtros
        $order = $filter['order'];
        $price = $filter['price'];
        $manufacturer = $filter['manufacturer'];

        $query = $this->model->with(['category','categories','tags','manufacturer','product_discounts'])
                            ->leftJoin('icommerce__product_category', 'icommerce__product_category.product_id',
                                       '=', 'icommerce__products.id')
                            ->whereIn('icommerce__product_category.category_id', $id)
                            ->select('*','icommerce__products.id as id')
                            ->whereStatus(Status::ENABLED)
                            ->orderBy('icommerce__products.'.$order->by, $order->type);

        if($manufacturer){ //si hay que filtrar por manufacturer
            $query->where('icommerce__products.manufacturer_id',$manufacturer);
        }
        if ($price) { //si hay que filtrar por rango de precio
            $query->whereBetween('icommerce__products.price', [$price->min, $price->max]);
        }

        //para poder generar dos consultas con los mismo filtros
        $query2 = $query;

        if($type=='paginate')
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
    public function findByName($criterion,$filter,$type)
    {
        $query = null;
        $query2 = null;

        //filtros
        $order = $filter['order'];
        $price = $filter['price'];
        $manufacturer = $filter['manufacturer'];

        $query = $this->model->with(['category','categories','tags','manufacturer','product_discounts'])
                      ->where(function ($query) use($criterion){
                          $query->where('title', 'like', "%$criterion%")
                                ->orWhere('sku', 'like', "%$criterion%");
                      })
                      ->whereStatus(Status::ENABLED)
                      ->orderBy($order->by, $order->type);

        if($manufacturer){ //si hay que filtrar por manufacturer
            $query->where('manufacturer_id',$manufacturer);
        }
        if ($price) { //si hay que filtrar por rango de precio
            $query->whereBetween('price', [$price->min, $price->max]);
        }

        //para poder generar dos consultas con los mismo filtros
        $query2 = $query;

        if($type=='paginate')
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
    public function findByNameShort($criterion){
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
    	return $this->model->with(['category','categories','tags','manufacturer','product_discounts'])
            ->where('freeshipping', 1)
            ->select('*','icommerce__products.id as id')
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

        $query = $this->model->with(['category','categories','tags','manufacturer','product_discounts'])
            ->where('freeshipping', 1)
            ->select('*','icommerce__products.id as id')
            ->whereStatus(Status::ENABLED)
            ->orderBy('icommerce__products.'.$order->by, $order->type);

        if($manufacturer){ //si hay que filtrar por manufacturer
            $query->where('icommerce__products.manufacturer_id',$manufacturer);
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
        is_array ($id) ? true : $id = [$id]; //verifica en $id sea un array

    	return $this->model->with(['category','categories','tags','manufacturer','product_discounts'])
            ->select('*','icommerce__products.id as id')
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

        $query = $this->model->with(['category','categories','tags','manufacturer','product_discounts'])
            ->select('*','icommerce__products.id as id')
            ->whereStatus(Status::ENABLED)
            ->orderBy('icommerce__products.'.$order->by, $order->type);

        if($manufacturer){ //si hay que filtrar por manufacturer
            $query->where('icommerce__products.manufacturer_id',$manufacturer);
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
}
