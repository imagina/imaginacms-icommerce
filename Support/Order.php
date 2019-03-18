<?php

namespace Modules\Icommerce\Support;

class Order
{

    public function fixData($request,$data){

        // Set Total
        /** 
         * Total Cart
         * Total Shipping Method
        */
        $totalCart = $data["cart"]->getTotalAttribute();
       
        $totalShipping = $data["shippingPrice"];

        $total = $totalCart+$totalShipping;
        
        if(!is_null($totalShipping))
            $newData["total"] = $total;
        
        // Set Order Status
        $newData["status_id"] = 1;

        // Set Data User
        $newData["customer_id"] = $data["profile"]->id;
        $newData["first_name"] = $data["profile"]->first_name;
        $newData["last_name"] = $data["profile"]->last_name;
        $newData["email"] = $data["profile"]->email;
        $newData["telephone"] = $data["profile"]->telephone ?? ""; // OJO DE PRUEBA

        // Set Payment Address infor
        $newData["payment_first_name"] = $data["addressPayment"]->first_name;
        $newData["payment_last_name"] = $data["addressPayment"]->last_name;
        $newData["payment_company"] = $data["addressPayment"]->company ?? "";
        $newData["payment_nit"] = $data["addressPayment"]->nit ?? "";
        $newData["payment_address_1"] = $data["addressPayment"]->address_1;
        $newData["payment_address_2"] = $data["addressPayment"]->address_2 ?? "";
        $newData["payment_city"] = $data["addressPayment"]->city->translate('en')->name;
        $newData["payment_zip_code"] = $data["addressPayment"]->zip_code;
        $newData["payment_country"] = $data["addressPayment"]->country->translate('en')->name;
        $newData["payment_zone"] = $data["addressPayment"]->province->translate('en')->name ?? "";
        
        // Set Payment Method infor
        $newData["payment_method"] = $data["paymentMethod"]->id;
        $newData["payment_code"] = $data["paymentMethod"]->name;
        $newData["payment_name"] = $data["paymentMethod"]->title;

        // Set Shipping Address infor
        $newData["shipping_first_name"] = $data["addressShipping"]->first_name;
        $newData["shipping_last_name"] = $data["addressShipping"]->last_name;
        $newData["shipping_company"] = $data["addressShipping"]->company ?? "";
        $newData["shipping_address_1"] = $data["addressShipping"]->address_1;
        $newData["shipping_address_2"] = $data["addressShipping"]->address_2 ?? "";
        $newData["shipping_city"] = $data["addressShipping"]->city->translate('en')->name;
        $newData["shipping_zip_code"] = $data["addressShipping"]->zip_code;
        $newData["shipping_country"] = $data["addressShipping"]->country->translate('en')->name;
        $newData["shipping_zone"] = $data["addressShipping"]->province->translate('en')->name ?? "";
        
        // Set Shipping Method infor
        $newData["shipping_method"] = $data["shippingMethod"];
        $newData["shipping_code"] = $data["shippingMethod"];
        if(!is_null($totalShipping))
            $newData["shipping_amount"] = $totalShipping;

        // Set Store
        $newData["store_id"] = $data["store"]->id;
        $newData["store_name"] = $data["store"]->name;
        $newData["store_address"] = $data["store"]->address;
        $newData["store_phone"] = $data["store"]->phone;
    
        // Set Currency
        $newData["currency_id"] = $data["currency"]->id;
        $newData["currency_code"] = $data["currency"]->code;
        $newData["currency_value"] = $data["currency"]->value;

        // Set Others
        $newData["ip"] = $request->ip();
        $newData["user_agent"] = $request->header('User-Agent');
        $newData['key'] = substr(md5 (date("Y-m-d H:i:s").$request->ip()),0,20);

        return $newData;

    }

    

}