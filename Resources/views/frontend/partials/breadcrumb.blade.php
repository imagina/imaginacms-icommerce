<x-isite::breadcrumb>
	<li class="breadcrumb-item text-capitalize store-index" aria-current="page">
		@if(isset($category->id) || isset($manufacturer->id))
			<a href="{{\URL::route(\LaravelLocalization::getCurrentLocale() . '.icommerce.store.index')}}">
				{{ trans('icommerce::routes.store.index.index') }}
			</a>
		@else
			{{ trans('icommerce::routes.store.index.index') }}
		@endif
	</li>
	
	@foreach($categoryBreadcrumb as $key => $breadcrumb)
		<li class="breadcrumb-item category-index {{($key == count($categoryBreadcrumb)-1) ? 'category-index-selected' : ''}}" aria-current="page">
			@if($key == count($categoryBreadcrumb)-1)
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
	
	@if(isset($manufacturer->id))
		<li class="breadcrumb-item text-capitalize manufacturer-index-selected" aria-current="page">
			<a href="{{$manufacturer->url}}">
				{{$manufacturer->name}}
			</a>
		</li>
	@endif
</x-isite::breadcrumb>

