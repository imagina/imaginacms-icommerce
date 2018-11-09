<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Log;
use Modules\Icommerce\Entities\Product;
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
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Notification\Services\Notification;
use Modules\User\Contracts\Authentication;
use Route;


class ProductControllerV2 extends BaseApiController
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


    /**
     * @param Request $request
     * @return mixed
     */
    public function products(Request $request)
    {

        try {
            $p = $this->parametersUrl(1, 12, false, []);

            //Request to Repository
            $results = $this->product->whereFilters($p->page, $p->take, $p->filter, $p->include);

            //Response
            $response = ["meta" => [], "data" => ProductTransformer::collection($results)];

            //If request pagination add meta-page
            $p->page ? $response["meta"] = ["page" => $this->pageTransformer($results)] : false;
        } catch (\Exception $e) {
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Producs",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);

    }

    /**
     * @param slug
     * @return mixed
     */
    public function show($slug, Request $request)
    {

        try {
            $p = $this->parametersUrl(false, false, false, []);

            //Request to Repository
            $product = $this->product->findBySlug($slug, $p->include);
            if (!isset($product) && empty($product)) {
                $status = 404;
                $response = [
                    'errors' =>
                        [
                            "code" => "404",
                            "source" => [
                                "pointer" => url($request->path()),
                            ],
                            "title" => "Not Fount",
                            "detail" => "The product not fount"
                        ]
                ];
            } else {
                $response = [
                    'type' => 'product',
                    'id' => $product->id,
                    "data" => new ProductTransformer($product)
                ];
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $status = 500;
            $response = [
                'errors' =>
                    [
                        "code" => "501",
                        "source" => [
                            "pointer" => url($request->path()),
                        ],
                        "title" => "Value is too short",
                        "detail" => $e->getMessage()
                    ]
            ];
        }
        return response()->json($response, $status ?? 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */

    public function product($id, Request $request)
    {

        try {
            $request['include']="category,categories,manufacturer";
            $product=$this->product->find($id);
            if (isset($product)) {

                $response = [
                    'type' => 'product',
                    'id' => $product->id,
                    'data' => new ProductTransformer($product),
                ];

            } else {
                $status = 404;
                $response = ['errors' => [
                    "code" => "404",
                    "source" => [
                        "pointer" => url($request->path()),
                    ],
                    "title" => "Not Fount",
                    "detail" => "The product not fount"
                ]
                ];
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Value is too short",
                "detail" => "First name must contain at least three characters."
            ]
            ];
        }
        return response()->json($response, $status ?? 200);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try {
            $options = (array)$request->options ?? array();
            isset($request->metatitle) ? $options['metatitle'] = $request->metatitle : false;
            isset($request->metadescription) ? $options['metadescription'] = $request->metatitle : false;
            $request['options'] = $options;
            $product = $this->product->create($request->all());
            $response = [
                'success' => [
                    'code' => '200',
                    'source' => [
                        'pointer' => url($request->path())
                    ],
                    "title" => trans('core::core.messages.resource created', ['name' => trans('icommerce::products.title.products')]),
                    "detail" => [
                        'id' => $product->id
                    ]
                ]
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Value is too short",
                "detail" => "First name must contain at least three characters."
            ]
            ];
        }


        return response()->json($response, $status ?? 200);

    }


}
