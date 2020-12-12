@php($categorySelected = $categoryBreadcrumb[count($categoryBreadcrumb)-1] ?? null)

@php($isSelected = !empty($categorySelected) ? $categorySelected->id == $category->id ? true : false : false)

<li class="list-group-item {{$isSelected ? 'category-selected' : ''}} level-{{$level}}" aria-disabled="true" aria-expanded="true">

	@php($children = $categories->where("parent_id",$category->id))

	@php($expanded = false)
	
	@php($slug = $category->slug)
	
	
	@foreach($categoryBreadcrumb as $breadcrumb)
		@if($breadcrumb->id == $category->id)
			@php($expanded = true)
		@endif
	@endforeach

	@php($newUrl = isset($manufacturer->id) ? $category->urlManufacturer($manufacturer) : $category->url)
	
	
	@php($newUrl = isset($manufacturer->id) ? $category->urlManufacturer($manufacturer) : $category->url)
	
	{{--
	@php($newUrl = $category->url)
	--}}
	<a class="text-secondary" data-toggle="{{$isSelected ? "collapse" : ""}}"
		 href="{{$newUrl}}"
		 aria-disabled="false"
		 role="button" aria-expanded="false"
		 aria-controls="{{$children? "multiCollapse-$slug" : ""}}">
		
		@php($mediaFiles = $category->mediaFiles())
		
		@if(isset($mediaFiles->iconimage->path) && !strpos($mediaFiles->iconimage->path,"default.jpg"))
			<img class="category-icon filter" src="{{$mediaFiles->iconimage->path}}">
		@endif
		
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
					@include('icommerce::frontend.livewire.index.filters.categories.category-item',["level" => $level+1])
				@endforeach
			
		</ul>
	</div>

	@endif
</li>