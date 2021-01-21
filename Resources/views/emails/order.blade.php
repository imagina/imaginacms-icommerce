@php
  $order = $data["order"];
@endphp
<div>
  <h1 class="title" style="text-align: center;
        width: 80%;
        font-size: 30px;
        margin: 12px auto;">{{trans('icommerce::orders.title.single_order_title')}} # {{$order->id}}</h1>
  
  <p style="text-align: center; margin: 0;"> {{trans("icommerce::orders.table.status")}}: {{$order->status->title}}</p>

</div>

<p>
  {{trans('icommerce::common.emailMsg.orderurl')}}
</p>
<div>
  <a href='{{$order->url}}'
     style="text-decoration: none;
       background-color: {{Setting::get('isite::brandSecondary')}};
       padding: 10px;
       margin: 10px 0;
       color: white;"
     target="_blank">{{trans("icommerce::orders.table.details")}}: #{{$order->id}}</a>
</div>
<br>
<div class="table-products" style="margin-bottom: 15px; font-size: 10px">
  <table style="width: 100%;border-collapse: collapse;">
    <thead style="background-color: #eee;">
    <tr>
      <th>{{trans('icommerce::orders.table.product')}}</th>
      <th>Sku</th>
      <th>{{trans('icommerce::orders.table.quantity')}}</th>
      <th>{{trans('icommerce::orders.table.unit price')}}</th>
      <th>Total</th>
    </tr>
    </thead>
    <tbody>
    
    @php
      $orderOptions = $order->orderOption;
      $currency = isset($order->currency) ? $order->currency : localesymbol($code??'USD');
    @endphp
    @foreach($order->orderItems as $product)
      @php $productOptionText = $orderOptions->where('order_item_id',$product->id) @endphp
      <tr class="product-order">
        <td>
          <h4>{{$product->title}}</h4>
          <!--Show item options-->
          @if($productOptionText->count())
            <div class="text-muted" style="font-size: 13px">({{
                  $productOptionText->map(function ($item){
                  return $item->option_description .": ".$item->option_value_description;
                  })->implode(', ')
              }})
            </div>
          @endif
        </td>
        <td>
          {{$product->product->sku}}<br>
        </td>
        <td>{{$product->quantity}}</td>
        <td>{{$currency->symbol_left}}{{formatMoney($product->price)}}{{$currency->symbol_right}}</td>
        <td
          class="text-right">{{$currency->symbol_left}}{{formatMoney($product->total)}}{{$currency->symbol_right}}</td>
      </tr>
    @endforeach
    <tr>
      <td colspan="5">
        <br>
      </td>
    </tr>
    
    <tr class="subtotal">
      <td colspan="3" style="text-align: right">{{trans('icommerce::orders.table.subtotal')}}</td>
      
      @php
        
        $rest = 0;

        if(!empty($order->shipping_amount))
            $rest = $order->shipping_amount;

        if(!empty($order->tax_amount))
            $rest = $rest + $order->tax_amount;

        $subtotal = $order->total - $rest;
      
      @endphp
      
      <td colspan="2"
          style="text-align: right">{{$order->currency->symbol_left ?? ''}}{{number_format($subtotal,2,".",",")}}{{$order->currency->symbol_right ?? ''}}</td>
    </tr>
    
    @if(!empty($order->shipping_amount))
      <tr class="shippingTotal">
        <td colspan="3" style="text-align: right">{{trans('icommerce::orders.table.shipping_method')}}</td>
        <td colspan="2"
            style="text-align: right">{{$order->shipping_method}} {{ $order->shipping_amount>0 ? ' - '.number_format($order->shipping_amount,2,".",",") : ''}}{{$order->currency->symbol_right ?? ''}}</td>
      </tr>
    @endif
    
    @if(!empty($order->tax_amount) && $order->tax_amount!=0)
      <tr class="taxAmount">
        <td colspan="3" style="text-align: right">{{trans('icommerce::order_summary.tax')}}</td>
        <td colspan="2"
            style="text-align: right">{{$order->currency->symbol_left ?? ''}}{{number_format($order->tax_amount,2,".",",")}}{{$order->currency->symbol_right ?? ''}}</td>
      </tr>
    @endif
    
    
    <tr class="total">
      <td colspan="3" style="text-align: right">Total</td>
      <td colspan="2"
          style="text-align: right">{{$order->currency->symbol_left ?? ''}}{{number_format($order->total,2,".",",")}}{{$order->currency->symbol_right ?? ''}}</td>
    </tr>
    </tbody>
  </table>
</div>
<div class="user-information">
  <div class="row" style=" width: 100%; display: inline-block;
      margin-bottom: 60px;
      text-align: left;">
    <div class="col" style="  width: 43%;
      display: block;
      float: left;
      padding: 0 15px;">
      <h4>{{trans("icommerce::orders.table.shipping address")}}</h4>
      <p>{{$order->shipping_first_name}} {{$order->shipping_last_name}}</p>
      <p> {{$order->shipping_address_1}}</p>
      <p>{{$order->shipping_city}}</p>
      <p>{{$order->shipping_zone}}</p>
      <p>{{$order->shippingCountry->translations[0]->name ?? ''}}</p>
      
      
      <h4>{{trans("icommerce::orders.table.payment address")}}</h4>
      <p>{{$order->payment_first_name}} {{$order->payment_last_name}}</p>
      <p> {{$order->payment_address_1}}</p>
      <p>{{$order->payment_city}}</p>
      <p>{{$order->payment_zone}}</p>
      <p>{{$order->paymentCountry->translations[0]->name ?? ''}}</p>
    
    
    </div>
    <div class="col" style="  width: 43%;
      display: block;
      float: left;
      padding: 0 15px;">
      <h4>{{trans("icommerce::orders.table.customer details")}}</h4>
      <p>{{$order->first_name}} {{$order->last_name}}</p>
      <p style=" margin: 0;">{{$order->email}}</p>
      <p style=" margin: 0;">{{$order->telephone}}</p>
      
      <h4>{{trans("icommerce::orders.table.shipping_method")}}</h4>
      <p>{{$order->shipping_method}}</p>
      
      <h4>{{trans("icommerce::orders.table.payment_method")}}</h4>
      <p>{{$order->payment_method}}</p>
    
    
    </div>
  </div>
</div>
   





