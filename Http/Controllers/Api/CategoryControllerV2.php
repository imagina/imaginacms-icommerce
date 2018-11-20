<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Log;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Transformers\CategoryTransformer;
use Modules\Icommerce\Transformers\PriceTransformer;
use Modules\Icommerce\Transformers\ProductTransformer;
use Modules\Notification\Services\Notification;
use Modules\User\Contracts\Authentication;
use Route;


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
        $this->notification = $notification;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function categories(Request $request)
    {
        try {
            if (!isset($request->filters) && empty($request->filters)) {

                $response = CategoryTransformer::collection($this->category->all());
            } else {
                $response = CategoryTransformer::collection($this->category->whereFilters(json_decode($request->filters)));
            }
        } catch (\ErrorException $e) {
            \Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => "api/v2/icommerce/categories",
                ],
                "title" => "Error Category query",
                "detail" => $e->getMessage()
            ]
            ];
        }
        return response()->json($response, $status ?? 200);
    }

    /**
     * @param Category $category
     * @param Request $request
     * @return mixed
     */
    public function products(Category $category, Request $request)
    {

        try {
            if (!isset($request->filters) && empty($request->filters)) {

                $response = ProductTransformer::collection($this->product->whereFilters((object)$filter = ['categories' => $category->id]));

            } else {
                $filter = json_decode($request->filters);
                $filter->categories = $category->id;
                $response = ProductTransformer::collection($this->product->whereFilters($filter));

            }
        } catch (\ErrorException $e) {
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => "api/v2/icommerce/categories/" . $category->id . "/products",
                ],
                "title" => "Error Products Query",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * @param Category $category
     * @return mixed
     */
    public function category(Category $category){
        try {
            $response = new CategoryTransformer($category);
        } catch (\Exception $e) {
            \Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => "api/v2/icommerce/category",
                ],
                "title" => "Error Query Category",
                "detail" => $e->getMessage()
            ]
            ];
        }
        return response()->json($response, $status ?? 200);
    }


}
