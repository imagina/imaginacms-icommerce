<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Icommerce\Entities\OrderStatus;
use Modules\Icommerce\Transformers\OrderHistoryTransformer;
use Modules\Icommerce\Transformers\OrderItemTransformer;
use Modules\Iprofile\Transformers\UserTransformer;
use Modules\Icurrency\Support\Facades\Currency;
use Modules\Ilocations\Transformers\CountryTransformer;
use Modules\Ilocations\Transformers\ProvinceTransformer;

class OrderTransformer extends JsonResource
{
  public function toArray($request)
  {
    $item = [
      'id' => $this->when($this->id, $this->id),
      'invoiceNro' => $this->when($this->invoice_nro, $this->invoice_nro),
      'invoicePrefix' => $this->when($this->invoice_prefix, $this->invoice_prefix),
      'total' => $this->when($this->total, Currency::convert($this->total)),
      'statusId' => $this->when($this->status_id, $this->status_id),
      'statusName' => OrderStatus::find($this->when($this->status_id, $this->status_id))->title,
      'customer' => new UserTransformer($this->whenLoaded('customer')),
      'addedBy' => new UserTransformer($this->whenLoaded('addedBy')),
      'firstName' => $this->when($this->first_name, $this->first_name),
      'lastName' => $this->when($this->last_name, $this->last_name),
      'email' => $this->when($this->email, $this->email),
      'paymentFirstName' => $this->when($this->payment_first_name, $this->payment_first_name),
      'url' => $this->url,
      'paymentLastName' => $this->when($this->payment_last_name, $this->payment_last_name),
      'paymentCompany' => $this->when($this->payment_company, $this->payment_company),
      'paymentAddress1' => $this->when($this->payment_address_1, $this->payment_address_1),
      'paymentAddress2' => $this->when($this->payment_address_2, $this->payment_address_2),
      'paymentCity' => $this->when($this->payment_city, $this->payment_city),
      'paymentZipCode' => $this->when($this->payment_zip_code, $this->payment_zip_code),
      'paymentCountry' => $this->when($this->payment_country, $this->payment_country),
      'paymentZone' => $this->when($this->payment_zone, $this->payment_zone),
      'paymentAddressFormat' => $this->when($this->payment_address_format, $this->payment_address_format),
      'paymentCustomField' => $this->when($this->payment_custom_field, $this->payment_custom_field),
      'paymentCode' => $this->when($this->payment_code, $this->payment_code),
      'paymentMethod' => $this->when($this->payment_method, $this->payment_method),
      'shippingFirstName' => $this->when($this->shipping_first_name, $this->shipping_first_name),
      'shippingLastName' => $this->when($this->shipping_last_name, $this->shipping_last_name),
      'shippingCompany' => $this->when($this->shipping_company, $this->shipping_company),
      'shippingAddress1' => $this->when($this->shipping_address_1, $this->shipping_address_1),
      'shippingAddress2' => $this->when($this->shipping_address_2, $this->shipping_address_2),
      'telephone' => $this->when($this->telephone, $this->telephone),
      'shippingCity' => $this->when($this->shipping_city, $this->shipping_city),
      'shippingZipCode' => $this->when($this->shipping_zip_code, $this->shipping_zip_code),
      'shippingCountry' => $this->when($this->shipping_country, $this->shipping_country),
      'shippingZone' => $this->when($this->shipping_zone, $this->shipping_zone),
      'shippingAddressFormat' => $this->when($this->shipping_address_format, $this->shipping_address_format),
      'shippingCustomField' => $this->when($this->shipping_custom_field, $this->shipping_custom_field),
      'shippingMethod' => $this->when($this->shipping_method, $this->shipping_method),
      'shippingCode' => $this->when($this->shipping_code, $this->shipping_code),
      'shippingAmount' => $this->when(isset($this->shipping_amount), $this->shipping_amount),
      'storeName' => $this->when($this->store_name, $this->store_name),
      'storeAddress' => $this->when($this->store_address, $this->store_address),
      'storePhone' => $this->when($this->store_phone, $this->store_phone),
      'taxAmount' => $this->when($this->tax_amount, $this->tax_amount),
      'comment' => $this->when($this->comment, $this->comment),
      'tracking' => $this->when($this->tracking, $this->tracking),
      'currencyCode' => $this->when($this->currency_code, $this->currency_code),
      'currencyValue' => $this->when($this->currency_value, $this->currency_value),
      'ip' => $this->when($this->ip, $this->ip),
      'userAgent' => $this->when($this->user_agent, $this->user_agent),
      'key' => $this->when($this->key, $this->key),
      'options' => $this->when($this->options, $this->options),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'histories' => OrderHistoryTransformer::collection($this->orderHistory),
      'items' => OrderItemTransformer::collection($this->orderItems),
      'paymentCountry' => new CountryTransformer($this->whenLoaded('paymentCountry')),
      'shippingCountry' => new CountryTransformer($this->whenLoaded('shippingCountry')),
      'shippingDepartment' => new ProvinceTransformer($this->whenLoaded('shippingDepartment')),
      'paymentDepartment' => new ProvinceTransformer($this->whenLoaded('paymentDepartment')),
      'transactions' => TransactionTransformer::collection($this->whenLoaded('transactions'))
    ];
    //Add information blocks
    $item['informationBlocks'] = [
      [
        'title' => 'Información de pedido y cuenta',
        'values' => [
          ['label' => 'Estado del pedido', 'value' => $item['statusName']],
          ['label' => 'Fecha de orden', 'value' => $item['createdAt']],
          ['label' => 'Pedido realizado desde la IP', 'value' => $item['ip']],
        ]
      ],
      [
        'title' => 'Información de cuenta',
        'values' => [
          ['label' => 'Nombre', 'value' => $item['customer']->present()->fullname],
          ['label' => 'Email', 'value' => $item['customer']->email],
          ['label' => 'Teléfono', 'value' => $item['telephone']],
        ]
      ],
      [
        'title' => 'Datos de domicilio',
        'values' => [
          [
            'label' => 'Dirección de Envio',
            'value' => "{$item['shippingFirstName']}, {$item['shippingLastName']}, {$item['shippingAddress1']}, {$item['shippingCity']}, " .
              ($item['shippingDepartment']->name ?? '') . ", " . ($item['shippingCountry']->name ?? '')
          ]
        ]
      ],
      [
        'title' => 'Pago y método de envío',
        'values' => [
          ['label' => 'Información del pago', 'value' => $item['paymentMethod']]
        ]
      ],
    ];
    

    return $item;
  }
}
