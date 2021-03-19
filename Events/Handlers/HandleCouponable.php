<?php

namespace Modules\Icommerce\Events\Handlers;


use Illuminate\Support\Arr;

class HandleCouponable
{

   

    public function handle($event = null)
    {
       
       	$entity = $event->getEntity();
       	$data = $event->getSubmissionData();

        if(!empty($data)){
         	if(isset($data['categories']))
         		$this->updateItemsIds('categories',$data,$entity,'Modules\Icommerce\Entities\Category');

         	if(isset($data['products']))
         		$this->updateItemsIds('products',$data,$entity,'Modules\Icommerce\Entities\Product');
        }else{
          $this->deleteItemsIds($entity);
        }
       	

    }

    public function updateItemsIds($type,$data,$entity,$nameSpace){

    	$itemsIds = Arr::get($data, $type, []);
      $syncData = [];
    	if(count($itemsIds)>0 && $itemsIds[0]!=null){
    		foreach ($itemsIds as $key => $itemId) {
          $syncData[$itemId] = [];
          $syncData[$itemId]['couponable_type'] = $nameSpace; 
        }
    	}
      $entity->$type()->sync($syncData);

    }

    public function deleteItemsIds($entity){

      if($entity->categories->count()>0){
        $entity->categories()->detach();
      }

      if($entity->products->count()>0){
        $entity->products()->detach();
      }

    }

   

}
