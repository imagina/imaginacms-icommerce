<?php

namespace Modules\Icommerce\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Ilocations\Transformers\CountryTransformer;
use Modules\Ilocations\Transformers\ProvinceTransformer;

class OrderTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    $item = [
      'paymentCountry' => new CountryTransformer($this->whenLoaded('paymentCountry')),
      'shippingCountry' => new CountryTransformer($this->whenLoaded('shippingCountry')),
      'shippingDepartment' => new ProvinceTransformer($this->whenLoaded('shippingDepartment')),
      'paymentDepartment' => new ProvinceTransformer($this->whenLoaded('paymentDepartment')),
      'transactions' => TransactionTransformer::collection($this->whenLoaded('transactions')),
     ];
  
    //Add information blocks
    $item['informationBlocks'] = [
      [
        'title' => trans("icommerce::orders.informationBlocksOrder.orderingInformation"),
        'values' => [
          ['label' => trans("icommerce::orders.informationBlocksOrder.titleOrderStatus"),
            'value' => $this->statusName],
          ['label' => trans("icommerce::orders.informationBlocksOrder.titleOrderDate"),
            'value' =>  $this->created_at],
          ['label' => trans("icommerce::orders.informationBlocksOrder.titleOrderIP"),
            'value' =>  $this->ip],
          ['label' => 'URL', 'value' => "<a href='$this->url'>$this->url</a>"],
        ]
      ]
    ];
  
    $customerBlockInfo = [
      'title' => trans("icommerce::orders.informationBlocksOrder.titleOrderInfoCustomer"),
      'values' => [
        [
          'label' => trans("iprofile::addresses.form.name"),
          'value' => isset($this->customer->id) ? $this->customer->present()->fullname : $this->first_name . ' ' . $this->last_name
        ],
        [
          'label' => trans("iprofile::frontend.form.email"),
          'value' => $this->customer->email ?? $this->email
        ],
    
      ]
    ];
  
    if (isset($this->customer->id)) {
    
      $customerFields = $this->customer->fields;
      $customerRegisterExtraFields = json_decode(setting("iprofile::registerExtraFields", null, "[]"));
      if (!empty($customerFields)) {
        foreach ($customerRegisterExtraFields as $extraField) {
          if ($extraField->active ?? false) {
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
        array_push($item["informationBlocks"], $customerBlockInfo);
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
                (isset($item["shippingDepartment"]->name) ? $item["shippingDepartment"]->name : '') . ", " . (isset($item["shippingCountry"]->name) ? $item['shippingCountry']->name : '')
            ],
            [
              'label' => trans("iprofile::frontend.form.cellularPhone"),
              'value' => $this->shippingTelephone ?? ''
            ]
        
          ]
        ];
      
        $orderShippingExtraFields = $this->options->shippingAddress ?? [];
      
        if (!empty($orderShippingExtraFields)) {
          foreach ($customerAddressExtraFields as $extraField) {
            if ($extraField->active ?? false) {
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
            'value' => "{$this->paymentFirstName}, {$this->paymentLastName}, {$this->paymentAddress1}, ".($this->paymentCity).", {$this->payment_zip_code}, " .
              ($item["paymentDepartment"]->name ?? '') . ", " . ($item["paymentCountry"]->name ?? '')
          ],
          [
            'label' => trans("iprofile::frontend.form.cellularPhone"),
            'value' => $this->paymentTelephone ?? ''
          ]
        ]
      ];
    
      $orderBillingExtraFields = $this->options->billingAddress ?? [];
      if (!empty($orderBillingExtraFields)) {
        foreach ($customerAddressExtraFields as $extraField) {
          if ($extraField->active ?? false) {
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
    
      array_push($item["informationBlocks"], $customerBlockInfo);
    }
  
    if (isset($this->payment_code) && !empty($this->payment_code)) {
    
      $paymentInfo = [
        'title' => trans("icommerce::orders.informationBlocksOrder.titleOrderPayShippingMethod"),
        'values' => [
          ['label' => trans("icommerce::orders.informationBlocksOrder.titleOrderPayMethod"),
            'value' => $this->paymentMethod],
          [
            'label' => trans("icommerce::orders.informationBlocksOrder.titleOrderShippingMethod"),
            'value' => !$this->require_shipping ? trans('icommerce::orders.messages.orderNotRequireShipping')
              : (!empty($this->shippingMethod) ? $this->shippingMethod : '-')
          ]
      
        ]
      ];
    
      $paymentRepository = app("Modules\Icommerce\Repositories\PaymentMethodRepository");
      $paymentMethod = $paymentRepository->getItem($this->paymentCode);
    
      if (isset($paymentMethod->description) && !empty($paymentMethod->description)) {
        array_push($paymentInfo["values"],
          ['label' => trans("icommerce::orders.informationBlocksOrder.titleOrderDescriptionShippingMethod"),
            'value' => $paymentMethod->description]);
      }
    
      array_push($item['informationBlocks'],
        $paymentInfo
      );
    }
  
    if (setting('icommerce::warehouseFunctionality', null, false)) {
      $warehouseBlockInfo = [
        'title' => trans("icommerce::orders.informationBlocksOrder.titleOrderInfoWarehouse"),
        'values' => [
          [
            'label' => trans("icommerce::orders.informationBlocksOrder.labelTitleWarehouse"),
            'value' => $this->warehouse_title ?? ''
          ],
          [
            'label' => trans("icommerce::orders.informationBlocksOrder.labelAddressWarehouse"),
            'value' => $this->warehouse_address ?? ''
          ],
        ]
      ];
      array_push($item['informationBlocks'], $warehouseBlockInfo);
    }

    return $item;
  }
}
