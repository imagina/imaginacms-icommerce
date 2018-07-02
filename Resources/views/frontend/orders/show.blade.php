@extends('layouts.master')
@include('icommerce::frontend.partials.carting')
@section('content')
    <div id="content_preloader"><div id="preloader"></div></div>

    <div>
        <div class="container">
            <div class="row">
                <div class="col">

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-4 text-uppercase">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('/orders') }}">Order List</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                        </ol>
                    </nav>

                    <h2 class="text-center mt-0 mb-5">My Order Details</h2>

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
		    <li class="list-group-item">@{{order.created_at}}</li>
		    <li class="list-group-item">@{{order.payment_method}}</li>
		    <li class="list-group-item">@{{order.shipping_method}}</li>
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
		    <li class="list-group-item">@{{order.first_name}} @{{order.last_name}}</li>
		    <li class="list-group-item">@{{order.email}}</li>
		    <li class="list-group-item">@{{order.telephone}}</li>
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
		    	<li class="list-group-item" v-show="order.invoice_nro">@{{order.invoice_nro}}</li>
		    	@if($order)
		    	<li class="list-group-item" v-show="order.order_status">{{icommerce_get_Orderstatus()->get($order->order_status)}}</li>
		  		@endif
		  </ul>

		</div>
		
	</div>

	</div>
	<hr class="my-4 hr-lg">
	<div class="row">
		<div id="orderC" class="col-12" >
			<div class="card">

			  	<div class="card-header bg-secondary text-white">
			  	<i style="margin-right: 5px;" class="fa fa-book" aria-hidden="true"></i>
			  	{{trans('icommerce::orders.table.order')}}
			  	# @{{order.id}}
			  	</div>
			  	
			 	<div class="card-body">
			 		<div class="table-responsive">
		    			<table class="table ">

		    				<th>{{trans('icommerce::orders.table.payment address')}}</th>
		    				<th>{{trans('icommerce::orders.table.shipping address')}}</th>

		    				<tr>
		    					<td>
		    					@{{order.payment_firstname}}<br>
		    					@{{order.payment_lastname}}<br>
		    					@{{order.payment_address_1}}<br>
		    					@{{order.payment_address_2}}<br>
		    					@{{order.payment_city}}<br>
		    					@{{order.payment_country}}
		    					</td>
		    					
		    					<td>
		    					@{{order.shipping_firstname}}<br>
		    					@{{order.shipping_lastname}}<br>
		    					@{{order.shipping_address_1}}<br>
		    					@{{order.shipping_address_2}}<br>
		    					@{{order.shipping_city}}<br>
		    					@{{order.shipping_country}}
		    					</td>
		    					
		    				</tr>
		    
		  				</table>
					</div>
	  				<div class="table-responsive">
	  				<table class="table ">
	  					<th>{{trans('icommerce::orders.table.product')}}</th>
	    				{{-- <th>{{trans('icommerce::orders.table.reference')}}</th> --}}
	    				<th>Sku</th>
	    				<th>{{trans('icommerce::orders.table.quantity')}}</th>
	    				<th>{{trans('icommerce::orders.table.unit price')}}</th>
	    				<th>Total</th>
	    				
	 
	    					<tr class="product-order" v-for="product in products">
	    						<td>
			    					@{{product.title}}<br>
			    				</td>
			    				<td>@{{product.sku}}</td>
			    				<td>@{{product.quantity}}</td>
			    				<td>@{{product.price}}</td>
			    				<td>@{{product.total}}</td>
	    					</tr>

	    				
		    			<tr class="subtotal">
		    				<td colspan="4" class="text-right">Subtotal</td>

		    				<td class="text-right">@{{subtotal |numberFormat}}</td>
		    			</tr>

		
		    			<tr class="shippingTotal">
		    				<td colspan="4" class="text-right">@{{order.shipping_method}}</td>
		    				<td class="text-right">@{{ order.shipping_amount | numberFormat}}</td>
		    			</tr>
		    			
		    			<tr class="taxAmount" v-show="order.tax_amount!=0">
		    				<td colspan="4" class="text-right">{{trans('icommerce::order_summary.tax')}}</td>
		    				<td class="text-right">@{{ order.tax_amount | numberFormat}}</td>
		    			</tr>
		    			{{--
		    			Validacion del Cupon
		    			<tr class="coupon">
		    				<td colspan="4" class="text-right">{{trans('icommerce::orders.table.coupon')}}</td>
		    				<td>coupon Value</td>
		    			</tr>
		    			--}}

		    			<tr class="total">
		    				<td colspan="4" class="text-right">Total</td>
		    				<td class="text-right">@{{order.total | numberFormat}}</td>
		    			</tr>

	  				</table>
					</div>
	  			</div>

			</div>
		</div>

	    <hr class="my-4 hr-lg">

	        <div class="col-12 text-right mt-3 mt-md-0">
	            <a href="{{ url('/orders') }}" class="btn btn-outline-primary btn-rounded btn-lg my-2">Back to My Order List</a>
	        </div>

          
    </div>

    </div>
    <div class="container" v-else>
    	<div class="row" >
            <div class="col-12 p-6">
                No order found
            </div>
             <div class="col-12 text-right mt-3 mt-md-0">
	            <a href="{{ url('/orders') }}" class="btn btn-outline-primary btn-rounded btn-lg my-2">Back to My Order List</a>
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
        const vue_order_details = new Vue({
            el: '#orderDetails', 
            data: {
                order: {!! $order ? $order : "''" !!},
                products: {!! $products ? $products : "''" !!},
                user: {!! $user !!},
                subtotal:0,
            },
            filters: {
            	twoDecimals: function (value) {
                    return Number(Math.round(value +'e'+ 2) +'e-'+ 2).toFixed(2);
                },
                numberFormat: function (value) {
                
                    return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                
                }
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
                	if(vue_order_details.order)
		                if(vue_order_details.order.shipping_amount)
							vue_order_details.subtotal = vue_order_details.order.total - vue_order_details.order.shipping_amount;
						else
							vue_order_details.subtotal = vue_order_details.order.total;
					
					if(vue_order_details.order.tax_amount)
						vue_order_details.subtotal = vue_order_details.subtotal - vue_order_details.order.tax_amount;

					console.log(vue_order_details.products);

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
