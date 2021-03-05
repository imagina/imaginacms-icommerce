<?php


namespace Modules\Icommerce\Events\Handlers;


use Illuminate\Support\Arr;

class HandleProductable
{
    public function handle($event = null, $data = [])
    {
        $entity = $event->getEntity();
        $productable = Arr::get($event->getSubmissionData(), 'productable', null);
        if(!empty($productable)){
            if(is_array($productable)) {
                $productablesToSync = [];
                foreach ($productable as $product){
                    $productablesToSync[$product] = [
                        'productable_type' => get_class($entity),
                    ];
                }
                $entity->products()->sync($productablesToSync);
            }else{
                $entity->products()->sync([
                    $productable => [
                        'productable_type' => get_class($entity),
                    ]
                ]);
            }
        }else{
            $entity->products()->sync([]);
        }
    }

}
