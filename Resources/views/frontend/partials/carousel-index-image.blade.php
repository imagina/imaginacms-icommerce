<div class="carousel-index-image">
	
	<div id="carouselIndexImageIndicators" class="carousel slide" data-ride="carousel">

		@if(count($gallery) > 1)
			  <ol class="carousel-indicators">
			  	@foreach($gallery as $index => $img)
			    	<li data-target="#carouselIndexImageIndicators" data-slide-to="{{$index}}" class="@if($loop->first) active @endif"></li>
			   	@endforeach
			  </ol>
		@endif

	  <div class="carousel-inner">

	  	@foreach($gallery as $index => $img)
		    <div class="carousel-item @if($loop->first) active @endif">
		      <img class="d-block w-100" src="{{$img->path}}" alt="slide-{{$index}}">
		    </div>
		@endforeach

	  </div>

	  @if(count($gallery) > 1)
		  <a class="carousel-control-prev" href="#carouselIndexImageIndicators" role="button" data-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselIndexImageIndicators" role="button" data-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		@endif

	</div>

</div>