<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Http\Requests\ManufacturerRequest;
// Base Api
use Modules\Icommerce\Repositories\ManufacturerRepository;
// Transformers
use Modules\Icommerce\Transformers\ManufacturerTransformer;
// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class ManufacturerApiController extends BaseApiController
{
    private $manufacturer;

    public function __construct(ManufacturerRepository $manufacturer)
    {
        $this->manufacturer = $manufacturer;
    }

      /**
       * Get List Products
       */
      public function index(Request $request)
      {
          try {
              //Get Parameters from URL.
              $params = $this->getParamsRequest($request);

              //Request to Repository
              $manufacturers = $this->manufacturer->getItemsBy($params);

              //Response
              $response = ['data' => ManufacturerTransformer::collection($manufacturers)];

              //If request pagination add meta-page
              $params->page ? $response['meta'] = ['page' => $this->pageTransformer($manufacturers)] : false;
          } catch (\Exception $e) {
              \Log::error($e->getMessage());
              $status = $this->getStatusError($e->getCode());
              $response = ['errors' => $e->getMessage()];
          }

          //Return response
          return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
      }

      /**
       * GET A ITEM
       *
       * @return mixed
       */
      public function show($criteria, Request $request)
      {
          try {
              //Get Parameters from URL.
              $params = $this->getParamsRequest($request);

              //Request to Repository
              $dataEntity = $this->manufacturer->getItem($criteria, $params);

              //Break if no found item
              if (! $dataEntity) {
                  throw new \Exception('Item not found', 204);
              }

              //Response
              $response = ['data' => new ManufacturerTransformer($dataEntity)];

              //If request pagination add meta-page
              $params->page ? $response['meta'] = ['page' => $this->pageTransformer($dataEntity)] : false;
          } catch (\Exception $e) {
              \Log::error($e->getMessage());
              $status = $this->getStatusError($e->getCode());
              $response = ['errors' => $e->getMessage()];
          }

          //Return response
          return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
      }

      /**
       * CREATE A ITEM
       *
       * @return mixed
       */
      public function create(Request $request)
      {
          \DB::beginTransaction();
          try {
              $data = $request->input('attributes') ?? []; //Get data

              //Validate Request
              $this->validateRequestApi(new ManufacturerRequest($data));

              //Create item
              $manufacturer = $this->manufacturer->create($data);

              //Response
              $response = ['data' => new ManufacturerTransformer($manufacturer)];
              \DB::commit(); //Commit to Data Base
          } catch (\Exception $e) {
              \Log::error($e->getMessage());
              \DB::rollback(); //Rollback to Data Base
              $status = $this->getStatusError($e->getCode());
              $response = ['errors' => $e->getMessage()];
          }
          //Return response
          return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
      }

      /**
       * UPDATE ITEM
       *
       * @return mixed
       */
      public function update($criteria, Request $request)
      {
          \DB::beginTransaction(); //DB Transaction
          try {
            //Get data
              $data = $request->input('attributes') ?? []; //Get data

              //Get Parameters from URL.
              $params = $this->getParamsRequest($request);

              //Request to Repository
              $this->manufacturer->updateBy($criteria, $data, $params);
              //Response
              $response = ['data' => 'Item Updated'];
              \DB::commit(); //Commit to DataBase
          } catch (\Exception $e) {
              \Log::error($e->getMessage());
              \DB::rollback(); //Rollback to Data Base
              $status = $this->getStatusError($e->getCode());
              $response = ['errors' => $e->getMessage()];
          }

          //Return response
          return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
      }

      /**
       * DELETE A ITEM
       *
       * @return mixed
       */
      public function delete($criteria, Request $request)
      {
          \DB::beginTransaction();
          try {
              //Get params
              $params = $this->getParamsRequest($request);

              $dataEntity = $this->manufacturer->deleteBy($criteria, $params);

              //Response
              $response = ['data' => 'Item deleted'];
              \DB::commit(); //Commit to Data Base
          } catch (\Exception $e) {
              \Log::error($e->getMessage());
              \DB::rollback(); //Rollback to Data Base
              $status = $this->getStatusError($e->getCode());
              $response = ['errors' => $e->getMessage()];
          }

          //Return response
          return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
      }
}
