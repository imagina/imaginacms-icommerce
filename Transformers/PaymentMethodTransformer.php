<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class PaymentMethodTransformer extends Resource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'title' => $this->when($this->title, $this->title),
            'description' => $this->when($this->description, $this->description),
            'name' => $this->when($this->name, $this->name),
            'status' => boolval($this->status),
            'mainImage' => $this->mainImage,
            'options' => $this->when($this->options, $this->options),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'activevalue'=>$this->active
        ];


       /* switch ($this->name) {
            case 'icommercepaypal':
                $data = array_merge($data, [
                    'clientId' => $this->when($this->options, $this->options->clientid),
                    'clientSecret' => $this->when($this->options, $this->options->clientsecret),
                    'mode' => $this->when($this->options, $this->options->mode)
                ]);

                break;

            case 'icommercepayu':
                $data = array_merge($data, [
                    'merchantId' => $this->when($this->options, $this->options->merchant_id ?? null),
                    'apiLogin' => $this->when($this->options, $this->options->api_login ?? null),
                    'apiKey' => $this->when($this->options, $this->options->api_key ?? null),
                    'accountId' => $this->when($this->options, $this->options->account_id ?? null),
                    'test' => $this->when($this->options, $this->options->test ?? null),
                    'mode' => $this->when($this->options, $this->options->mode ?? null)
                ]);


        }*/
        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['title'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['title'] : '';
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['description'] ?? '' : '';

            }
        }
        return $data;
    }
}
