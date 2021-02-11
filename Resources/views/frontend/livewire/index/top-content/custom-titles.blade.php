@php($customIndexTitle = setting('icommerce::customIndexTitle'))
<h1 class="text-primary text-uppercase font-weight-bold h3">{{$category->title ?? (!empty($customIndexTitle) ? setting('icommerce::customIndexTitle') : trans('icommerce::products.title.products') )}} {{isset($manufacturer->id) ? isset($category->id) ? "/ $manufacturer->name" : $manufacturer->name : ""}}</h1>

@if(isset($category->options->descriptionIndex) && !empty($category->options->descriptionIndex))
	<p class="category-index-description">
		{{$category->options->descriptionIndex}}
	</p>
@else
	@php($customIndexDescription = setting('icommerce::customIndexDescription'))
	@if(!empty($customIndexDescription))
		<p class="custom-index-description">
			{{$customIndexDescription}}
		</p>
	@endif
@endif

<hr>