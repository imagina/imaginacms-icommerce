<div class="infor">

	<a class="title" href="{{$product->url}}">{{$product->name}}</a>

	<div class="category">{{$product->category->title}}</div>

	@if(isset($productListLayout) && $productListLayout=='one')
		<div class="summary">
			{{$product->summary}}
		</div>
	@endif
	
	
	@if(isset($discount) && $discount)
		<div class="del-price">
			<del>{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
		</div>
	@endif
	
	
	<div class="row align-items-end">
        <div class="col">
        	<div class="price">
				{{isset($currency) ? $currency->symbol_left : '$'}}
				{{formatMoney($discount->price ?? $product->price)}}
			</div>
		</div>

        <div class="col-auto">

        	<div class="buttons">
				@if($product->price>0  && $product->stock_status && $product->quantity)
					<a class="add-cart" onClick="window.livewire.emit('addToCart',{{$product->id}})">
					   <i class="fa fa-shopping-basket"></i>
					</a>
				@endif
				<a class="wishlist" href="#">
				    <i class="fa fa-heart-o"></i>
				</a>
			</div>
        	
        </div>

    </div>
	@if($product->price>0 && $product->stock_status && $product->quantity)
	<div class="row add-to-cart-with-quantity">
		<!-- BUTTON QUANTITY -->
		<div class="number-input input-group quantity-selector">
			<input type="button" value="-" class="button-minus" data-field="quantity">
			<input type="number" step="1" max="" value="1" name="quantity" class="quantity-field" id="quantityField{{$product->id}}">
			<input type="button" value="+" class="button-plus" data-field="quantity">
		</div>
		
		<!-- BUTTON ADD -->
		<div class="add-to-cart-button"  >
			<a  onClick="addToCart({{$product->id}})"  class="btn btn-primary">
				<i class="fa fa-shopping-cart" ></i>Comprar
			</a>
		</div >
		
	</div>
	@endif
	

	

</div>


@section('scripts')
	
	<script>
		
		function incrementValue(e) {
			e.preventDefault();
			var fieldName = $(e.target).data('field');
			var parent = $(e.target).closest('div');
			var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
			
			if (!isNaN(currentVal)) {
				parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
			} else {
				parent.find('input[name=' + fieldName + ']').val(0);
			}
		}
		
		function decrementValue(e) {
			e.preventDefault();
			var fieldName = $(e.target).data('field');
			var parent = $(e.target).closest('div');
			var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
			
			if (!isNaN(currentVal) && currentVal > 0) {
				parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
			} else {
				parent.find('input[name=' + fieldName + ']').val(1);
			}
		}
		
		function addToCart(productId){
			let quantity = $('#quantityField'+productId).val();
			window.livewire.emit('addToCart',productId, quantity )
			$('#quantityField'+productId).val(1)
		}
		
		$('.input-group').on('click', '.button-plus', function(e) {
			incrementValue(e);
		});
		
		$('.input-group').on('click', '.button-minus', function(e) {
			decrementValue(e);
		});
		
	</script>
	
	@stop