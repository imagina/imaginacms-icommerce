<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  @includeFirst(['icommerce.emails.style', 'icommerce::emails.base.style'])

</head>

<body>
<div id="body">
  <div id="template-mail">

    <header>

      <!-- header contend -->
      <div>
        <div class="date text-right text-capitalize">
          {{strftime("%B %d, %G")}}
        </div>
      </div>

      <div>
        <h1 class="title">Thank You For Your Order!</h1>
      </div>

      <div class="header-contend text-center py-3">
        <div class="bg-image">
          <img src="{{Setting::get('isite::logo1')}}" alt="" style="max-width: 150px">
        </div>
      </div>

    </header>


    {{-- ***** Order Content  ***** --}}
    <div class="container email p-3">
      <div class="container">
        {{-- ***** Title  ***** --}}
        <h3 class="text-center text-uppercase">Orden de compra</h3>

        {{-- ***** URL  ***** --}}
        <p>
          Si desea ver el estado de su orden en cualquier momento, por favor ve siguiente link:
          <a href="{{url('/orders/'.$order->id.'/'.$order->key)}}"
             target="_blank">{{url('/orders/'.$order->id.'/'.$order->key)}}</a>
        </p>

        <div class="table-products">
          <table>
            <tr align="left">
              <th>{{trans('icommerce::orders.table.quantity')}}</th>
              <th>Sku</th>
              <th>{{trans('icommerce::orders.table.product')}}</th>
              <th>Total</th>
            </tr>
            @isset($order->orderItems)
              @foreach ($order->orderItems as $item)
            <tr class="product-order">
              <td>{{$item["quantity"]}}</td>
              <td>{{$item["sku"]}}</td>
              <td>{{$item["title"]}}</td>
              <td>{{$item["total"]}}</td>
            </tr>
                @if($item->orderOption)
                  @php
                    $itemTotal = $item["total"];
                    $itemQuantity = $item["quantity"];
                  @endphp
                  @foreach($item->orderOption as $option)
                    <tr class="order-item-options">
                      @if($option->value==null)
                        <td colspan="2"> - {{$option->option_value}}</td>
                        <td>{{$itemQuantity}}</td>
                        <td>{{$option->price_prefix}} {{$option->price}}</td>
                        <td>{{$option->price*$itemQuantity}}</td>

                      @else
                        <td colspan="4">{{$option->option_value}}</td>
                        <td colspan="1">{{$option->value}}</td>
                      @endif
                    </tr>
                  @endforeach
                @endif
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
        <div>
          <table width="100%" style="margin-bottom: 15px">
            <tr align="left">
              <th bgcolor="f5f5f5">Dirección de Envío</th>
              <th bgcolor="f5f5f5">User details</th>
            </tr>
            <tr>
              <td>{{$order->shipping_address_1}}</td>
              {{-- <p>{{$order->city->name}}</p>
               <p>{{$order->province->name}}</p>
               <p>{{$order->country->name}}</p>--}}
              <td>Metodo de envio:{{$order->shipping_method}}</td>
            </tr>
            <tr>
              <td>{{$order->first_name}} {{$order->last_name}}<br></td>
              <td>{{$order->email}}</td>
              <td>{{$order->telephone}}</td>
              <td>Estado de la orden: {{$order->status->title}} </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    {{-- ***** End Order Content  ***** --}}

    <footer class="p-3 text-center">
      <div class="social">
        @if(Setting::has('isite::SocialNetworks'))
          @php
            $socials = json_decode(Setting::get('isite::SocialNetworks'));
          @endphp

          @if(count($socials))
            @foreach($socials as $index => $item)
              <a href="{{ $item->value }}">
                <span class="fa-stack fa-sm" aria-hidden="true">
                  <i class="fa fa-circle-thin fa-stack-2x"></i>
                  <i class="fa fa-{{$item->label->value}} fa-stack-1x"></i>
                </span>
              </a>
            @endforeach
          @endif
        @endif
      </div>

      <span class="copyright">
          Copyrights © {{date('Y')}} All Rights Reserved by {{ setting('core::site-name') }}.
      </span>
    </footer>


  </div>
</div>
</body>

</html>
