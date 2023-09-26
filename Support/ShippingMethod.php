<?php

namespace Modules\Icommerce\Support;

class ShippingMethod
{
    public function fixDataSend($data)
    {
        $dataMethods['cart_id'] = $data->cart->id;

        if (isset($data->addressShipping->country)) {
            $data['countryCode'] = $data->addressShipping->country->iso_2;
            $data['country'] = $data->addressShipping->country->translate('en')->name;
        }

        if (isset($data->addressShipping->zip_code)) {
            $data['postalCode'] = $data->addressShipping->zip_code;
        }

        if (isset($data->addressShipping->city)) {
            $data['city'] = $data->addressShipping->city->translate('en')->name;
            $data['cityCode'] = $data->addressShipping->city->code; //Optional
        }

        if (isset($data->addressShipping->province)) {
            $data['zone'] = $data->addressShipping->province->translate('en')->name;
            $data['zoneCode'] = $data->addressShipping->province->iso_2; //Optional
        }

        $dataMethods['options'] = $data;

        return $dataMethods;
    }

    public function searchPriceByName($shippingMethods, $dataName)
    {
        foreach ($shippingMethods as $shipping) {
            if ($shipping->calculations->status == 'success') {
                if ($shipping->calculations->items == null) {
                    if ($shipping->name == $dataName) {
                        return $shipping->calculations->price;
                    }
                } else {
                    foreach ($shipping->calculations->items as $item) {
                        if ($item->name == $dataName) {
                            return $item->price;
                        }
                    }
                }// If items
            }// If success
        }
    }
}
