<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Support\Cart as cartSupport;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Illuminate\Http\Request;

class EloquentPaymentMethodRepository extends EloquentBaseRepository implements PaymentMethodRepository
{
    public function getItemsBy($params)
    {
        // INITIALIZE QUERY
        $query = $this->model->query();

        // RELATIONSHIPS
        $defaultInclude = [];
        $query->with(array_merge($defaultInclude, $params->include ?? []));

        // FILTERS
        if ($params->filter) {
            $filter = $params->filter;

            //add filter by search
            if (isset($filter->search)) {
                //find search in columns
                $query->where('id', 'like', '%' . $filter->search . '%')
                    ->orWhere('payment_code', 'like', '%' . $filter->search . '%')
                    ->orWhere('name', 'like', '%' . $filter->search . '%');
            }

            if (isset($filter->store)) {
                $query->where('store_id', $filter->store);
            }

            if (isset($filter->geozones)) {
              $query->whereIn('geozone_id', $filter->geozones);
            }

            if (isset($filter->active)) {
              $query->where('active', $filter->active);
            }

            if (isset($filter->status)) {
              $query->where('status', $filter->status);
            }

        }
        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
          (isset($params->take) && $params->take) ? $query->take($params->take) : false;//Take
            return $query->get();
        }
    }


    public function getItem($criteria, $params)
    {
        // INITIALIZE QUERY
        $query = $this->model->query();

        $query->where('id', $criteria);

        // RELATIONSHIPS
        $includeDefault = [];
        $query->with(array_merge($includeDefault, $params->include));

        // FIELDS
        if ($params->fields) {
            $query->select($params->fields);
        }
        return $query->first();

    }

    public function create($data)
    {

        $paymentMethod = $this->model->create($data);

        event(new CreateMedia($paymentMethod, $data));

        return $paymentMethod;
    }

    public function update($model, $data)
    {
        $model->update($data);

        event(new UpdateMedia($model, $data));

        return $model;

    }
  
  
  /**
   *
   * @param $request
   * @return Response
   */
  
  public function getCalculations($data, $params)
  {
    
    /* Init query */
    $query = $this->model->query();
    
    /* Check actives */
    $query->where("status", 1);
    
    /* Filters */
    if (isset($params->filter) && $params->filter) {
      $filter = $params->filter;
      
      if (isset($filter->geozones)) {
        $query->whereIn("geozone_id", $filter->geozones);
      }
    }
    
    /* Run query*/
    $methods = $query->get();
    
    if (isset($methods) && $methods->count() > 0) {
      // Search Cart
      $cartRepository = app('Modules\Icommerce\Repositories\CartRepository');
      
      if (isset($data['cart_id'])) {
        $cart = $cartRepository->find($data['cart_id']);
        // Fix data cart products
        $supportCart = new cartSupport();
        $dataCart = $supportCart->fixProductsAndTotal($cart);
        // Add products to request
        $data['products'] = $dataCart['products'];
      }
      foreach ($methods as $key => $method) {
        $methodApiController = app($method->options->init);
        if(method_exists($methodApiController,"calculations")){
          try {
            $results = $methodApiController->calculations(new Request ($data));
            $resultData = $results->getData();
            $method->calculations = $resultData;
          } catch (\Exception $e) {
            $resultData["msj"] = "error";
            $resultData["items"] = $e->getMessage();
            $method->calculations = $resultData;
          }
        }
       
      }
    }
    return $methods;
  }

}
