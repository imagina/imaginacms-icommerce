<?php


namespace Modules\Icommerce\Events\Handlers;


use Illuminate\Support\Arr;

class HandleProductable
{
    public function handle($event = null, $data = [])
    {
        $entity = $event->getEntity();
        $productId = Arr::get($event->getSubmissionData(), 'product_id', null);
        if(!empty($productId)){
            $entityType = get_class($entity);
            if (is_module_enabled('Icommerce')) {
                $params = json_decode(json_encode(['filter' => ['field' => 'entity_id']]));
                $productWithPlan = app('Modules\\Icommerce\\Repositories\\ProductRepository')->getItem($entity->id,$params);
                if($productWithPlan){
                    $productWithPlan->entity_id = 0;
                    $productWithPlan->entity_type = null;
                    $productWithPlan->save();
                }
                $product = app('Modules\\Icommerce\\Repositories\\ProductRepository')->getItem($productId, false);
                $product->entity_id = $entity->id;
                $product->entity_type = $entityType;
                $product->save();
            }
        }else{
            $params = json_decode(json_encode(['filter' => ['field' => 'entity_id']]));
            $productWithPlan = app('Modules\\Icommerce\\Repositories\\ProductRepository')->getItem($entity->id,$params);
            if($productWithPlan){
                $productWithPlan->entity_id = 0;
                $productWithPlan->entity_type = null;
                $productWithPlan->save();
            }
        }
    }

}
