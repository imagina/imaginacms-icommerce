<div class="change-layout-mobile">

	<div class="types-columns ml-1">
		
		<div wire:click="changeLayout('four')" class="view-op {{$productListLayout=='four' || $productListLayout=='three' ? 'active text-primary' : ''}}">
			<i class="fa fa-align-justify four mx-1 cursor-pointer" aria-hidden="true"></i>
			{{trans('icommerce::frontend.index.views')}}
		</div>		
		
		<div wire:click="changeLayout('one')" class="view-op {{$productListLayout=='one' ? 'active text-primary' : ''}}">

			<i class="fa fa-th-large one mx-1 cursor-pointer" aria-hidden="true"></i>
			{{trans('icommerce::frontend.index.views')}}

		</div>

	</div>
	
</div>