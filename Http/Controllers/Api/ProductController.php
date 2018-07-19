<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Log;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\CommentRepository;
use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Icommerce\Repositories\Order_ProductRepository;
use Modules\Icommerce\Repositories\PaymentRepository;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\ShippingRepository;
use Modules\Icommerce\Transformers\CategoryTransformer;
use Modules\Icommerce\Transformers\PriceTransformer;
use Modules\Icommerce\Transformers\ProductTransformer;
use Modules\Notification\Services\Notification;
use Modules\User\Contracts\Authentication;
use Route;


class ProductController extends BasePublicController
{
    /**
     * @var ProductRepository
     */
    private $cart;
    private $product;
    private $currency;
    private $shipping;
    private $payments;
    private $category;
    protected $auth;
    private $notification;
    private $manufacturer;
    private $orderProducts;
    private $comments;

    public function __construct(
        ProductRepository $product,
        CurrencyRepository $currency,
        ShippingRepository $shipping,
        PaymentRepository $payments,
        CategoryRepository $category,
        Notification $notification,
        ManufacturerRepository $manufacturer,
        Order_ProductRepository $orderProduct,
        CommentRepository $comments
    )
    {
        parent::__construct();
        $this->product = $product;
        $this->currency = $currency;
        $this->shipping = $shipping;
        $this->payments = $payments;
        $this->category = $category;
        $this->auth = app(Authentication::class);
        $this->notification = $notification;
        $this->manufacturer = $manufacturer;
        $this->orderProducts = $orderProduct;
        $this->comments = $comments;
    }

    /* SEARCHER */
    public function products_search()
    {

        $criterion = $_GET['search'];
        $data = $this->product->findByNameShort($criterion);

        $result = ProductTransformer::collection($data);

        return json_decode(json_encode($result));
    }

    /* GET PRODUCTS FOR CATEGORY FOR SHOW ICOMMERCE*/
    public function products_category($category)
    {
        $manufacturer = [];
        $currency = $this->currency->getActive();

        $filter = [
            'order' => json_decode($_GET['order']),
            'price' => $_GET['price'] ? json_decode($_GET['price']) : false,
            'manufacturer' => $_GET['manufacturer'] ? json_decode($_GET['manufacturer']) : false
        ];

        if ($category !== '0') {// si consulta productos por categoria
            $products = $this->product->whereCategoryFilter($category, $filter, 'paginate'); //consulta
            $productsManufacturer = $this->product->whereCategoryFilter($category, $filter, 'get'); //consulta
        } else {// si consulta productos por busqueda
            $criterion = $_GET['criterion'];
            $products = $this->product->findByName($criterion, $filter, 'paginate'); //consulta
            $productsManufacturer = $this->product->findByName($criterion, $filter, 'get'); //consulta
        }

        /*obtiene los manufactures*/
        foreach ($productsManufacturer['data'] as $product) {
            $data = $product->manufacturer;
            $exist = false;
            if ($data) {
                foreach ($manufacturer as $key => $item) {
                    $item['id'] == $data->id ? $exist = true : false;
                    if ($key > 0) {
                        if ($manufacturer[$key - 1]->name > $item->name) {
                            $aux = $manufacturer[$key - 1];
                            $manufacturer[$key - 1] = $item;
                            $manufacturer[$key] = $aux;
                        }
                    }
                }
                $exist ? false : array_push($manufacturer, $data);
            }
        }

        for ($i = count($manufacturer) - 1; $i >= 0; $i--) {
            if ($i - 1 >= 0) {
                if ($manufacturer[$i]->name < $manufacturer[$i - 1]->name) {
                    $aux = $manufacturer[$i - 1];
                    $manufacturer[$i - 1] = $manufacturer[$i];
                    $manufacturer[$i] = $aux;
                }
            }
        }

        /*obtiene el precio mayor y menor de los productos selecionados*/
        $min_price = $products['range_price']['min_price'];
        $max_price = $products['range_price']['max_price'];

        return [
            'products' => ProductTransformer::collection($products['data']),
            'paginate' => $products['data'],
            'manufacturer' => $manufacturer,
            'range_price' => [
                'min_price' =>$min_price??0,
                'max_price' => $max_price?? 99999,
            ],
            'currency' => $currency,
        ];
    }

