<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceListTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name ?? '',
            'status' => $this->status ?? '0',
            'criteria' => $this->when($this->criteria,$this->criteria),
            'value' => $this->when($this->value, $this->value),
            'operationPrefix' => $this->when($this->operation_prefix, $this->operation_prefix),
            'price' => $this->when(isset($this->pivot), $this->pivot->price ?? 0),
            //'entity' => app($this->related_entity)->find($this->related_id),
            'products' => ProductTransformer::collection($this->whenLoaded('products')),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
        ];

        $request->input('entity') ?
            $data['entity'] = $this->entity  : false;

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations){

            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as  $key => $value){
                if ($this->hasTranslation($key)) {
                    $data[$key]['name'] = $this->translate("$key")['name'];
                }
            }
        }
        return $data;
    }
}
