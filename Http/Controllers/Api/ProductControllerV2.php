<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Log;
use Modules\Core\Http\Controllers\BasePublicController;
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


    /**
     * @param Request $request
     * @return mixed
     */
    public function products(Request $request)
    {

        try {
            if (!isset($request->filters) && empty($request->filters)) {

                $results = $this->product->paginate($request->paginate ?? 12);
                $response = [
                    'meta' => [
                        "total-pages" => $results->lastPage(),
                        "per_page" => $results->perPage(),
                        "total-item" => $results->total()
                    ],
                    'data' => ProductTransformer::collection($results),
                    'links' => [
                        "self" => $results->currentPage(),
                        "first" => $results->hasMorePages(),
                        "prev" => $results->previousPageUrl(),
                        "next" => $results->nextPageUrl(),
                        "last" => $results->lastPage()
                    ]

                ];

            } else {
                $filters = json_decode($request->filters);
                $results = ProductTransformer::collection($this->product->whereFilters($filters));

                if (isset($filters->paginate)) {
                    $response = [
                        'meta' => [
                            "total-pages" => $results->lastPage(),
                            "per_page" => $results->perPage(),
                            "total-item" => $results->total()
                        ],
                        'data' => ProductTransformer::collection($results),
                        'links' => [
                            "self" => $results->currentPage(),
                            "first" => $results->hasMorePages(),
                            "prev" => $results->previousPageUrl(),
                            "next" => $results->nextPageUrl(),
                            "last" => $results->lastPage()
                        ]

                    ];
                } else {
                    $response = [
                        'meta' => [
                            "take" => $filters->take ?? 5,
                            "skip" => $filters->skip ?? 0,
                        ],
                        'data' => ProductTransformer::collection($results),
                    ];
                }
            }


        } catch (\ErrorException $e) {
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
     * @param Product $product
     * @return mixed
     */
    public function product(Product $product, Request $request)
    {

        try {
            if (isset($product)) {
                if (isset($filters->take)) {
                    $response = [
                        'type'=>'article',
                        'id'=>$product->id,
                        'data' => new ProductTransformer($product),
                    ];
                }
                $response = new ProductTransformer($product);
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
