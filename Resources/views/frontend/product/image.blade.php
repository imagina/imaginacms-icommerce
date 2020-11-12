<div class="bg-img d-flex justify-content-center align-items-center overflow-hidden">
	<a href="{{$product->new_url}}" title="{{$product->name}}">
			
		<figure>
			<picture>
				<source
				  	type="image/jpeg"
				    data-srcset="{{$product->mediaFiles()->mainimage->relativeMediumThumb}}"
				 />
				<img 
					data-src="{{$product->mediaFiles()->mainimage->relativeMediumThumb}}"
					alt = "{{$product->name}}" 
					class="lazyload mh-75" />
			</picture>
		</figure>

	</a>
</div>