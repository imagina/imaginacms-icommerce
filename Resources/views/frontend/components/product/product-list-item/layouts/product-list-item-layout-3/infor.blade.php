<div class="infor text-center">

	<div class="category">
        {{$product->category->title}}
    </div>

	<div class="name">
        <a href="{{$product->url}}" class="name cursor-pointer">
            {{$product->name}}
        </a>
    </div>


	@if(isset($productListLayout) && $productListLayout=='one')
		<div class="summary">
			{{$product->summary}}
		</div>
	@endif
	
	@if(isset($discount) && $discount)
		<div class="price">
			<i class="fa fa-shopping-cart icon"></i>
			{{isset($currency) ? $currency->symbol_left : '$'}}{{formatMoney($product->discount->price ?? $product->price)}}
		</div>
		<div class="cart-no"><del>Antes: {{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del></div>
	@else
		<div class="price">
	        <i class="fa fa-shopping-cart icon"></i>
	        {{isset($currency) ? $currency->symbol_left : '$'}}{{formatMoney($product->discount->price ?? $product->price)}}
    	</div>
    	<div class="cart-no">&nbsp;</div>
	@endif
	
	@if(($product->quantity >= 1) && ($product->stock_status))
	    @if($product->price>0)
		    <a onClick="window.livewire.emit('addToCart',{{$product->id}})" class="cart text-primary cursor-pointer">
		        Añadir al carrito
		    </a>
	    @else
		    <a href="{{ URL::to('/contacto') }}"  class="cart text-primary cursor-pointer">
		        Contacta con nosotros
		    </a>
	    @endif
	@endif

	{{--
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
				@if($product->price>0)
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
	--}}

	@if($addToCartWithQuantity)
		@include("icommerce::frontend.components.product.addToCartWithQuantity")
	@endif

</div>
