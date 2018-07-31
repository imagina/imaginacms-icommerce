<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommerce\Entities\Category;
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



class CategoryControllerV2 extends BasePublicController
{
    /**
     * @var ProductRepository
     */

    private $product;
    private $category;
    protected $auth;
    private $notification;


    public function __construct(
        ProductRepository $product,
        CategoryRepository $category,
        Notification $notification

        )
    {
        parent::__construct();
        $this->product = $product;
        $this->category = $category;
        $this->auth = app(Authentication::class);
        $this->notification=$notification;
    }


    public function products(Request $request){

        try{
            if(!isset($request->filters) && empty($request->filters)){

                $response= CategoryTransformer::collection($this->category->all());


            }else{

                $response= CategoryTransformer::collection($this->category->whereFilters(json_decode($request->filters)));

            }

            $response = '';
        }catch (\ErrorException $e){
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => "api/icommerce/categories",
                ],
                "title" => "Value is too short",
                "detail" => "First name must contain at least three characters."
            ]
            ];
        }

        return response()->json($response,$status ?? 200);
    }




}
