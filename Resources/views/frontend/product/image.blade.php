<div class="bg-img d-flex justify-content-center align-items-center">
	<a href="{{$product->url}}" title="{{$product->name}}">
	
			<figure>
				<picture>
					<source type="image/jpeg" srcset="{{$product->mediaFiles()->mainimage->relativeMediumThumb}}">
						<img src="{{$product->mediaFiles()->mainimage->relativeMediumThumb}}" alt="{{$product->name}}">
			    </picture>
		    </figure>
		
	</a>
</div>