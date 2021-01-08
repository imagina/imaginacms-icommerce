<div class="infor mt-3 pb-3">

	<a class="title" href="{{$product->url}}">{{$product->name}}</a>

	<div class="category">{{$product->category->title}}</div>

	@if(isset($productListLayout) && $productListLayout=='one')
		<div class="summary mt-2">
			{{$product->summary}}
		</div>
	@endif
	
	
		@if(isset($product->discount))
		<div class="del-price">
			<del>{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
		</div>
		@endif
	
	<div class="price">
		{{isset($currency) ? $currency->symbol_left : '$'}}
		{{formatMoney($product->discount->price ?? $product->price)}}
	</div>

	<div class="buttons-card">
		@if($product->price>0)
			<a onClick="window.livewire.emit('addToCart',{{$product->id}})"
				 class="text-primary">
			   <i class="fa fa-shopping-basket"></i>
			</a>
		@endif
		<a href="#" class="text-primary">
		    <i class="fa fa-heart-o mx-2"></i>
		</a>
	</div>

</div>