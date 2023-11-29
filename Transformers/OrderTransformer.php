<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Icommerce\Entities\OrderStatus;
use Modules\Icommerce\Entities\PaymentMethod;
use Modules\Icommerce\Transformers\OrderHistoryTransformer;
use Modules\Icommerce\Transformers\OrderItemTransformer;
use Modules\Iprofile\Transformers\UserTransformer;
use Modules\Icurrency\Support\Facades\Currency;
use Modules\Ilocations\Transformers\CountryTransformer;
use Modules\Ilocations\Transformers\ProvinceTransformer;
use Modules\Isite\Transformers\RevisionTransformer;

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
      'paymentTelephone' => $this->when($this->payment_telephone, $this->payment_telephone),
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
      'shippingTelephone' => $this->when($this->shipping_telephone, $this->shipping_telephone),
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
      'requireShipping' => $this->require_shipping ? '1' : '0',
      'suscriptionId' => $this->when($this->suscription_id, $this->suscription_id),
      'suscriptionToken' => $this->when($this->suscription_token, $this->suscription_token),
      'options' => $this->when($this->options, $this->options),
      'organizationId' => $this->when($this->organization_id, $this->organization_id),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'histories' => OrderHistoryTransformer::collection($this->orderHistory),
      'items' => OrderItemTransformer::collection($this->orderItems),
      'paymentCountry' => new CountryTransformer($this->whenLoaded('paymentCountry')),
      'shippingCountry' => new CountryTransformer($this->whenLoaded('shippingCountry')),
      'shippingDepartment' => new ProvinceTransformer($this->whenLoaded('shippingDepartment')),
      'paymentDepartment' => new ProvinceTransformer($this->whenLoaded('paymentDepartment')),
      'transactions' => TransactionTransformer::collection($this->whenLoaded('transactions')),
      'revisions' => RevisionTransformer::collection($this->whenLoaded('revisions')),
    ];

    //Add information blocks
    $item['informationBlocks'] = [
      [
        'title' => trans("icommerce::orders.informationBlocksOrder.orderingInformation"),
        'values' => [
          ['label' => trans("icommerce::orders.informationBlocksOrder.titleOrderStatus"),
            'value' => $item['statusName']],
          ['label' => trans("icommerce::orders.informationBlocksOrder.titleOrderDate"),
            'value' => $item['createdAt']],
          ['label' => trans("icommerce::orders.informationBlocksOrder.titleOrderIP"),
            'value' => $item['ip']],
          ['label' => 'URL', 'value' => "<a href='$this->url'>$this->url</a>"],
        ]
      ]
    ];

    $customerBlockInfo = [
      'title' => trans("icommerce::orders.informationBlocksOrder.titleOrderInfoCustomer"),
      'values' => [
        [
          'label' => trans("iprofile::addresses.form.name"),
          'value' => isset($this->customer->id) ? $item['customer']->present()->fullname : $this->first_name . ' ' . $this->last_name
        ],
        [
          'label' => trans("iprofile::frontend.form.email"),
          'value' => $item['customer']->email ?? $this->email
        ],

      ]
    ];

    if (isset($this->customer->id)) {

      $customerFields = $item['customer']->fields;
      $customerRegisterExtraFields = json_decode(setting("iprofile::registerExtraFields", null, "[]"));
      if (!empty($customerFields)) {
        foreach ($customerRegisterExtraFields as $extraField) {
          if ($extraField->active) {
            if ($extraField->type == "documentType") {
              $customerField = $customerFields->filter(function ($field) use ($extraField) {
                return strstr($field->name, $extraField->field) ||
                  strstr($field->name, "user_type_id");
              })->first();
            } else $customerField = $customerFields->where("name", $extraField->field)->first();

            if (!empty($customerField)) {
              if ($extraField->type == "documentType") {
                $documentNumber = $customerFields->filter(function ($field) {
                  return strstr($field->name, "documentNumber") ||
                    strstr($field->name, "identification");
                })->first();

                array_push($customerBlockInfo["values"], [
                  "label" => trans("iprofile::addresses.form.identification"),
                  "value" => $customerField->value . " " . $documentNumber->value
                ]);
              } else {
                array_push($customerBlockInfo["values"], [
                  "label" => trans("iprofile::addresses.form.$extraField->field"),
                  "value" => $customerField->value
                ]);
              }

            }
          }
        }
        array_push($item['informationBlocks'], $customerBlockInfo);
      }

      $customerAddressExtraFields = json_decode(setting("iprofile::userAddressesExtraFields", null, "[]"));

      if ($this->require_shipping) {
        $customerShippingAddressBlock = [
          'title' => trans('icommerce::orders.table.shipping address'),
          'values' => [
            [
              "label" => trans("iprofile::addresses.form.name"),
              "value" => $this->shipping_first_name . " " . $this->shipping_last_name
            ],
            [
              'label' => trans("iprofile::frontend.form.shipping_address"),
              'value' => ($this->shipping_first_name ?? '') . ", " . ($this->shipping_last_name ?? '') . ", " .
                ($this->shipping_address_1 ?? '') . ", " . ($this->shipping_city ?? '') . ", " . ($this->shipping_zip_code ?? '') . ", " .
                (isset($item['shippingDepartment']->name) ? $item['shippingDepartment']->name : '') . ", " . (isset($item['shippingCountry']->name) ? $item['shippingCountry']->name : '')
            ],
            [
              'label' => trans("iprofile::frontend.form.cellularPhone"),
              'value' => $item['shippingTelephone'] ?? ''
            ]

          ]
        ];

        $orderShippingExtraFields = $this->options->shippingAddress ?? [];

        if (!empty($orderShippingExtraFields)) {
          foreach ($customerAddressExtraFields as $extraField) {
            if ($extraField->active) {
              if (isset($orderShippingExtraFields->{$extraField->field})) {
                if ($extraField->field == "documentType") {
                  $documentNumber = $orderShippingExtraFields->documentNumber ?? '';

                  array_push($customerShippingAddressBlock["values"], [
                    "label" => trans("iprofile::addresses.form.identification"),
                    "value" => $orderShippingExtraFields->{$extraField->field} . " " . $documentNumber
                  ]);
                }
              }
            }
          }
        }

          array_push($customerShippingAddressBlock["values"], [
            "label" => trans("iprofile::addresses.form.extraInfo"),
            "value" => $orderShippingExtraFields->extraInfo ?? ""
          ]);
        
      } else {
        $customerShippingAddressBlock = [
          'title' => trans('icommerce::orders.table.shipping address'),
          'values' => [
            [
              "label" => trans("icommerce::orders.informationBlocksOrder.titleOrderShippingAddress"),
              "value" => trans('icommerce::orders.messages.orderNotRequireShipping')
            ]
          ]

        ];
      }


      array_push($item["informationBlocks"], $customerShippingAddressBlock);

      $customerBillingAddressBlock = [
        'title' => trans('icommerce::orders.table.payment address'),
        'values' => [
          [
            "label" => trans("iprofile::addresses.form.name"),
            "value" => $this->payment_first_name . " " . $this->payment_last_name
          ],
          [
            'label' => trans("iprofile::frontend.form.billing_address"),
            'value' => "{$item['paymentFirstName']}, {$item['paymentLastName']}, {$item['paymentAddress1']}, ".($item['paymentCity']).", {$this->payment_zip_code}, " .
              ($item['paymentDepartment']->name ?? '') . ", " . ($item['paymentCountry']->name ?? '')
          ],
          [
            'label' => trans("iprofile::frontend.form.cellularPhone"),
            'value' => $item['paymentTelephone'] ?? ''
          ]
        ]
      ];

      $orderBillingExtraFields = $this->options->billingAddress ?? [];
      if (!empty($orderBillingExtraFields)) {
        foreach ($customerAddressExtraFields as $extraField) {
          if ($extraField->active) {
            if (isset($orderBillingExtraFields->{$extraField->field})) {
              if ($extraField->field == "documentType") {
                $documentNumber = $orderBillingExtraFields->documentNumber ?? '';
                array_push($customerBillingAddressBlock["values"], [
                  "label" => trans("iprofile::addresses.form.identification"),
                  "value" => $orderBillingExtraFields->{$extraField->field} . " " . $documentNumber
                ]);
              }
            }
          }
        }
      }
   
  
      array_push($customerBillingAddressBlock["values"], [
        "label" => trans("iprofile::addresses.form.extraInfo"),
        "value" => $orderBillingExtraFields->extraInfo ?? ""
      ]);
      
      array_push($item["informationBlocks"], $customerBillingAddressBlock);
  
    } else {

      if ($this->type == "quote") {
        $formRepository = app("Modules\Iforms\Repositories\FormRepository");

        $params = [
          "filter" => [
            "field" => "system_name",
          ],
          "include" => [],
          "fields" => [],
        ];
        $formQuote = $formRepository->getItem("icommerce_cart_quote_form", json_decode(json_encode($params)));
        if (isset($this->options->quoteForm) && !empty($this->options->quoteForm) && isset($formQuote->id)) {
          $formFields = $formQuote->fields;

          !is_array($this->options->quoteForm) ? $this->options->quoteForm = [$this->options->quoteForm] : false;
          foreach ($this->options->quoteForm as $key => $quoteField) {

            $field = $formFields->where("name", $key)->first();
            array_push($customerBlockInfo["values"], [
              "label" => $field->label,
              "value" => $quoteField
            ]);
          }
        }
      }

      array_push($item['informationBlocks'], $customerBlockInfo);
    }

    if (isset($this->payment_code) && !empty($this->payment_code)) {

      $paymentInfo = [
        'title' => trans("icommerce::orders.informationBlocksOrder.titleOrderPayShippingMethod"),
        'values' => [
          ['label' => trans("icommerce::orders.informationBlocksOrder.titleOrderPayMethod"),
            'value' => $item['paymentMethod']],
          [
            'label' => trans("icommerce::orders.informationBlocksOrder.titleOrderShippingMethod"),
            'value' => !$this->require_shipping ? trans('icommerce::orders.messages.orderNotRequireShipping')
            : (!empty($item['shippingMethod']) ? $item['shippingMethod'] : '-')
          ]

        ]
      ];

      $paymentRepository = app("Modules\Icommerce\Repositories\PaymentMethodRepository");
      $paymentMethod = $paymentRepository->getItem($item['paymentCode']);

      if (isset($paymentMethod->description) && !empty($paymentMethod->description)) {
        array_push($paymentInfo["values"],
          ['label' => trans("icommerce::orders.informationBlocksOrder.titleOrderDescriptionShippingMethod"),
            'value' => $paymentMethod->description]);
      }

      array_push($item['informationBlocks'],
        $paymentInfo
      );
    }

    return $item;
  }
}
