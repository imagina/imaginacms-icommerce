<div class="information">
  
  <!-- CATEGORY -->
  <div class="category text-uppercase" v-if="product.category">
    @{{product.category.title}}
    {{-- <span v-if="product.categories.lenght" v-for="item in product.categories">/@{{item.title}}</span> --}}
  </div>
  <!-- END CATEGORIES -->
  <!-- TITLE -->
  <h1 class="name">@{{product.name}}</h1>
  <!-- END TITLE -->
  
  <!-- REFERENCE -->
  <div v-if="product.reference" class="reference my-2"><span
      class="ref-label">{{trans("icommerce::products.table.reference")}}</span>: @{{product.reference}}
  </div>
  
  <!-- SUMMARY -->
  <div class="options">@{{product.summary}}</div>
  
  <!-- RATING -->
  @if(is_module_enabled('Rateable') && setting('icommerce::showRatingProduct'))
    @include('icommerce::frontend.partials.show.rating')
  @endif

  <!-- PRICE -->
  @if(!$product->is_call)
    <div class="price " v-if="products_children === false && product.price >0.00">
      <div class="mb-0">
      <span class="text-primary font-weight-bold">
        {{isset($currency->id) ? $currency->symbol_left : '$'}}
        {{formatMoney($product->discount->price ?? $product->price)}}
        {{isset($currency->id) ? $currency->symbol_right : ''}}
      </span>
        @if(isset($product->discount->price))
          <br><span class="price-desc h6 pl-3">{{ trans('icommerce::products.alerts.beforeDiscount') }} <del>{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del></span>
        @endif
      </div>
    </div>
@endif
<!-- END PRICE -->
  <!-- OPCIONES DE PRODUCTO -->
  <select-product-options v-model="productOptionsSelected" v-bind:options="productOptions"></select-product-options>
  
  <div class=" align-items-center mb-4" v-if="product.pdf">
    <a v-bind:href="product.pdf"
       class="btn btn-outline-light text-dark">
      <i class=""> </i>
      {{trans('icommerce::products.messages.product_brochure')}}
    </a>
  </div>
  
  <div v-if="(product.isCall=='0' || canAddIsCallProductsIntoCart) && product.stockStatus" class="add-cart">
    <hr>
    <div class="row">
      <div class="col-12">
        {{$product->quantity}} {{trans("icommerce::products.form.available")}}
      </div>

      <!-- BUTTON QUANTITY -->
      <div class="d-inline-flex align-items-center p-1">
        <div class="input-group ">
          <div class="input-group-prepend">
            <button class="btn btn-outline-light font-weight-bold " field="quantity" type="button"
                    v-on:click="quantity-- ">
              <i class="fa fa-angle-left" aria-hidden="true"></i>
            </button>
          </div>
          <input type="text" class="form-control text-center quantity"
                 name="quantity" v-model="quantity">
          <div class="input-group-append">
            <button class="btn btn-outline-light font-weight-bold" field="quantity" type="button"
                    v-on:click="quantity++">
              <i class="fa fa-angle-right" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="d-inline-flex align-items-center p-1">
        <!-- BUTTON ADD -->
        <div>
          <a v-on:click="addCart(product)" class="btn-comprar btn btn-primary text-white">
            <div class="d-inline-block mr-2">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.83 32.84">
                <g data-name="Capa 2">
                  <g data-name="Capa 1">
                    <path class="cls-1"
                          d="M18.6,4.06a4.74,4.74,0,0,0-8.51-2.12.57.57,0,0,0,.12.78A.56.56,0,0,0,11,2.6,3.62,3.62,0,0,1,17.5,4.22a.55.55,0,0,0,.54.47h.09A.57.57,0,0,0,18.6,4.06Z"/>
                    <path class="cls-1"
                          d="M26.64,10.29,25,7.51a.55.55,0,0,0-.48-.27h-1.6a.55.55,0,0,0-.56.55.56.56,0,0,0,.56.56h1.29l1,1.67H2.65l1-1.67h.58a.56.56,0,0,0,.56-.56.55.55,0,0,0-.56-.55h-.9a.55.55,0,0,0-.48.27L1.19,10.29a.56.56,0,0,0,0,.56.55.55,0,0,0,.48.28H26.16a.55.55,0,0,0,.48-.28A.56.56,0,0,0,26.64,10.29Z"/>
                    <path class="cls-1"
                          d="M23.86,5.16a.53.53,0,0,0-.34-.25L15.93,3.14a.51.51,0,0,0-.42.06.59.59,0,0,0-.25.35L14.69,6a.55.55,0,0,0,.41.66.55.55,0,0,0,.67-.41l.45-1.91,6.5,1.52-1,4.37a.56.56,0,0,0,.42.67l.12,0a.56.56,0,0,0,.54-.43l1.15-4.91A.51.51,0,0,0,23.86,5.16Z"/>
                    <path class="cls-1"
                          d="M14.21,6.47l-.5-4.29a.66.66,0,0,0-.21-.37.57.57,0,0,0-.42-.11L3.78,2.8a.54.54,0,0,0-.49.61l.84,7.16a.56.56,0,0,0,.55.49h.07a.56.56,0,0,0,.49-.61l-.78-6.6,8.2-1L13.1,6.6a.56.56,0,1,0,1.11-.13Z"/>
                    <path class="cls-1"
                          d="M18.61,10.36l-1.1-4.59a.61.61,0,0,0-.26-.35.58.58,0,0,0-.41-.06l-9,2.15a.56.56,0,0,0-.41.68L8,10.48a.56.56,0,0,0,.67.42.57.57,0,0,0,.41-.68L8.67,8.47l7.88-1.9,1,4a.55.55,0,0,0,.54.43.3.3,0,0,0,.13,0A.55.55,0,0,0,18.61,10.36Z"/>
                    <path class="cls-1"
                          d="M26.72,10.55a.56.56,0,0,0-.56-.53H1.67a.54.54,0,0,0-.55.53L0,32.25a.59.59,0,0,0,.15.42.57.57,0,0,0,.41.17H27.27a.57.57,0,0,0,.41-.17.59.59,0,0,0,.15-.42ZM1.14,31.73,2.2,11.13H25.63l1.06,20.6Z"/>
                    <path class="cls-1"
                          d="M18.09,12.25a1.67,1.67,0,1,0,1.67,1.67A1.67,1.67,0,0,0,18.09,12.25Zm0,2.22a.56.56,0,1,1,0-1.11.56.56,0,0,1,0,1.11Z"/>
                    <path class="cls-1"
                          d="M9.74,12.25a1.67,1.67,0,1,0,1.67,1.67A1.67,1.67,0,0,0,9.74,12.25Zm0,2.22a.56.56,0,0,1,0-1.11.56.56,0,1,1,0,1.11Z"/>
                    <path class="cls-1"
                          d="M18.09,13.92H18a.55.55,0,0,0-.55.55.78.78,0,0,0,0,.22v2.84a3.62,3.62,0,1,1-7.23,0V14.47a.56.56,0,0,0-.56-.55.55.55,0,0,0-.55.55v3.06a4.73,4.73,0,1,0,9.45,0V14.47A.55.55,0,0,0,18.09,13.92Z"/>
                  </g>
                </g>
              </svg>
            </div>
            @if(setting("icommerce::canAddIsCallProductsIntoCart") && $product->is_call)
            {{trans('icommerce::cart.button.addToCartForQuote')}}
            @else
              {{trans('icommerce::cart.button.add_to_cart')}}
            @endif
          </a>
          
         
        </div>
      
      </div>
      <div class="d-inline-flex align-items-center p-1">
        <!-- BUTTON WISHLIST -->
        <a
          onClick="window.livewire.emit('addToWishList',{{json_encode(["entityName" => "Modules\\Icommerce\\Entities\\Product", "entityId" => $product->id])}})"
          class="btn btn-wishlist mx-2"
          v-if="!products_children">
          <span>{{ trans('wishlistable::wishlistables.button.addToList') }}</span>
          <i class="fa fa-heart-o ml-1"></i>
        </a>
      </div>
    </div>
    <hr>
  </div>
  <!-- BUTTON CONSULT -->
  <div v-else-if="product.isCall=='1'" class="add-cart">
    <hr>
    <div class="row">
      <div class="col my-2 my-md-0">
        <div>
          <a onClick="window.livewire.emit('makeQuote',{{$product->id}})"
             class=" btn-comprar btn btn-secondary text-white">
            {{setting('icommerce::customIndexContactLabel', null, 'Contáctenos')}}</a>
          <!-- BUTTON WISHLIST -->
          <a
            onClick="window.livewire.emit('addToWishList',{{json_encode(["entityName" => "Modules\\Icommerce\\Entities\\Product", "entityId" => $product->id])}})"
            class="btn btn-wishlist"
            v-if="!products_children">
            <span id="addToTheListSpan">{{trans("wishlistable::wishlistables.button.addToList")}}</span>
            <i class="fa fa-heart-o ml-1"></i>
          </a>
        </div>
      
      </div>
    </div>
    <hr>
  </div>
  <div v-else>
    <p class="label d-inline-block px-3 py-2 mb-0">{{trans("icommerce::products.form.outOfStock")}} </p>
    
    <hr>
  </div>
  
  <!-- Points Product -->
  @include('icommerce::frontend.partials.show.points')

</div>
