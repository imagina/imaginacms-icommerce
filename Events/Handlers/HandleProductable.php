<?php


namespace Modules\Icommerce\Events\Handlers;


use Illuminate\Support\Arr;

class HandleProductable
{
    public function handle($event = null, $data = [])
    {
        $this->handleSingleProductable($event);
        $this->handleMultipleProductable($event);
    }

    public function handleSingleProductable($event){
        $entity = $event->getEntity();
        $productId = Arr::get($event->getSubmissionData(), 'product_id', null);
        if(!empty($productId)){
            $entity->products()->sync([
                $productId => [
                    'productable_type' => get_class($entity),
                ]
            ]);
        }else{
            $entity->products()->sync([]);
        }
    }

    public function handleMultipleProductable($event)
    {
        $entity = $event->getEntity();
        $productIds = Arr::get($event->getSubmissionData(), 'product_ids', []);
        $syncList = [];
        if (count($productIds)){
            foreach ($productIds as $productId) {
                $syncList[$productId] = [];
                $syncList[$productId]['productable_type'] = get_class($entity);
            }
            $entity->products()->sync($syncList);
        }
    }

}
