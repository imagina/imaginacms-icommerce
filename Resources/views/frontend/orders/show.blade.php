@extends('iprofile::frontend.layouts.master')
@section('profileBreadcrumb')
    
    <x-isite::breadcrumb>
        
        <li class="breadcrumb-item">
            <a href="{{ \URL::route(\LaravelLocalization::getCurrentLocale() .  '.icommerce.store.order.index') }}">{{trans('icommerce::orders.title.orders')}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{trans('icommerce::orders.title.detail order')}}</li>
    </x-isite::breadcrumb>
@endsection

@section('profileTitle')
    {{trans('icommerce::orders.title.detail order')}} #{{$order->id}}
@endsection
@section('profileContent')
    @php
        $currency= isset($order->currency) ? $order->currency : localesymbol($code ?? 'USD');
    @endphp
    

            <div class="row">
                <div class="col-12 col-sm-4 mb-3">
                    <div class="card">
                        <div class="card-header bg-secondary text-white bg-secondary text-white">
                            <i style="margin-right: 5px;" class="fa fa-shopping-cart" aria-hidden="true"></i>
                           
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">{{ $order->created_at}}</li>
                            <li class="list-group-item">{{ $order->payment_method }} </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-4 mb-3">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <i style="margin-right: 5px;" class="fa fa-user" aria-hidden="true"></i>
                            {{trans('icommerce::orders.table.customer details')}}
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">{{$order->first_name.' '.$order->last_name}}</li>
                            <li class="list-group-item">{{$order->email}}</li>
                            @if($order->telephone)
                                <li class="list-group-item">{{$order->telephone}}</li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-4 mb-3">
                    <div class="card ">
                        <div class="card-header bg-secondary text-white">
                            <i style="margin-right: 5px;" class="fa fa-plus-circle" aria-hidden="true"></i>
                            {{trans('icommerce::orders.table.others details')}}
                        </div>
                        <ul class="list-group list-group-flush">
                            @if($order->invoice_nro)
                                <li class="list-group-item">
                                    {{$order->invoice_nro}}
                                </li>
                            @endif
                            <li class="list-group-item">
                                {{$order->status->title}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="my-4 hr-lg">
            <div class="row">
                <div id="orderC" class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <i style="margin-right: 5px;" class="fa fa-book" aria-hidden="true"></i>
                            {{trans('icommerce::orders.table.order')}}
                            # {{$order->id}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <th>{{trans('icommerce::orders.table.payment address')}}</th>
                                    <th>{{trans('icommerce::orders.table.shipping address')}}</th>
                                    <tr>
                                        <td>
                                            {{$order->payment_first_name}}<br>
                                            {{$order->payment_last_name}}<br>
                                            {{$order->payment_address_1}}<br>
                                            @if(!empty ($order->payment_address_2))
                                                {{$order->payment_address_2}}<br>
                                            @endif
                                            {{$order->payment_city}}<br>
                                            {{$order->paymentDepartment ? $order->paymentDepartment->translations[0]->name : ''}}<br>
                                            {{$order->paymentCountry ? $order->paymentCountry->translations[0]->name : ''}}
                                        </td>
                                        <td>
                                            {{$order->shipping_first_name}}<br>
                                            {{$order->shipping_last_name}}<br>
                                            {{$order->shipping_address_1}}<br>
                                            @if(!empty ($order->shipping_address_2))
                                                {{$order->shipping_address_2}}<br>
                                            @endif
                                            {{$order->shipping_city}}<br>
                                            {{$order->shippingDepartment ? $order->shippingDepartment->translations[0]->name : ''}}<br>
                                            {{$order->shippingCountry ? $order->shippingCountry->translations[0]->name : ''}}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table ">
                                    <th>{{trans('icommerce::orders.table.product')}}</th>
                                    <th>{{trans('icommerce::orders.table.sku')}}</th>
                                    <th>{{trans('icommerce::orders.table.quantity')}}</th>
                                    <th>{{trans('icommerce::orders.table.unit price')}}</th>
                                    <th class="text-right">{{trans('icommerce::orders.table.total')}}</th>
                                    @php $orderOptions = $order->orderOption @endphp
                                    @foreach($order->orderItems as $product)
                                        @php $productOptionText = $orderOptions->where('order_item_id',$product->id) @endphp
                                        <tr class="product-order" >
                                            <td style="min-width: 250px">
                                                {{$product->title}}
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
                                            <td>{{$currency->symbol_left}} {{formatMoney($product->price)}} {{$currency->symbol_right}}</td>
                                            <td class="text-right">{{$currency->symbol_left}} {{formatMoney($product->total)}} {{$currency->symbol_right}}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="subtotal">
                                        <td colspan="4" class="text-right font-weight-bold">{{trans('icommerce::orders.table.subtotal')}}</td>
                                        <td class="text-right">{{$currency->symbol_left}}  {{formatMoney($subtotal) }} {{$currency->symbol_right}}</td>
                                    </tr>
                                    <tr class="shippingTotal">
                                        <td colspan="4" class="text-right font-weight-bold">{{trans('icommerce::orders.table.shipping_method')}}</td>
                                        <td class="text-right">{{ $order->shipping_method }} {{$order->shipping_amount != 0 ? $currency->symbol_left : '' }} {{ $order->shipping_amount != 0 ? formatMoney($order->shipping_amount) : '' }} {{$order->shipping_amount != 0 ? $currency->symbol_right : '' }} </td>
                                    </tr>
                                    @if($order->tax_amount>0)
                                        <tr class="taxAmount">
                                            <td colspan="4" class="text-right font-weight-bold">{{trans('icommerce::order_summary.tax')}}</td>
                                            <td class="text-right">{{$currency->symbol_left}} {{ formatMoney($order->tax_amount) }} {{$currency->symbol_right}}</td>
                                        </tr>
                                    @endif
                                    <tr class="total">
                                        <td colspan="4" class="text-right font-weight-bold">{{trans('icommerce::orders.table.total')}}</td>
                                        <td class="text-right">{{$currency->symbol_left}} {{formatMoney($order->total) }} {{$currency->symbol_right}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4 hr-lg">
                <div class="col-12 text-right mt-3 mt-md-0">
                    <a href="{{ \URL::route(\LaravelLocalization::getCurrentLocale() .  '.icommerce.store.order.index') }}"
                       class="btn btn-outline-primary btn-rounded btn-lg my-2">
                       Ver Ordenes
                       {{--{{trans('icommerce::orders.button.Back_to_order_list')}}--}}
                    </a>
                    @if($order->payment_method=='Credibanco')
                        <a href="{{ route("icommercecredibanco.voucher.show",$order->id) }}"
                            class="btn btn-outline-primary btn-rounded btn-lg my-2">
                            Voucher Credibanco
                            {{--{{trans('icommerce::orders.button.Back_to_order_list')}}--}}
                        </a>
                    @endif
                </div>
            </div>
       
    <style type="text/css">
        table .clickable-row {
            cursor: pointer;
        }
    </style>
@stop

@section('profileExtraFooter')
    @include('icommerce::frontend.partials.extra-footer')
@endsection
