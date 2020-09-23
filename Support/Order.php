<?php

namespace Modules\Icommerce\Support;

class Order
{

  public function fixData($data, $request)
  {

    // Set Total
    /**
     * Total Cart
     * Total Shipping Method
     */
    $totalCart = $data["cart"]->total;

    $totalShipping = $data["shippingPrice"];

      $data["store"]=(object)$data["store"];
    $total = ($totalCart + $totalShipping) - $data["discount"];

    $newData["total"] = $total;

    // Set Order Status
    $newData["status_id"] = 1;

    // Set Data User
    $newData["added_by_id"] = $data["addedBy"]->id;

    if(!isset($data["customer"])){
      $data["customer"] = $data["addedBy"];
    }

    $newData["customer_id"] = $data["customer"]->id;
    $newData["first_name"] = $data["customer"]->first_name;
    $newData["last_name"] = $data["customer"]->last_name;
    $newData["email"] = $data["customer"]->email;


    // Set Payment Address infor
    $newData["payment_first_name"] = $data["payment_first_name"];
    $newData["payment_last_name"] = $data["payment_last_name"];
    $newData["payment_company"] = $data["payment_company"] ?? "";
    $newData["payment_nit"] = $data["payment_nit"] ?? "";
    $newData["payment_address_1"] = $data["payment_address_1"];
    $newData["payment_address_2"] = $data["payment_address_2"] ?? "";
    $newData["telephone"] = $data["telephone"] ?? "";
    $newData["payment_city"] = $data["payment_city"];
    $newData["payment_zip_code"] = $data["payment_zip_code"]??'N/A';
    $newData["payment_country"] = $data["payment_country"];
    $newData["payment_zone"] = $data["payment_zone"] ?? "";

    // Set Payment Method infor
    $newData["payment_code"] = $data["paymentMethod"]->id;
    $newData["payment_method"] = $data["paymentMethod"]->title;

    // Set Shipping Address infor
    $newData["shipping_first_name"] = $data["shipping_first_name"];
    $newData["shipping_last_name"] = $data["shipping_last_name"];
    $newData["shipping_company"] = $data["shipping_company"] ?? "";
    $newData["shipping_address_1"] = $data["shipping_address_1"];
    $newData["shipping_address_2"] = $data["shipping_address_2"] ?? "";
    $newData["shipping_city"] = $data["shipping_city"];
    $newData["shipping_zip_code"] = $data["shipping_zip_code"]??'N/A';
    $newData["shipping_country_code"] = $data["shipping_country_code"];
    $newData["shipping_zone"] = $data["shipping_zone"] ?? "";

    // Set Shipping Method infor
    $newData["shipping_method"] = $data["shippingMethod"]->title;
    $newData["shipping_code"] = $data["shipping_method_id"];

    $newData["shipping_amount"] = $totalShipping ?? 0;

    // Set Store
      $newData["store_id"] = isset($data["store"]) ? $data["store"]->id : '';
      $newData["store_name"] = isset($data["store"]) ? $data["store"]->name : '';
      $newData["store_address"] = isset($data["store"]) ? $data["store"]->address : '';
      $newData["store_phone"] = '';
      // $newData["store_phone"] = isset($data["store"]) ? $data["store"]->phone : '';
      $newData["options"] = isset($data["options"]) ? $data["options"] : '';

    //if isset currency
    if ($data["currency"]) {
      // Set Currency
      $newData["currency_id"] = $data["currency"]->id;
      $newData["currency_code"] = $data["currency"]->code;
      $newData["currency_value"] = $data["currency"]->value;
    }

    // Set Others
    $newData["user_agent"] = $request->header('User-Agent');
    $newData["ip"] = $request->ip();//Set Ip from request
    $newData['key'] = substr(md5(date("Y-m-d H:i:s") . $request->ip()), 0, 20);

    return $newData;

  }


}
