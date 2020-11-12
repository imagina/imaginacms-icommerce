<div id="content_carting" class="dropdown">
  <a class="nav-link" type="button"
     id="dropdownCart" data-toggle="dropdown" aria-haspopup="true"
     aria-expanded="false">
    
    <div class="cart d-inline-block">
      <span class="quantity bg-warning text-dark">{{  $cart->quantity  }}</span>
      <svg class="cart" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.72 21.97">
        <g id="Capa_2" data-name="Capa 2">
          <g id="Capa_1-2" data-name="Capa 1">
            <path class="cls-1"
                  d="M22.66,12.93l2-8.93a1,1,0,0,0-1-1.25H6.83L6.44.82a1,1,0,0,0-1-.82H1A1,1,0,0,0,0,1v.69a1,1,0,0,0,1,1H4L7,17.48a2.4,2.4,0,1,0,2.88.37h9a2.41,2.41,0,1,0,2.73-.45l.24-1a1,1,0,0,0-1-1.26H9.36l-.28-1.37H21.66A1,1,0,0,0,22.66,12.93Z"/>
          </g>
        </g>
      </svg>
    </div>
  </a>
  
  
  <!--Shopping cart-->
  <div class="cart-dropdown-menu " aria-labelledby="dropdownCart" style="z-index: 99999;">
    <!--Shopping cart dropdown -->
    <div class="dropdown-menu dropdown-menu-right rounded-0" aria-labelledby="dropdownCart"
         style="  min-width: 20rem; z-index: 9999999">
      <!-- titulo -->
      @if($cart->products->count())
        <h4 class="dropdown-header mb-0 font-weight-bold text-center">
          {{trans('icommerce::cart.articles.cart')}} ({{$cart->products->count()}})
          <i class="fa fa-trash text-muted float-right" title="Vaciar carrito" v-on:click="clear_cart()"></i>
        </h4>
      @else
      <h5 class="dropdown-header mb-0 font-weight-bold text-center" v-else>
        {{trans('icommerce::cart.articles.empty_cart')}}
      </h5>
      @endif
      <!-- articulos en el carrito -->
      @if($cart->products->count())
        @foreach($cart->products as $cartProduct)
 
          <div class="item_carting px-3 w-100 row m-0">
            <hr class="mt-0 mb-3 w-100">
        
            <!-- imagen -->
            <div class="col-3 px-0 mb-3">
              <a href="{{$cartProduct->product->url}}">
                <div
                  class="img_product_carting mr-3 border"
                  style="height: 80px; width: 100%;background-size: contain;  background-repeat: no-repeat;  background-position: center; background-image: url('{{$cartProduct->product->mediaFiles()->mainimage->smallThumb}}'); cursor: pointer;"
                  >
                </div>
              </a>
            </div>
            <!-- descripción -->
            <div class="col-9">
              
              <!-- titulo -->
              <h6 class="mb-2 w-100 __title">
                <a href="{{$cartProduct->product->url}}">
                  {{ $cartProduct->product->name }}
                  @if($cartProduct->productOptionValues->count())
                    <label>({{($cartProduct->productOptionValues->first()->optionValue)}})</label>
                  @endif
                </a>
              </h6>
              <!-- valor y cantidad -->
              <p class="mb-0 text-muted pb-2" style="font-size: 13px">
                {{trans('icommerce::cart.table.quantity')}}: {{ $cartProduct->quantity }} <br>
                {{trans('icommerce::cart.table.price_per_unit')}}: {{isset($currency) ? $currency->symbol_left : '$'}}
                {{formatMoney($cartProduct->product->discount->price ?? $cartProduct->product->price)}} {{isset($currency) ? $currency->symbol_right : ''}}
              </p>
              
              <!-- boton para eliminar-->
              <div style="width: 20px;  position: absolute; right: -7px; top: 0;">
                <a class="close cart-remove text-danger" style="font-size: 1rem;"
                   wire:click="deleteFromCart({{$cartProduct->id}})"
                   title="quitar producto">
                  <i class="fa fa-times"></i>
                </a>
              </div>
            </div>
          
          
          </div>
        @endforeach
      @endif
    
    <!-- FOOTER CARTING -->
      @if($cart->products->count())
        <div class="dropdown-footer text-center">
          <hr class="mt-1 mb-3">
          <!-- total -->
          <h6 class="font-weight-bold">
            {{trans('icommerce::cart.table.total')}}
            <span class="text-primary">
         {{isset($currency) ? $currency->symbol_left : '$'}} {{ formatMoney( $cart->total )}} {{isset($currency) ? $currency->symbol_right : ''}}
  </span>
          </h6>
          <!-- botones-->
          <a href="{{ \URL::route(\LaravelLocalization::getCurrentLocale() . '.icommerce.store.checkout') }}" tabindex="-1" class="btn btn-warning btn-sm mx-1 text-white">
            {{trans('icommerce::cart.button.view_cart')}}
          </a>
        
        
        </div>
      @endif
    </div>
  
  
  </div>
</div>
