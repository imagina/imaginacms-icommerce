<div class="product-list">

	@include('icommerce::frontend.livewire.index.top-content.index')

	<div class="products">
		
		@include('icommerce::frontend.partials.preloader')
			
		@if(isset($products) && count($products)>0)

			<div class="row">
				@foreach($products as $product)
				<div class="{{$layoutClass}} product">
					
					<x-icommerce::product-list-item :product="$product" :productListLayout="$productListLayout"/>
					
				</div>
				@endforeach
			</div>

			<div class="row">
				<div class="product-list-pagination d-flex w-100 px-3 justify-content-end">
					{{ $products->links('icommerce::frontend.livewire.index.custom-pagination') }}
				</div>
			</div>
	
		@else
			<div class="row">
				<div class="alert alert-danger my-5" role="alert">
					{{trans('icommerce::common.messages.no products')}}
				</div>
			</div>
		@endif
			
	</div>

</div>

@section('scripts')
@parent
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
		window.livewire.emit('productListRendered',{!! json_encode($params) !!});
    });
    
    $(document).on('click', '.page-link-scroll', function (e) {
    	let scrollPos = $(".product-list").offset().top; 

	  $("html, body").animate({ scrollTop: scrollPos }, "slow");
	  return false;
	});
</script>

@stop