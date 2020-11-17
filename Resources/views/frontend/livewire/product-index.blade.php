<section class="iblock general-block12 py-5" data-blocksrc="general.block12">
  <div class="container">
    <div class="row">
      <div class="col-12">
      
        <div class="title-arrow text-center mb-5">
          <h2 class="px-5 bg-white"><strong>NUEVOS</strong> PRODUCTOS</h2>
        </div>
        
        <div id="productIndex" class="owl-carousel owl-theme">
            @foreach($products as $product)
            <slide wire:key="'featured-new-product-{{$product->id}}'">
              @includeFirst(["icommerce.product.meta","icommerce::frontend.product.meta"])
              <div class="card-product">
                <div class="bg-img">
                  <a href="{{$product->url}}">
                
                    <img title="{{$product->name}}" alt="{{$product->name}}" src="{{$product->mediaFiles()->mainimage->mediumThumb}}" >
                  </a>
                </div>
                <div class="mt-3 pb-3 text-center">
                  <div class="category">
                    {{$product->category->title }}
                  </div>
          
                  <a href="{{$product->url}}" class="name cursor-pointer">
                    {{ $product->name }}
                  </a>
          
                  <div class="price mt-3">
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



@section('scripts-owl')
  <script>
    $(document).ready(function(){
      var owl = $('#productIndex');
      
      owl.owlCarousel({
        loop: true,
        lazyLoad:true,
        margin: 10,
        dots: false,
        responsiveClass: true,
        autoplay: true,
        autoplayHoverPause: true,
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
