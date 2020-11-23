<div class="products-list">

	@include('icommerce::frontend.index.top-content.index')

	<div class="products">
		<div class="row">
			
			@include('icommerce::frontend.partials.preloader')
			
			@if(isset($products) && count($products)>0)

				@foreach($products as $product)
				<div class="{{$layoutClass}} product">

					@if($mainLayout=='one')
						@include('icommerce::frontend.product.layout-one')
					@else
						@include('icommerce::frontend.product.layout')
					@endif

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

@section('scripts')
@parent
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        window.livewire.on('urlChange', (param) => {
           	history.pushState(null, null, `${document.location.pathname}?${param}`);
        });
			window.livewire.emit('productListRendered',{!! json_encode($params) !!});
    });
</script>

@stop