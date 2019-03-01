<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentPaymentMethodRepository extends EloquentBaseRepository implements PaymentMethodRepository
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
          ->orWhere('payment_code', 'like', '%' . $filter->search . '%')
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
    
    $paymentMethod = $this->model->create($data);
    
    
    return $paymentMethod;
  }
  
  public function update($model, $data){

    // validate status
    if(isset($data['status']))
      $data['status'] = "1";   
    else
      $data['status'] = "0"; 

    // init
    $options['init'] = $model->options->init;

    //Image
    $requestimage = $data['mainimage'];
    unset($data['mainimage']);

    if(($requestimage==NULL) || (!empty($requestimage)) ){
      $requestimage = $this->saveImage($requestimage,"assets/{$model->name}/1.jpg");
    }
    $options['mainimage'] = $requestimage;
    
    
    // Extra Options
    foreach ($model->options as $key => $value) {
        if($key!="mainimage" && $key!="init"){
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

      // init
      $options['init'] = $model->options->init;

      //Image
      $requestimage = $data['mainimage'];
      unset($data['mainimage']);


      if(($requestimage==NULL) || (!empty($requestimage)) ){
        $requestimage = $this->saveImage($requestimage,"assets/{$model->name}/1.jpg");
      }
      $options['mainimage'] = $requestimage;

      // Extra Options
        foreach ($model->options as $key => $value) {
          if($key!="mainimage" && $key!="init"){
            $options[$key] = $data[$key];
            unset($data[$key]);
          }
      }
      $data['options'] = $options;
      
      // Update Model
      $model->update($data);

      // Sync Data 
      $model->geozones()->sync(array_get($data, 'geozones', []));

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
     * Save Image
     *
     * @param  $value
     * @param  $destination
     * @return 
     */
  public function saveImage($value,$destination_path)
  {

        $disk = "publicmedia";

        //Defined return.
        if(ends_with($value,'.jpg')) {
            return $value;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value);
            // resize and prevent possible upsizing

            $image->resize(config('asgard.iblog.config.imagesize.width'), config('asgard.iblog.config.imagesize.height'), function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            if(config('asgard.iblog.config.watermark.activated')){
                $image->insert(config('asgard.iblog.config.watermark.url'), config('asgard.iblog.config.watermark.position'), config('asgard.iblog.config.watermark.x'), config('asgard.iblog.config.watermark.y'));
            }
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path, $image->stream('jpg','80'));


            // Save Thumbs
            \Storage::disk($disk)->put(
                str_replace('.jpg','_mediumThumb.jpg',$destination_path),
                $image->fit(config('asgard.iblog.config.mediumthumbsize.width'),config('asgard.iblog.config.mediumthumbsize.height'))->stream('jpg','80')
            );

            \Storage::disk($disk)->put(
                str_replace('.jpg','_smallThumb.jpg',$destination_path),
                $image->fit(config('asgard.iblog.config.smallthumbsize.width'),config('asgard.iblog.config.smallthumbsize.height'))->stream('jpg','80')
            );

            // 3. Return the path
            return $destination_path;
        }

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($destination_path);

            // set null in the database column
            return null;
        }
  }


}
