<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

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
}
