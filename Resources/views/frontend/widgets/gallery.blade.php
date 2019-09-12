@section('styles')
<style>
 
  
  .thumbnail-slider-container{
  
   height: 520px;
    
}
      .thumbnail-slider-container  .owl-carousel .owl-stage{
    width: max-content !important;
  height: 100%;
  }
  .thumbnail-slider{ 
  height: 130px; 
  width: 480px;
  transform: rotate(90deg);
     
  }
  .thumbnail-slider .owl-item{
  width: 130px !important;
  height: 150px !important;
  transform: rotate(-90deg) !important;
  }
   .thumbnail-slider .owl-item img{
   
    object-fit: cover;
    width: 100% !important;
  height: 100% !important;
 
   }
  .thumbnail-slider .owl-item .item{
  width: 100% !important;
  height: 100% !important;
 
  }
   
 
  .thumbnail-slider-container  .owl-carousel .owl-stage-outer{
    width: 480px !important;
  height: 100%;
}
    .thumbnail-slider-container  .owl-carousel .owl-nav.disabled,
    .thumbnail-slider-container  .owl-carousel .owl-nav{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
	height: 100%;
	padding: 0px 10px;
    position: absolute;
    cursor: pointer;
    z-index: 1;
    left: 480px;
    background: #fff;
    margin:0px;
    bottom: 0;
  }

  .thumbnail-slider-container  .owl-carousel .owl-nav .owl-prev, 
  .thumbnail-slider-container  .owl-carousel .owl-nav .owl-next{
        font-size:17px;
        padding: 10px !important;
        background: #F5F5F5;
        margin: 0px !important;
        height: 40%;

      }
      .thumbnail-slider-container  .owl-carousel .owl-nav .owl-prev i, 
  .thumbnail-slider-container  .owl-carousel .owl-nav .owl-next i{
      transform: rotate(90deg);
  }
#carouselGallery .carousel-inner .carousel-item img{
	height: 100% !important;
	object-fit: cover;
}
#carouselGallery{
	position: relative;

}
#carouselGallery .bt-search{
	position: absolute;
	bottom: 0px;
	right: 0px;
	font-size: 20px;
	display: flex;
	justify-content: center;
	align-items: center;
	width: 42px;
	height: 40px;
	color: #D9A300;
	background: #000;
}

.thumbnail-slider .owl-carousel .owl-item .item{
	margin: 0px !important;
}
 
</style>
@endsection

        

        <div class="" v-if="product_gallery && product_gallery.length>0">
            <div class="row thumbnail-slider-container">   

              <div class="col-3 d-none d-sm-block">
                <div id="owl-image-mini" class="thumbnail-slider owl-carousel  owl-theme ">
                  <div class="item" v-for="(img,index) in product_gallery" class="m-0">
                        
                        	  <img data-target="#carouselGallery" v-bind:data-slide-to="index" v-bind:src="img.path" class="">
                       
                      
                  </div>
        
                </div>
            
              </div> 


            <div id="carouselGallery" class="carousel slide col" data-ride="carousel">
                <div class="carousel-inner h-100">
                    <div class="carousel-item h-100" v-for="(img,index) in product_gallery" v-bind:class="[ (index == 0) ? 'active' : '']">
                        <a :href="img.path"  data-fancybox="gallery" :data-caption="product.title">
                        <img  v-bind:src="img.path"  class="img-big">
                        </a>
                        <a :href="img.path"  data-fancybox="gallery" class="bt-search"  :data-caption="product.title">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </a>
                    </div>
                </div>
                
                
            </div>


            </div>
        </div>
        
		<div class="" v-else >
            <a href="{{$product->mainImage['path']}}" data-fancybox="{{$product->title}}" data-caption="{{$product->title}}">
            <img src="{{$product->mainImage['path']}}" class="img-fluid w-100  p-1" alt="{{$product->title}}">
            </a>
        </div>

@section('scripts-owl')
@parent
<script>  
 
 $(document).ready(function () {

            $('#owl-image-mini').owlCarousel({
                
                responsiveClass: true,
                navText: ['<i class="fa fa-angle-down">','<i class="fa fa-angle-up">'],
                nav: true,
                loop: true,
                dots: false,
                lazyContent: true,
                autoplay: true,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 2
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 2
                    }
                }
            })

        });
  </script>
@endsection