    /* GET PRODUCTS FOR CATEGORY FOR SHOW ICOMMERCE*/
    public function products_freeshipping()
    {
        $manufacturer = [];
        $currency = $this->currency->getActive();

        $filter = [
            'order' => json_decode($_GET['order']),
            'price' => $_GET['price'] ? json_decode($_GET['price']) : false,
            'manufacturer' => $_GET['manufacturer'] ? json_decode($_GET['manufacturer']) : false
        ];
        $products = $this->product->whereFreeshippingProductsFilter($filter); //consulta

        /*obtiene los manufactures*/
        foreach ($products['data'] as $product) {
            $data = $product->manufacturer;
            $exist = false;
            if ($data) {
                foreach ($manufacturer as $item) {
                    $item['id'] == $data->id ? $exist = true : false;
                }
                $exist ? false : array_push($manufacturer, $data);
            }
        }

        /*obtiene el precio mayor y menor de los productos selecionados*/
        $min_price = $products['range_price']['min_price'];
        $max_price = $products['range_price']['max_price'];

        return [
            'products' => ProductTransformer::collection($products['data']),
            'paginate' => $products['data'],
            'manufacturer' => $manufacturer,
            'range_price' => [
                'min_price' =>$min_price??0,
                'max_price' => $max_price?? 99999,
            ],
            'currency' => $currency,
        ];
    }

    /* GET PRODUCTS BY MANUFACTURER */
    public function products_by_manufacturer()
    {
        $manufacturer = [];
        $currency = $this->currency->getActive();

        $filter = [
            'order' => json_decode($_GET['order']),
            'price' => $_GET['price'] ? json_decode($_GET['price']) : false,
            'manufacturer' => $_GET['manufacturer'] ? json_decode($_GET['manufacturer']) : false
        ];
        $products = $this->product->whereManufacturerFilter($filter); //consulta

        /*obtiene los manufactures*/
        foreach ($products['data'] as $product) {
            $data = $product->manufacturer;
            $exist = false;
            if ($data) {
                foreach ($manufacturer as $item) {
                    $item['id'] == $data->id ? $exist = true : false;
                }
                $exist ? false : array_push($manufacturer, $data);
            }
        }

        /*obtiene el precio mayor y menor de los productos selecionados*/
        $min_price = $products['range_price']['min_price'];
        $max_price = $products['range_price']['max_price'];

        return [
            'products' => ProductTransformer::collection($products['data']),
            'paginate' => $products['data'],
            'manufacturer' => $manufacturer,
            'range_price' => [
                'min_price' =>$min_price??0,
                'max_price' => $max_price?? 99999,
            ],
            'currency' => $currency,
        ];
    }

    /* GET PRODUCT */
    public function product_id($id)
    {
        $product = $this->product->findById($id);
        $products_children = $product[0]->children;
        $products_parent = $product[0]->parent;
        $category = $product[0]->category;

        /* create breadcrumb */
        if ($category->parent != null) {
            $breadcrumb = collect([$category->parent]);
            $breadcrumb = $breadcrumb->concat(collect([$category]));
        } else {
            $breadcrumb = collect([$category]);
        }

        /* check sub products parent, brother, children */
        if ($products_parent != null) {
            $list = collect([$products_parent]);
            $list = $list->concat($products_parent->children)->concat($products_children);

            $list = ProductTransformer::collection($list);
        } else if ($products_children->count() > 0) {
            $list = $product;
            $list = $list->concat($products_children);

            $list = ProductTransformer::collection($list);
        } else {
            $list = false;
        }

        /* check children products*/
        count($product[0]->children) >= 1 ?
            $products_children = ProductTransformer::collection($products_children) :
            $products_children = false;

        /*get related products */
        $related_products = count($product[0]->related_ids) > 0 ?
            ProductTransformer::collection($product[0]->related_ids) : null;

        /*get comments product*/
        $product_comments = $this->comments->whereProductId($id);
        $count_comments = $this->comments->countAll();

        return [
            'product' => ProductTransformer::collection($product),
            'products_children' => $list,
            'related_products' => $related_products,
            'currency' => $this->currency->getActive(),
            'product_comments' => $product_comments,
            'count_comments' => $count_comments,
            'breadcrumb' => CategoryTransformer::collection($breadcrumb),
            //'gallery' => json_encode(productgallery($product[0]->id))
            //'product_parent' => $products_parent,
            //'products_brother' => $products_brother
        ];
    }

    /* GET PRODUCTS DEALS OF THE WEEK*/
    public function detals_category($category)
    {
        $products = $this->product->whereCategory($category);
        return [
            'product' => ProductTransformer::collection($products),
            'currency' => $this->currency->getActive()
        ];
    }

    /* GET PRODUCT COMMENTS */
    public function comments_product($id)
    {
        $product_comments = $this->comments->whereProductId($id);
        $count_comments = $this->comments->countAll();

        return [
            'product_comments' => $product_comments,
            'count_comments' => $count_comments
        ];
    }
}
