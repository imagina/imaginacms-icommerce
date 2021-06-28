@include('icommerce::frontend.partials.preloader')

<div class="item-options__title">
	{{ trans('icommerce::products.title.orderBy') }}
</div>
<button type="button" class="item-options__close btn py-0 px-1">
	<i class="fa fa-times-circle-o" aria-hidden="true"></i>
</button>

<div class="filter-order-by my-3">

	@foreach( $this->configs['orderBy']['options'] as $key => $orderOption)

		<div class="custom-control custom-radio my-2">

		    <input class="custom-control-input" type="radio"
		  		value="{{$orderOption['name']}}"
		  		name="f-order-by{{$key}}"
		  		id="f-order-by{{$key}}"
		  		wire:model="orderBy" onclick="deleteClass()">

		    <label class="custom-control-label"
					for="f-order-by{{$key}}">
					{{trans($orderOption['title'])}}
			</label>

		</div>

	@endforeach
</div>

@section('scripts-owl')
   @parent

    <script type="text/javascript">

      	var body = document.body;

      	function deleteClass(){
      		body.classList.toggle('overflow-hidden');
      	}

    </script>

@stop
