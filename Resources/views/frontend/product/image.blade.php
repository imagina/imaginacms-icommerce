<div class="bg-img d-flex justify-content-center align-items-center">
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
					class="lazyload" />
			    </picture>
		    </figure>
		
	</a>
</div>