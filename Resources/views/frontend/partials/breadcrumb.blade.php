@component('partials.widgets.breadcrumb')
		<li class="breadcrumb-item text-capitalize" aria-current="page">
			@if(isset($category->id))
			<a href="{{\URL::route(\LaravelLocalization::getCurrentLocale() . '.icommerce.store.index')}}">
				{{ trans('icommerce::routes.store.index') }}
			</a>
				@else
				{{ trans('icommerce::routes.store.index') }}
				@endif
		</li>
	
		@foreach($categoryBreadcrumb as $key => $breadcrumb)
			<li class="breadcrumb-item" aria-current="page">
				@if($key == count($categoryBreadcrumb)-1)
					{{ $breadcrumb->title }}
				@else
					<a href="{{$breadcrumb->url}}">{{ $breadcrumb->title }}</a>
				@endif
			</li>
		@endforeach
		
@endcomponent