<div class="bg-img d-flex justify-content-center align-items-center overflow-hidden">
	<a href="{{$product->url}}" title="{{$product->name}}">

		<figure>
			<picture>
				<source
				  	type="image/jpeg"
				    data-srcset="{{$product->mediaFiles()->mainimage->relativePath}}"
				 />
				<source
				  	type="image/jfif"
				    data-srcset="{{$product->mediaFiles()->mainimage->relativePath}}"
				 />
				<source
				  	type="image/png"
				    data-srcset="{{$product->mediaFiles()->mainimage->relativePath}}"
				 />
				<source
				  	type="image/svg"
				    data-srcset="{{$product->mediaFiles()->mainimage->relativePath}}"
				 />
				<img
					src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII="
					data-src="{{$product->mediaFiles()->mainimage->relativePath}}"
					alt = "{{$product->name}}"
					class="lazyload" />
			</picture>
		</figure>

	</a>
</div>
