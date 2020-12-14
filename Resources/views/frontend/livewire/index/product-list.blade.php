<div class="product-list">

	@include('icommerce::frontend.livewire.index.top-content.index')

	<div class="products">
		<div class="row">
			
			@include('icommerce::frontend.partials.preloader')
			
			@if(isset($products) && count($products)>0)

				@foreach($products as $product)
				<div class="{{$layoutClass}} product">
					
					<x-icommerce-product-list-item :product="$product" :productListLayout="$productListLayout"/>
					
				</div>
				@endforeach

				<div class="product-list-pagination d-flex w-100 px-3 justify-content-end">
					{{ $products->links() }}
				</div>
				

			@else
				<div class="col-12">
					<div class="alert alert-danger my-5" role="alert">
					  {{trans('icommerce::common.messages.no products')}}
					</div>
				</div>
			@endif
			
		</div>
	</div>

</div>

@section('scripts-owl')
@parent
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
		window.livewire.emit('productListRendered',{!! json_encode($params) !!});
    });
</script>

@stop