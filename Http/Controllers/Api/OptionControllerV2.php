<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\BasePublicController;
use Illuminate\Routing\Controller;
use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Icommerce\Transformers\OptionTransformer;
use Log;

class OptionControllerV2 extends BasePublicController
{

    private $option;

    public function __construct(
        OptionRepository $option

    )
    {
        parent::__construct();
        $this->option = $option;
    }

    /**
     * @param Request $request
     * @return mixed
     */

     public function options(Request $request)
     {
         try {
             if (!isset($request->filters) && empty($request->filters)) {
                 $response = OptionTransformer::collection($this->option->all());
             } else {
                 $response = OptionTransformer::collection($this->option->whereFilters(json_decode($request->filters)));
             }
         } catch (\ErrorException $e) {
             \Log::error($e);
             $status = 500;
             $response = ['errors' => [
                 "code" => "501",
                 "source" => [
                     "pointer" => "api/v2/icommerce/options",
                 ],
                 "title" => "Error Option query",
                 "detail" => $e->getMessage()
             ]
             ];
         }
         return response()->json($response, $status ?? 200);
     }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
