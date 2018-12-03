@extends('email.plantilla')
@section('content')
    <div id="contend-mail" class="p-3">
        @php
            $user=$data['content']['user'];
            $order=$data['content']['order'];
            $products=$data['content']['products'];
        @endphp
        <h3 class="text-center text-uppercase">
            {{trans('icommerce::common.emailMsg.order')}} # {{$order->id }}

            {{icommerce_get_Orderstatus()->get($order->order_status)}}
        </h3>

        <br>
        <p class="px-3">
            <strong>
                {{trans('icommerce::common.emailMsg.orderurl')}}
            </strong>
            <a href="{{url('/orders/'.$order->id.'/'.$order->key)}}">{{url('/orders/'.$order->id.'/'.$order->key)}}</a>
        </p>
        <p class="px-3">
            <strong>Mr/Mrs:</strong>
            @if(isset($user))
                {{$user}}
            @else
                {{$order->first_name}}, {{$order->last_name}}<br>
            @endif

        </p>

        <br>
        <br>

        <div style="margin-bottom: 5px">

            <table width="100%" style="margin-bottom: 15px">
                <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.details')}}</th>
                <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.customer details')}}</th>
                <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.others details')}}</th>
                <tr>
                    <td>
                        {{$order->created_at}}<br>
                        {{$order->payment_method}}<br>
                        {{$order->shipping_method}}
                    </td>
                    <td>
                        {{$order->first_name}}, {{$order->last_name}}<br>
                        {{$order->email}}<br>
                        {{$order->telephone}}
                    </td>
                    <td>
                        {{icommerce_get_Orderstatus()->get($order->order_status)}}<br>
                        @if(!empty($order->invoice_nro))
                            {{$order->invoice_nro}}<br>
                        @else
                            ------ <br>
                        @endif
                    </td>
                </tr>
            </table>
            <table width="100%" style="margin-bottom: 5px">
                <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.product')}}</th>
                {{-- <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.reference')}}</th> --}}
                <th bgcolor="f5f5f5">Sku</th>
                <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.quantity')}}</th>
                <th bgcolor="f5f5f5">{{trans('icommerce::orders.table.unit price')}}</th>
                <th bgcolor="f5f5f5">Total</th>
                @foreach ($products as $product)
                    <tr class="product-order">
                        <td>
                            {{$product["title"]}}<br>
                            @if(isset($product['option_name']))
                            <strong>{{$product['option_name']}}: </strong>{{$product['option_value']}}
                            @if($product['child_option_name']!=null && $product['child_option_name']!="")<br><strong>{{$product['child_option_name']}}: </strong>{{$product['child_option_value']}}@endif
                            @endif
                            {{-- Options Product Value --}}
                        </td>
                        <td>{{$product["sku"]}}</td>
                        <td>{{$product["quantity"]}}</td>
                        <td>{{$product["price"]}}</td>
                        <td>{{$product["total"]}}</td>
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

                    <td colspan="2" style="text-align: right">{{number_format($subtotal,2,".",",")}}</td>
                </tr>

                @if(!empty($order->shipping_amount))
                    <tr class="shippingTotal">
                        <td colspan="3" style="text-align: right">{{trans('icommerce::orders.table.shipping_method')}}</td>
                        <td colspan="2" style="text-align: right">{{$order->shipping_method}} {{ $order->shipping_amount>0 ? ' - '.number_format($order->shipping_amount,2,".",",") : ''}}</td>
                    </tr>
                @endif

                @if(!empty($order->tax_amount) && $order->tax_amount!=0)
                    <tr class="taxAmount">
                        <td colspan="3" style="text-align: right">{{trans('icommerce::order_summary.tax')}}</td>
                        <td colspan="2" style="text-align: right">{{number_format($order->tax_amount,2,".",",")}}</td>
                    </tr>
                @endif
                {{--
                Validacion del Cupon
                <tr class="coupon">
                    <td colspan="3" style="text-align: right">{{trans('icommerce::orders.table.coupon')}}</td>
                    <td colspan="2" style="text-align: right">coupon Value</td>
                </tr>
                --}}

                <tr class="total">
                    <td colspan="3" style="text-align: right">Total</td>
                    <td colspan="2" style="text-align: right">{{number_format($order->total,2,".",",")}}</td>
                </tr>

            </table>
        </div>


    </div>

@endsection
