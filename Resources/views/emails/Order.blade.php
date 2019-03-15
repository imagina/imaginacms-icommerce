<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  @includeFirst(['icommerce.emails.style', 'icommerce::emails.base.style'])

</head>

<body>
<div id="body">
  <div id="template-mail">
    
    @includeFirst(['icommerce.emails.header', 'icommerce::emails.base.header'])



    {{-- ***** Order Content  ***** --}}
    <div id="contend-mail" class="p-3">
      
      {{-- ***** Title  ***** --}}
      <h3 class="text-center text-uppercase">
        {{trans('icommerce::common.email.msg.order')}} # {{$order->id}} -
        Status: {{$order->status->title}}
      </h3>
      
      <br>
      {{-- ***** URL  ***** --}}
      <p class="px-3">
        <strong>
          {{trans('icommerce::common.email.msg.orderurl')}}
        </strong>
        <a href="{{url('/orders/'.$order->id.'/'.$order->key)}}" target="_blank">{{url('/orders/'.$order->id.'/'.$order->key)}}</a>
      </p>

      {{-- ***** Customer  ***** --}}
      <p class="px-3">
        <strong>Mr/Mrs:</strong>
        {{$order->first_name}}, {{$order->last_name}}<br>
      </p>
      
      <br>
      <br>
  
      <div style="margin-bottom: 5px">
        
        {{-- ***** Table Infor ***** --}}
        <table width="100%" style="margin-bottom: 15px">
          <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.details')}}</th>
          <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.customer details')}}</th>
          <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.others details')}}</th>
          <tr>
            <td>
              {{$order->created_at}}<br>
              {{$order->payment_method->code}}<br>
              {{$order->shipping_method}}
            </td>
            <td>
              {{$order->first_name}}, {{$order->last_name}}<br>
              {{$order->email}}<br>
              {{$order->telephone}}
            </td>
            <td>
              {{$order->status->title}}<br>
              @if(!empty($order->invoice_nro))
                {{$order->invoice_nro}}<br>
              @else
                ------ <br>
              @endif
            </td>
          </tr>
        </table>

        {{-- ***** Table Products ***** --}}
        <table width="100%" style="margin-bottom: 5px">
          <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.product')}}</th>
          <th bgcolor="f5f5f5">Sku</th>
          <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.quantity')}}</th>
          <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.unit price')}}</th>
          <th bgcolor="f5f5f5">Total</th>
          
          @isset($order->items)
            @foreach ($order->items as $item)
              <tr class="product-order">
                <td>
                  {{$item["title"]}}<br>
                  
                </td>
                <td>{{$item["sku"]}}</td>
                <td>{{$item["quantity"]}}</td>
                <td>{{$item["price"]}}</td>
                <td>{{$item["total"]}}</td>
              </tr>
            @endforeach
          @endisset
        
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
            
            <td colspan="2" style="text-align: right">{{number_format($subtotal,2,".",",")}}</td>
          </tr>
          
          @if(!empty($order->shipping_amount))
            <tr class="shippingTotal">
              <td colspan="3" style="text-align: right">{{trans('icommerce::orders.table.shipping_method')}}</td>
              <td colspan="2"
                  style="text-align: right">{{$order->shipping_method}} {{ $order->shipping_amount>0 ? ' - '.number_format($order->shipping_amount,2,".",",") : ''}}</td>
            </tr>
          @endif
          
          @if(!empty($order->tax_amount) && $order->tax_amount!=0)
            <tr class="taxAmount">
              <td colspan="3" style="text-align: right">{{trans('icommerce::order_summary.tax')}}</td>
              <td colspan="2" style="text-align: right">{{number_format($order->tax_amount,2,".",",")}}</td>
            </tr>
          @endif
          
          
          <tr class="total">
            <td colspan="3" style="text-align: right">Total</td>
            <td colspan="2" style="text-align: right">{{number_format($order->total,2,".",",")}}</td>
          </tr>
        
        </table>
      </div>
    </div>
    {{-- ***** End Order Content  ***** --}}



    @includeFirst(['icommerce.emails.footer', 'icommerce::emails.base.footer'])


  </div>
</div>
</body>

</html>