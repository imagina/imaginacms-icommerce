@extends('layouts.master')
@include('icommerce::frontend.partials.carting')
@section('content')
    @php
        $currency=localesymbol($code??'USD')
    @endphp
    <div>
        <div class="container">
            <div class="row">
                <div class="col">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-4 text-uppercase">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">{{trans('icommerce::common.home.title')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{trans('icommerce::orders.breadcrumb.title')}}</li>
                        </ol>
                    </nav>

                    <h2 class="text-center mt-0 mb-5">{{trans('icommerce::orders.title.single_order_title')}}</h2>

                </div>
            </div>
        </div>
    </div>


<div id="orderList" class="pb-5">
    <div class="container">
        <div class="cart-content" v-show="items.length > 0">
            <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class=" bg-secondary text-white">
                            <tr>
                                <th>{{trans('icommerce::orders.table.id')}}</th>
                                <th>{{trans('icommerce::orders.table.email')}}</th>
                                <th>{{trans('icommerce::orders.table.total')}}</th>
                                <th>{{trans('icommerce::orders.table.status')}}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($orders)): ?>
                            <?php foreach ($orders as $order): ?>

                            <tr class='clickable-row' data-href="{{ url('/orders').'/'.$order->id }}">
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->email }}</td>
                                 <td>{{$currency->symbol_left}} {{formatMoney($order->total) }}{{$currency->symbol_right}} </td>
                                    <td>{{icommerce_get_Orderstatus()->get($order->order_status)}}</td>
                                    <td>{{ $order->created_at }}</td>
                            </tr>

                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
               </div>
                <!--End of Shopping cart items-->
                <hr class="my-4 hr-lg">
                <div class="cart-content-footer">
                    <div class="row">
                        {{ $orders->links() }}
                    </div>
                    <div class="row">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-8 text-right mt-3 mt-md-0">
                            <div class="cart-content-totals">
                                
                            </div>
                            <!-- Proceed to checkout -->
                            <a href="{{ url('/account') }}" class="btn btn-outline-primary btn-rounded btn-lg my-2">{{trans('icommerce::orders.button.Back_to_profile')}}</a>
                        </div>
                    </div>
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

    <script type="text/javascript">
        $(document).ready(function () {
          $("table .clickable-row").click(function() {
            console.log($(this).data("href"));
            window.location = $(this).data("href");
          });
        });
    </script>
@stop
