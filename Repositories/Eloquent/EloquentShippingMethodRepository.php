<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

use Illuminate\Http\Request;

class EloquentShippingMethodRepository extends EloquentBaseRepository implements ShippingMethodRepository
{

    public function getItemsBy($params)
    {
     // INITIALIZE QUERY
     $query = $this->model->query();
     
     // RELATIONSHIPS
     $defaultInclude = [];
     $query->with(array_merge($defaultInclude,$params->include));
     
     // FILTERS
     if($params->filter) {
       $filter = $params->filter;
       
       //add filter by search
       if (isset($filter->search)) {
         //find search in columns
         $query->where('id', 'like', '%' . $filter->search . '%')
           ->orWhere('name', 'like', '%' . $filter->search . '%')
           ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
           ->orWhere('created_at', 'like', '%' . $filter->search . '%');
       }
       
     }
     /*== FIELDS ==*/
     if (isset($params->fields) && count($params->fields))
       $query->select($params->fields);

     /*== REQUEST ==*/
     if (isset($params->page) && $params->page) {
       return $query->paginate($params->take);
     } else {
       $params->take ? $query->take($params->take) : false;//Take
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
     
     $shippingMethod = $this->model->create($data);
     
     return $shippingMethod;
     
   }
   

   public function update($model, $data){

    // validate status
    if(isset($data['status']))
      $data['status'] = "1";   
    else
      $data['status'] = "0"; 

    // init
    $options['init'] = $model->options->init;

    // Extra Options
    foreach ($model->options as $key => $value) {
        if($key!="init"){
          $options[$key] = $data[$key];
          unset($data[$key]);
        }
    }

    $data['options'] = $options;

    $model->update($data);

    return $model;

}


   public function updateBy($criteria, $data, $params){
     
     // INITIALIZE QUERY
     $query = $this->model->query();
     
     // FILTER
     if (isset($params->filter)) {
       $filter = $params->filter;
       
       if (isset($filter->field))//Where field
         $query->where($filter->field, $criteria);
       else//where id
         $query->where('id', $criteria);
     }
   
     // REQUEST
     $model = $query->first();
   
     if($model) {
       $model->update($data);
     }
     return $model;
   }
   
   public function deleteBy($criteria, $params)
   {
     // INITIALIZE QUERY
     $query = $this->model->query();
     
     // FILTER
     if (isset($params->filter)) {
       $filter = $params->filter;
       
       if (isset($filter->field)) //Where field
         $query->where($filter->field, $criteria);
       else //where id
         $query->where('id', $criteria);
     }
   
     // REQUEST
     $model = $query->first();
   
     if($model) {
       $model->delete();
     }
   }


  /**
   * 
   * @param  Request $products array (items,total)
   * @param  Request $options  array (countryCode,postCode,country)
   * @return Response
   */

   public function getCalculations($request){

      // INITIALIZE QUERY
      $query = $this->model->query();

      // Check actives
      $methods = $query->where("status",1)->get();

      if(isset($methods) && count($methods)>0){


        // Items mixtos with Freeshipping and not freeshipping
        //if(!icommerce_checkAllItemsFreeshipping($products["items"],$options)){

        foreach ($methods as $key => $method) {
          
          /*
                if status is "success" and 'items' is not null
                    - Items has a list (array)

                if status is "success" and items is null:
                    - Price will be defined (Number 0,1,2,3,4,5)
                    - PriceShow will be defined (true or false)
          */


          try {
            
            $data['products'] = $request->products;
            $data['options'] =  $request->options;
            
            $results = app($method->options->init)->init(new Request($data));
            $resultData = $results->getData();

            $method->calculations = $resultData;
            
          } catch (\Exception $e) {

            $resultData["msj"] = "error";
            $resultData["items"] = $e->getMessage();
           
            $method->calculations = $resultData;

          }// Try catch

         

        }// Foreach

      }// If actives

      return $methods;


   }

}
