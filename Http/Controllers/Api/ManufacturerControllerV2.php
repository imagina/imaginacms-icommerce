<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Log;
use Modules\Icommerce\Entities\Manufacturer;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Icommerce\Transformers\ManufacturerTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Notification\Services\Notification;
use Modules\User\Contracts\Authentication;
use Route;


class ManufacturerControllerV2 extends BaseApiController
{
    /**
     * @var ManufacturerRepository
     */
    protected $auth;
    private $notification;
    private $manufacturer;
    

    public function __construct(
      
        Notification $notification,
        ManufacturerRepository $manufacturer
    )
    {
        parent::__construct();
       
        $this->auth = app(Authentication::class);
        $this->notification = $notification;
        $this->manufacturer = $manufacturer;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function manufacturers(Request $request)
    {

        try {
            $p = $this->parametersUrl(1, 12, false, []);

            //Request to Repository
            $results = $this->manufacturer->whereFilters($p->page, $p->take, $p->filter, $p->include);

            //Response
            $response = ["meta" => [], "data" => ManufacturerTransformer::collection($results)];

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
            $manufacturer = $this->manufacturer->findBySlug($slug, $p->include);
            if (!isset($manufacturer) && empty($manufacturer)) {
                $status = 404;
                $response = [
                    'errors' =>
                        [
                            "code" => "404",
                            "source" => [
                                "pointer" => url($request->path()),
                            ],
                            "title" => "Not Fount",
                            "detail" => "The manufacturer not fount"
                        ]
                ];
            } else {
                $response = [
                    'type' => 'manufacturer',
                    'id' => $manufacturer->id,
                    "data" => new ManufacturerTransformer($manufacturer)
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

    public function manufacturer($id, Request $request)
    {

        try {
            $request['include']="category,categories,manufacturer";
            $manufacturer=$this->manufacturer->find($id);
            if (isset($manufacturer)) {

                $response = [
                    'type' => 'manufacturer',
                    'id' => $manufacturer->id,
                    'data' => new ManufacturerTransformer($manufacturer),
                ];

            } else {
                $status = 404;
                $response = ['errors' => [
                    "code" => "404",
                    "source" => [
                        "pointer" => url($request->path()),
                    ],
                    "title" => "Not Fount",
                    "detail" => "The manufacturer not fount"
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
            $manufacturer = $this->manufacturer->create($request->all());
            $response = [
                'success' => [
                    'code' => '200',
                    'source' => [
                        'pointer' => url($request->path())
                    ],
                    "title" => trans('core::core.messages.resource created', ['name' => trans('icommerce::manufacturers.title.manufacturers')]),
                    "detail" => [
                        'id' => $manufacturer->id
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

    /**
     * @param Manufacturer $manufacturer
     * @param IblogRequest $request
     * @return mixed
     */
    public function update(Manufacturer $manufacturer, Request $request)
    {

        try {

            if (isset($manufacturer->id) && !empty($manufacturer->id)) {
                $options = (array)$request->options ?? array();
                isset($request->metatitle) ? $options['metatitle'] = $request->metatitle : false;
                isset($request->metadescription) ? $options['metadescription'] = $request->metatitle : false;
                isset($request->mainimage) ? $options["mainimage"] = saveImage($request['mainimage'], "assets/icommerce/manufacturer/" . $manufacturer->id . ".jpg") : false;
                $request['options'] = json_encode($options);
                $manufacturer = $this->manufacturer->update($manufacturer, $request->all());

                $status = 200;
                $response = [
                    'susses' => [
                        'code' => '201',
                        "source" => [
                            "pointer" => url($request->path())
                        ],
                        "title" => trans('core::core.messages.resource updated', ['name' => trans('icommerce::manufacturers.singular')]),
                        "detail" => [
                            'id' => $manufacturer->id
                        ]
                    ]
                ];


            } else {
                $status = 404;
                $response = ['errors' => [
                    "code" => "404",
                    "source" => [
                        "pointer" => url($request->path()),
                    ],
                    "title" => "Not Found",
                    "detail" => 'Query empty'
                ]
                ];
            }
        } catch (\Exception $e) {
            Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Manufacturer",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * @param Manufacturer $manufacturer
     * @param Request $request
     * @return mixed
     */
    public function delete(Manufacturer $manufacturer, Request $request)
    {
        try {
            $this->manufacturer->destroy($manufacturer);
            $status = 200;
            $response = [
                'susses' => [
                    'code' => '201',
                    "title" => trans('core::core.messages.resource deleted', ['name' => trans('icommerce::manufacturers.singular')]),
                    "detail" => [
                        'id' => $manufacturer->id
                    ]
                ]
            ];

        } catch (\Exception $e) {
            Log::error($e);
            $status = 500;
            $response = ['errors' => [
                "code" => "501",
                "source" => [
                    "pointer" => url($request->path()),
                ],
                "title" => "Error Query Manufacturer",
                "detail" => $e->getMessage()
            ]
            ];
        }

        return response()->json($response, $status ?? 200);
    }

}
