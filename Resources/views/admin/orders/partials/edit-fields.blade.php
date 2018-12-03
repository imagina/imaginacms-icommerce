<div class="box-body row">

    <div class="col-xs-12 col-sm-4">

        <div class="panel panel-default">

            <div class="panel-heading">
                <i style="margin-right: 5px;" class="fa fa-shopping-cart" aria-hidden="true"></i>
                {{trans('icommerce::orders.table.details')}}
            </div>

            <ul class="list-group">
                <li class="list-group-item">{{$order->created_at}}</li>
                <li class="list-group-item">{{$order->payment_method}}</li>
                <li class="list-group-item">{{$order->shipping_method}}</li>
            </ul>

        </div>

    </div>

    <div class="col-xs-12 col-sm-4">

        <div class="panel panel-default">

            <div class="panel-heading">
                <i style="margin-right: 5px;" class="fa fa-user" aria-hidden="true"></i>
                {{trans('icommerce::orders.table.customer details')}}
            </div>

            <ul class="list-group">
                <li class="list-group-item">{{$order->first_name}} {{$order->last_name}}</li>
                <li class="list-group-item">{{$order->email}}</li>
                <li class="list-group-item">{{$order->telephone}}</li>
            </ul>

        </div>

    </div>

    <div class="col-xs-12 col-sm-4">

        <div class="panel panel-default">

            <div class="panel-heading">
                <i style="margin-right: 5px;" class="fa fa-plus-circle" aria-hidden="true"></i>
                {{trans('icommerce::orders.table.others details')}}
            </div>

            <ul class="list-group">

                @if(!empty($order->invoice_nro))
                    <li class="list-group-item">{{$order->invoice_nro}}</li>
                @else
                    <li class="list-group-item">------</li>
                @endif

            </ul>

        </div>

    </div>


    <div id="orderC" class="col-xs-12">
        <div class="panel panel-default">

            <div class="panel-heading">
                <i style="margin-right: 5px;" class="fa fa-book" aria-hidden="true"></i>
                {{trans('icommerce::orders.table.order')}}
                #{{$order->id}}
            </div>

            <div class="panel-body">
                <table class="table table-bordered">

                    <th>{{trans('icommerce::orders.table.payment address')}}</th>
                    <th>{{trans('icommerce::orders.table.shipping address')}}</th>

                    <tr>
                        <td>
                            {{$order->payment_firstname}} {{$order->payment_lastname}}<br>
                            {{$order->payment_address_1}}<br>
                            @if(!empty ($order->payment_address_2))
                                {{$order->payment_address_2}}<br>
                            @endif
                            {{$order->payment_postcode ?? ''}}<br>
                            {{$order->payment_city}}<br>
                            {{$order->payment_zone ?? ''}}<br>
                            {{$order->payment_country}}
                        </td>

                        <td>
                            {{$order->shipping_firstname}} {{$order->shipping_lastname}}<br>
                            {{$order->shipping_address_1}}<br>
                            @if(!empty ($order->shipping_address_2))
                                {{$order->shipping_address_2}}<br>
                            @endif
                            {{$order->shipping_postcode ?? ''}}<br>
                            {{$order->shipping_city}}<br>
                            {{$order->shipping_zone ?? ''}}<br>
                            {{$order->shipping_country}}
                        </td>

                    </tr>

                </table>


                <table class="table table-bordered">
                    <th>{{trans('icommerce::orders.table.product')}}</th>
                    {{-- <th>{{trans('icommerce::orders.table.reference')}}</th> --}}
                    <th>Sku</th>
                    <th>{{trans('icommerce::orders.table.quantity')}}</th>
                    <th>{{trans('icommerce::orders.table.unit price')}}</th>
                    <th>Total</th>

                    @foreach ($order->products as $product)
                        <tr class="product-order">
                            <td>
                                {{$product->title}}<br>
                                @if(isset($product->pivot->option_name))
                                <strong>{{$product->pivot->option_name}}: </strong>{{$product->pivot->option_value}}
                                @if($product->pivot->child_option_name!=null && $product->pivot->child_option_name!="")<br><strong>{{$product->pivot->child_option_name}}: </strong>{{$product->pivot->child_option_value}}@endif
                                @endif
                                {{-- Options Product Order Value --}}
                            </td>
                            <td>{{$product->sku}}</td>
                            <td>{{$product->pivot->quantity}}</td>
                            <td>{{formatMoney($product->pivot->price)}}</td>
                            <td>{{formatMoney($product->pivot->total)}}</td>
                        </tr>
                    @endforeach

                    <tr class="subtotal">
                        <td colspan="4" class="text-right font-weight-bold">Subtotal</td>
                        @php

                            $rest = 0;

                            if(!empty($order->shipping_amount))
                                $rest = $order->shipping_amount;

                            if(!empty($order->tax_amount))
                                $rest = $rest + $order->tax_amount;

                            $subtotal = $order->total - $rest;

                        @endphp
                        <td>{{formatMoney((float)$subtotal)}}</td>
                    </tr>

                    @if(!empty($order->shipping_amount))
                        <tr class="shippingTotal">
                            <td colspan="4" class="text-right font-weight-bold">{{$order->shipping_method}}</td>
                            <td>{{formatMoney((float)$order->shipping_amount)}}</td>
                        </tr>
                    @endif

                    @if(($order->tax_amount)>0))
                    <tr class="taxTotal">
                        <td colspan="4" class="text-right font-weight-bold">Tax</td>
                        <td>{{formatMoney((float)$order->tax_amount)}}</td>
                    </tr>
                    @endif

                    <tr class="total ">
                        <td colspan="4" class="text-right font-weight-bold">Total</td>
                        <td>{{formatMoney($order->total)}}</td>
                    </tr>

                </table>

            </div>

        </div>
    </div>

    @include('icommerce::admin.orders.partials.history')

</div>
<style>
    .font-weight-bold {
        font-weight: 600 !important;
    }
</style>
