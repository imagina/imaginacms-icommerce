<div class="bg-img d-flex justify-content-center align-items-center overflow-hidden" style="position: relative">
  <!--Ribbon discount-->
  @if($product->discount)
    <div id="ribbonFeatured">
      <div id="asideRibbon">
        @if($product->discount->criteria == 'fixed')
          <b><i class="fa fa-tags"></i></b>
        @else
          <b>{{$product->discount->discount}}%</b>
        @endif
        <div class="labelAsideRibbon">DTO.</div>
      </div>
    </div>
  @endif


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

<style>
  #ribbonFeatured {
    width: max-content;
    position: absolute;
    top: 5px;
    right: 0;
  }
  #ribbonFeatured #asideRibbon{
    position: relative;
    cursor: pointer;
    padding: 8px 10px 8px 6px;
    background-color: #fff200;
    line-height: 1.1;
  }
  #ribbonFeatured #asideRibbon::after{
    content: '';
    position: absolute;
    height: 0;
    width: 0;
    top: 0;
    border-style: solid;
    border-width: 22px 22px 22px 0;
    border-color: transparent #fff200;
    left: -22px;
  }
  #ribbonFeatured #asideRibbon .labelAsideRibbon{
    font-size: 10px;
  }
</style>
