@extends('layouts.master')
@include('icommerce::frontend.partials.carting')
@section('content')

    <div>
        <div class="container">
            <div class="row">
                <div class="col">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-4 text-uppercase">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order List</li>
                        </ol>
                    </nav>

                    <h2 class="text-center mt-0 mb-5">My Order List</h2>

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
                                <th>ID</th>
                                <th>Email</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($orders)): ?>
                            <?php foreach ($orders as $order): ?>

                            <tr class='clickable-row' data-href="{{ url('/orders').'/'.$order->id }}">
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ $order->total }}</td>
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
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-8 text-right mt-3 mt-md-0">
                            <div class="cart-content-totals">
                                
                            </div>
                            <!-- Proceed to checkout -->
                            <a href="{{ url('/account') }}" class="btn btn-outline-primary btn-rounded btn-lg my-2">Back to my profile</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" v-show="items.length == 0">
                <div class="col p-6">
                    No orders found
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.5/js/mdb.min.js"></script>

    <script type="text/javascript">
        const vue_order_list = new Vue({
            el: '#orderList',
            created: function () {
                
            },
            data: {
                items: {!! $orders ? $orders : '[]' !!},
                user: {!! $user !!},
            },
            methods: {
                alerta: function (menssage, type) {
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 5000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    toastr[type](menssage);
                }
            },
            mounted: function () {
                this.$nextTick(function () {
                    $("table .clickable-row").click(function() {
                        console.log($(this).data("href"));
                        window.location = $(this).data("href");
                    });
                    setTimeout(function(){
                        $('#content_preloader').fadeOut(1000,function(){
                            $('#content_index_commerce').animate({'opacity':1},500);
                        });
                    },1800);
                })
            }
        });
    </script>
@stop
