@extends('layouts.master')
@section('content')

  
  <div>
    <div class="container">
      <div class="row">
        <div class="col">
          
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-4 text-uppercase">
              <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">{{trans('icommerce::common.home.title')}}</a>
              </li>
              <li class="breadcrumb-item"><a
                  href="{{ URL::to('/orders') }}">{{trans('icommerce::orders.breadcrumb.title')}}</a></li>
              <li class="breadcrumb-item active"
                  aria-current="page">{{trans('icommerce::orders.breadcrumb.single_order')}}</li>
            </ol>
          </nav>
          
          <h2 class="text-center mt-0 mb-5">{{trans('icommerce::orders.title.single_order_title')}}</h2>
        
        </div>
      </div>
    </div>
  </div>
  
  
  <div id="orderDetails" class="pb-5">
    <div class="container" v-if="order">
      <div class="row">
        
        <div class="col-12 col-sm-4">
          
          <div class="card">
            
            <div class="card-header bg-secondary text-white bg-secondary text-white">
              <i style="margin-right: 5px;" class="fa fa-shopping-cart" aria-hidden="true"></i>
              {{trans('icommerce::orders.table.details')}}
            </div>
            
            <ul class="list-group list-group-flush">
              <li class="list-group-item">{{ $order->created_at}}</li>
              <li class="list-group-item">{{ $order->payment_method }} </li>
            </ul>
          
          </div>
        
        </div>
        
        <div class="col-12 col-sm-4">
          
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
        
        <div class="col-12 col-sm-4">
          
          <div class="card ">
            
            <div class="card-header bg-secondary text-white">
              <i style="margin-right: 5px;" class="fa fa-plus-circle" aria-hidden="true"></i>
              {{trans('icommerce::orders.table.others details')}}
            </div>
            
            <ul class="list-group list-group-flush">
              @if($order->invoice_nro)
              <li class="list-group-item" v-show="order.invoice_nro">{{$order->invoice_nro}}</li>
              @endif
              <li class="list-group-item"
                    v-show="order.order_status">{{icommerce_get_Orderstatus()->get($order->order_status)}}</li>
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
                      {{$order->payment_firstname}}<br>
                      {{$order->payment_lastname}}<br>
                      {{$order->payment_address_1}}<br>
                      {{$order->payment_address_2}}<br>
                      {{$order->payment_city}}<br>
                      {{$order->payment_country}}
                    </td>
                    
                    <td>
                      {{$order->shipping_firstname}}<br>
                      {{$order->shipping_lastname}}<br>
                      {{$order->shipping_address_1}}<br>
                      {{$order->shipping_address_2}}<br>
                      {{$order->shipping_city}}<br>
                      {{$order->shipping_country}}
                    </td>
                  
                  </tr>
                
                </table>
              </div>
              <div class="table-responsive">
                <table class="table ">
                  <th>{{trans('icommerce::orders.table.product')}}</th>
                  {{-- <th>{{trans('icommerce::orders.table.reference')}}</th> --}}
                  <th>{{trans('icommerce::orders.table.sku')}}</th>
                  <th>{{trans('icommerce::orders.table.quantity')}}</th>
                  <th>{{trans('icommerce::orders.table.unit price')}}</th>
                  <th class="text-right">{{trans('icommerce::orders.table.total')}}</th>
                  
                  @foreach($products as $product)
                  <tr class="product-order" >
                    <td>
                      {{$product['title']}}<br>
                    </td>
                    <td>{{$product['sku']}}</td>
                    <td>{{$product['quantity']}}</td>
                    <td>{{$product['price']}}</td>
                    <td class="text-right">{{$product['total']}}</td>
                  </tr>
                  @endforeach
                  
                  <tr class="subtotal">
                    <td colspan="4" class="text-right">{{trans('icommerce::orders.table.subtotal')}}</td>
                    
                    <td class="text-right">{{number_format($subtotal, 2, ',', ' ') }}</td>
                  </tr>
                  
                  
                  <tr class="shippingTotal">
                    <td colspan="4" class="text-right">{{trans('icommerce::orders.table.shipping_method')}}</td>
                    <td class="text-right">{{ $order->shipping_method }} {{ $order->shipping_amount != 0 ? number_format( $order->shipping_amount , 2, ',', ' ') : '' }}</td>
                  </tr>
                  @if($order->tax_amount>0)
                  <tr class="taxAmount">
                    <td colspan="4" class="text-right">{{trans('icommerce::order_summary.tax')}}</td>
                    <td class="text-right">{{ number_format($order->tax_amount , 2, ',', ' ') }}</td>
                  </tr>
                  @endif
                  {{--
                  Validacion del Cupon
                  <tr class="coupon">
                    <td colspan="4" class="text-right">{{trans('icommerce::orders.table.coupon')}}</td>
                    <td>coupon Value</td>
                  </tr>
                  --}}
                  
                  <tr class="total">
                    <td colspan="4" class="text-right">{{trans('icommerce::orders.table.total')}}</td>
                    <td class="text-right">{{number_format($order->total , 2, ',', ' ') }}</td>
                  </tr>
                
                </table>
              </div>
            </div>
          
          </div>
        </div>
        
        <hr class="my-4 hr-lg">
        
        <div class="col-12 text-right mt-3 mt-md-0">
          <a href="{{ url('/orders') }}"
             class="btn btn-outline-primary btn-rounded btn-lg my-2">{{trans('icommerce::orders.button.Back_to_order_list')}}</a>
        </div>
      
      
      </div>
    
    </div>
  </div>
  <style type="text/css">
    table .clickable-row {
      cursor: pointer;
    }
  </style>
@stop

@section('scripts')
  @parent
  {!!Theme::script('js/app.js?v='.config('app.version'))!!}
  

@stop
