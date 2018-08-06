<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Log;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Http\Requests\ProductRequest;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\CommentRepository;
use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Icommerce\Repositories\Order_ProductRepository;
use Modules\Icommerce\Repositories\PaymentRepository;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\ShippingRepository;
use Modules\Icommerce\Transformers\PriceTransformer;
use Modules\Icommerce\Transformers\ProductTransformer;
use Modules\Notification\Services\Notification;
use Modules\User\Contracts\Authentication;
use Route;


class ProductControllerV2 extends BasePublicController
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


    public function products(Request $request)
    {

        try {
            if (!isset($request->filters) && empty($request->filters)) {

                $response = ProductTransformer::collection($this->product->paginate($request->paginate ?? 12));

            } else {

                $response = ProductTransformer::collection($this->product->whereFilters(json_decode($request->filters)));

            }


        } catch (\ErrorException $e) {
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => "api/icommerce/products",
                ],
                "title" => "Value is too short",
                "detail" => "First name must contain at least three characters."
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    public function product(Product $product)
    {

        try {
            $response = new ProductTransformer($product);
        } catch (\Exception $e) {
            \Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => "api/icommerce/product",
                ],
                "title" => "Value is too short",
                "detail" => "First name must contain at least three characters."
            ]
            ];
        }
        return response()->json($response, $status ?? 200);
    }

    public function store(Request $request)
    {

        $response = $request;
        return response()->json($response, $status ?? 200);

    }


}
