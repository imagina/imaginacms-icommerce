<li class="list-group-item" aria-disabled="true" aria-expanded="true">

@php($children =  $category->children->isNotEmpty()  ? $category->children : null )
	@php($expanded = false)
	@foreach($categoryBreadcrumb as $breadcrumb)
		@if($breadcrumb->id == $category->id)
			@php($expanded = true)
		@endif
	@endforeach
	
	<a class="text-secondary" data-toggle="collapse"
		 href="{{$category->new_url}}"
		 role="button" aria-expanded="{{$expanded ? 'true' : 'false'}}"
		 aria-controls="multiCollapse-{{$category->slug}}">
		
		<i class="fa fa-plus" aria-hidden="true"></i>
		
		{{$category->title}}
	</a>
	@if($children)
	<div class="collapse multi-collapse {{$expanded ? 'show' : ''}}" id="multiCollapse-{{$category->slug}}">
		<ul class="list-group list-group-flush">
			
				
				@foreach($children as $category)
					@includeFirst(['icommerce.index.category','icommerce::frontend.index.category'])
				@endforeach
			
		</ul>
	</div>

	@endif
</li>