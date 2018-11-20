<div class="box-body row">

	<div class="col-xs-12 col-sm-4">

		<div class="panel panel-default">

		  <div class="panel-heading">
		  	<i style="margin-right: 5px;" class="fa fa-shopping-cart" aria-hidden="true"></i>
		  	{{trans('icommerce::orders.table.details')}}
		  </div>
		  
		  <ul class="list-group">
		    <li class="list-group-item">Fecha Creacion Value</li>
		    <li class="list-group-item">Metodo Pago Value</li>
		    <li class="list-group-item">Metodo Envio Value</li>
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
		    <li class="list-group-item">Nombre y Apellido Value</li>
		    <li class="list-group-item">Correo Value</li>
		    <li class="list-group-item">Telefono Value</li>
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
		    <li class="list-group-item">Invoice Value</li>
		  </ul>

		</div>
		
	</div>


	<div id="orderC" class="col-xs-12" >
		<div class="panel panel-default">

		  	<div class="panel-heading">
		  	<i style="margin-right: 5px;" class="fa fa-book" aria-hidden="true"></i>
		  	{{trans('icommerce::orders.table.order')}}
		  	#xxx
		  	</div>
		  
		 	<div class="panel-body">
    			<table class="table table-bordered">

    				<th>{{trans('icommerce::orders.table.payment address')}}</th>
    				<th>{{trans('icommerce::orders.table.shipping address')}}</th>

    				<tr>
    					<td>
    					Firstname Value<br>
    					Lastname Value<br>
    					Date Created Value<br>
    					Address 1 Value<br>
    					Address 2 Value<br>
    					City Value<br>
    					Country Value
    					</td>
    					
    					<td>
    					Firstname Value<br>
    					Lastname Value<br>
    					Date Created Value<br>
    					Address 1 Value<br>
    					Address 2 Value<br>
    					City Value<br>
    					Country Value
    					</td>
    					
    				</tr>
    
  				</table>

  				<table class="table table-bordered">
  					<th>{{trans('icommerce::orders.table.product')}}</th>
    				<th>{{trans('icommerce::orders.table.reference')}}</th>
    				<th>{{trans('icommerce::orders.table.quantity')}}</th>
    				<th>{{trans('icommerce::orders.table.unit price')}}</th>
    				<th>Total</th>

    				@for ($i = 0; $i < 3; $i++)
    					

	    				<tr class="product-order">
		    				<td>
		    					Product Name Value<br>
		    					Options Product Order Value
		    				</td>
		    				<td>Model Product Value</td>
		    				<td>Quantity Product Value</td>
		    				<td>Price Product Value</td>
		    				<td>Total Product Value</td>
		    			</tr>

	    			@endfor

	    			<tr class="subtotal">
	    				<td colspan="4" class="text-right">Subtotal</td>
	    				<td>Subtotal Value</td>
	    			</tr>

	    			<tr class="shippingTotal">
	    				<td colspan="4" class="text-right">shippingTotal Name Value</td>
	    				<td>shippingTotal Value</td>
	    			</tr>

	    			<tr class="coupon">
	    				<td colspan="4" class="text-right">{{trans('icommerce::orders.table.coupon')}}</td>
	    				<td>coupon Value</td>
	    			</tr>

	    			<tr class="total">
	    				<td colspan="4" class="text-right">Total</td>
	    				<td>Total Order</td>
	    			</tr>

  				</table>

  			</div>

		</div>
	</div>

	

</div>