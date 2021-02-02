@php($categorySelected = $categoryBreadcrumb[count($categoryBreadcrumb)-1] ?? null)

@php($isSelected = !empty($categorySelected) ? $categorySelected->id == $category->id ? true : false : false)

<li class="list-group-item {{$isSelected ? 'category-selected' : ''}} level-{{$level}}">
	
	
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
	@if($children->isNotEmpty())
		<div class="link-desktop d-none d-md-block {{$isSelected && $children ? 'font-weight-bold' : ''}}">
			<a href="{{$category->url}}" class="text-href ">
				@php($mediaFiles = $category->mediaFiles())
				@if(isset($mediaFiles->iconimage->path) && !strpos($mediaFiles->iconimage->path,"default.jpg"))
					<img class="category-icon filter" src="{{$mediaFiles->iconimage->path}}">
				@endif
				{{$category->title}}
			</a>
			<a class="icon-collapsable" data-toggle="collapse" role="button"
			   href="#multiCollapse-{{$slug}}" aria-expanded="{{$isSelected && $children ? 'true' : 'false'}}"
			   aria-controls="multiCollapse-{{$slug}}">
				<i class="fa angle"></i>
			</a>
		</div>
		<div class="link-movil d-block d-md-none {{$isSelected && $children ? 'font-weight-bold' : ''}}">
			<a class="text-collapsable" data-toggle="collapse" role="button"
			   href="#multiCollapse-{{$slug}}" aria-expanded="{{$isSelected && $children ? 'true' : 'false'}}"
			   aria-controls="multiCollapse-{{$slug}}">
				@php($mediaFiles = $category->mediaFiles())
				@if(isset($mediaFiles->iconimage->path) && !strpos($mediaFiles->iconimage->path,"default.jpg"))
					<img class="category-icon filter" src="{{$mediaFiles->iconimage->path}}">
				@endif
				{{$category->title}}
			</a>
			<a href="{{$category->url}}" class="icon-href float-right">
				<i class="fa fa-external-link"></i>
			</a>
		</div>
		<div class="collapse multi-collapse mt-2 {{$expanded ? 'show' : ''}}" id="multiCollapse-{{$slug}}">
			<ul class="list-group list-group-flush">
				@foreach($children as $category)
					@include('icommerce::frontend.livewire.index.filters.categories.category-item',["level" => $level+1,"categoryId" => $category->id])
				@endforeach
			</ul>
		</div>
	@else
	
		<a href="{{$category->url}}" class="link-childless d-block {{$isSelected && $children->isEmpty() ? 'font-weight-bold' : ''}}"> {{$category->title}} </a>

	@endif

</li>