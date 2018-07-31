<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Http\Controllers\BasePublicController;
use Route;
use Log;
use Illuminate\Http\Request;
use Modules\User\Contracts\Authentication;
use Illuminate\Routing\Controller;


use Modules\Notification\Services\Notification;

use Modules\Icommerce\Http\Requests\CreateProductRequest;

use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Icommerce\Repositories\ShippingRepository;
use Modules\Icommerce\Repositories\PaymentRepository;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Icommerce\Repositories\Order_ProductRepository;
use Modules\Icommerce\Repositories\CommentRepository;
use Modules\Icommerce\Transformers\ProductTransformer;
use Modules\Icommerce\Transformers\PriceTransformer;



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
        $this->notification=$notification;
        $this->manufacturer = $manufacturer;
        $this->orderProducts = $orderProduct;
        $this->comments = $comments;
    }


    public function products(Request $request){

//$filters=['categories'=>139,'take'=>5, 'paginate'=>12,];
  //dd(json_encode($filters));
//dd(json_decode($request->filters));
        try{
            if(!isset($request->filters) && empty($request->filters)){

                $response =  ProductTransformer::collection($this->product->paginate($request->paginate??12));

            }else{

                $response =  ProductTransformer::collection($this->product->whereFilters(json_decode($request->filters)));

            }

        }catch (\ErrorException $e){
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

        return response()->json($response,$status ?? 200);
    }




}
