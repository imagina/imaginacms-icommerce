@if($products->isNotEmpty())
<section class="iblock general-block12 py-5" data-blocksrc="general.block12">
  <div class="container">
    <div class="row">
      <div class="col-12">
        
        <div class="title-arrow mb-5">
          <h2 class="pr-5 bg-white text-uppercase"><strong>{{$category->title}}</strong></h2>
        </div>
        
        <div class="owl-carousel owl-theme owl-svg featured-{{$category->slug}}">
          @foreach($products as $product)
            
            <slide wire:key="'featured-new-product-{{$product->id}}'">
              @includeFirst(["icommerce.product.meta","icommerce::frontend.product.meta"])
              <div class="card-product">
                <div class="bg-img d-flex justify-content-center align-items-center overflow-hidden">
                  <a href="{{$product->url}}">
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
                <div class="mt-3 pb-3 text-center">
                  <div class="category">
                    {{$product->category->title }}
                  </div>
                  
                  <a v-bind:href="article.url" class="name cursor-pointer">
                    {{ $product->name }}
                  </a>
                  
                  <div class="price">
                    <i class="fa fa-shopping-cart icon"></i>
                    {{ formatMoney($product->price) }}
                  </div>
                  <a class="cart-no">&nbsp;</a>
                  @if($product->price!=0.00)
                    <a onClick="window.livewire.emit('addToCart',{{$product->id}})"
                       class="cart text-primary cursor-pointer">
                      Añadir al carrito
                    </a>
                  @else
                    <a href="/contacto" class="cart text-primary cursor-pointer">
                      Contacta con nosotros
                    </a>
                  @endif
                </div>
              </div>
            </slide>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@else
  <div></div>
@endif

@section('scripts-owl')
  <script>
    $(document).ready(function(){
      var owl = $('.featured-{{$category->slug}}');
      
      owl.owlCarousel({
        margin: 10,
        dots: false,
        autoplay: true,
        lazyLoad:true,
        autoplayHoverPause: true,
        responsiveClass: true,
        navText: ['<div class="prev-icon"></div>', '<div class="next-icon"></div>'],
        nav:true,
        responsive: {
          0: {
            items: 1
          },
          640: {
            items: 2
          },
          992: {
            items: 4
          }
        }
      });
      
    });
  </script>
  
  @parent

@stop
