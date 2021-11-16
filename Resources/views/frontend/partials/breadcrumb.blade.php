<x-isite::breadcrumb>
	<li class="breadcrumb-item text-capitalize store-index" aria-current="page">
		@if(isset($category->id) || isset($manufacturer->id))
			<a href="{{tenant_route(request()->getHost(), \LaravelLocalization::getCurrentLocale() . '.icommerce.store.index')}}">
				{{ trans('icommerce::routes.store.index.index') }}
				@isset($organization->id)
					{{$organization->title}}
					@endisset
			</a>
		@else
			{{ trans('icommerce::routes.store.index.index') }}
			@isset($organization->id)
				{{$organization->title}}
			@endisset
		@endif
	</li>
	
	@isset($categoryBreadcrumb)
		@foreach($categoryBreadcrumb as $key => $breadcrumb)
			<li class="breadcrumb-item category-index {{($key == count($categoryBreadcrumb)-1) ? 'category-index-selected' : ''}}" aria-current="page">
				@if($key == count($categoryBreadcrumb)-1 && !isset($product))
					@if(isset($manufacturer->id))
						<a href="{{$breadcrumb->url}}">{{ $breadcrumb->title }}</a>
					@else
						{{ $breadcrumb->title }}
					@endif
				
				@else
					<a href="{{$breadcrumb->url}}">{{ $breadcrumb->title }}</a>
				@endif
			</li>
		@endforeach
	@endif

	@if(isset($product->id))
		<li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
	@endif
	
	@if(isset($manufacturer->id))
		<li class="breadcrumb-item text-capitalize manufacturer-index-selected" aria-current="page">
			<a href="{{$manufacturer->url}}">
				{{$manufacturer->name}}
			</a>
		</li>
	@endif
</x-isite::breadcrumb>

