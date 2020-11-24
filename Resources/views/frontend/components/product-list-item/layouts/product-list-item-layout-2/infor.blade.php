<div class="infor">

	<a class="title" href="{{$product->url}}">{{$product->name}}</a>

	<div class="category">{{$product->category->title}}</div>

	@if(isset($mainLayout) && $mainLayout=='one')
		<div class="summary">
			{{$product->summary}}
		</div>
	@endif
	
	@if(isset($product->discount))
		<div class="del-price">
			<del>{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
		</div>
	@endif
	
	
	<div class="row align-items-end">
        <div class="col">
        	<div class="price">
				{{isset($currency) ? $currency->symbol_left : '$'}}
				{{formatMoney($product->discount->price ?? $product->price)}}
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

</div>