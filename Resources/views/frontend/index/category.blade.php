<li class="list-group-item" aria-disabled="true" aria-expanded="true">
	
	@php($children = $categories->where("parent_id",$category->id))

	@php($expanded = false)
	
	@php($slug = $category->slug)
	
	@php($categorySelected = $categoryBreadcrumb[count($categoryBreadcrumb)-1] ?? null)
	
	@php($isSelected = !empty($categorySelected) ? $categorySelected->id == $category->id ? true : false : false)
	
	@foreach($categoryBreadcrumb as $breadcrumb)
		@if($breadcrumb->id == $category->id)
			@php($expanded = true)
		@endif
	@endforeach
	
	{{--
	@php($newUrl = $category->new_url.$extraParamsUrl)
	--}}
	@php($newUrl = $category->new_url)
	<a class="text-secondary" data-toggle="{{$isSelected ? "collapse" : ""}}"
		 href="{{$newUrl}}"
		 aria-disabled="false"
		 role="button" aria-expanded="false"
		 aria-controls="{{$children? "multiCollapse-$slug" : ""}}">
		
		
		<i class="fa fa-angle-{{$isSelected && $children ? 'down' : 'right'}}" ></i>
		
		@if($isSelected)
		<strong>
			{{$category->title}}
		</strong>
		@else
			{{$category->title}}
		@endif
	</a>
	@if($children)
	<div class="collapse multi-collapse {{$expanded ? 'show' : ''}}" id="multiCollapse-{{$slug}}">
		<ul class="list-group list-group-flush">
			
				
				@foreach($children as $category)
					@includeFirst(['icommerce.index.category','icommerce::frontend.index.category'])
				@endforeach
			
		</ul>
	</div>

	@endif
</li>