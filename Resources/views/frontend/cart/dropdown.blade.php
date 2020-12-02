<!--Dropdown cart-->
<div class="cart-dropdown-menu" aria-labelledby="dropdownCart" style="z-index: 99999;">
    <!--Shopping cart dropdown -->
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownCart"
         style="  min-width: 20rem; z-index: 9999999">
      <!-- titulo -->
      <h4 class="dropdown-header mb-0 font-weight-bold text-center" v-if="articles.length>0">
        {{trans('icommerce::cart.articles.cart')}} (@{{articles.length}})
        <i class="fa fa-trash text-muted float-right" title="Vaciar carrito" v-on:click="clear_cart()"></i>
      </h4>
      <h5 class="dropdown-header mb-0 font-weight-bold text-center" v-else>
        {{trans('icommerce::cart.articles.empty_cart')}}
      </h5>

      <!-- articulos en el carrito -->
      <div class="item_carting px-3 w-100 row m-0" v-for="(item,indexArt) in articles.slice(0, 4)"
           v-if="articles.length>0">
        <hr class="mt-0 mb-3 w-100">

        <!-- imagen -->
        <div class="col-3 px-0 mb-3">
          <div style="height: 80px; width: 100%;background-size: contain;  background-repeat: no-repeat;  background-position: center;"
               class="img_product_carting mr-3 border"
               v-bind:style="{ backgroundImage: 'url('+item.mainImage.path+')'}" v-on:click="location(item.url)"
               style="cursor: pointer;">
          </div>
        </div>
        <!-- descripción -->
        <div class="col-9">

          <!-- titulo -->
          <h6 class="mb-2 w-100 __title">
            <a v-bind:href="item.url">
              @{{ item.name }} <label v-if="item.productOptionValues.length>0">(@{{(item.productOptionValues[0].optionValue)}})</label>
            </a>
          </h6>
          <!-- valor y cantidad -->
          <p class="mb-0 text-muted pb-2" style="font-size: 13px">
            {{trans('icommerce::cart.table.quantity')}}: @{{ item.quantity }} <br>
            {{trans('icommerce::cart.table.price_per_unit')}}: @{{ currencySymbolLeft + ''}} @{{item.priceUnit | numberFormat}} @{{'' +currencySymbolRight }}
          </p>

          <!-- boton para eliminar-->
          <div style="width: 20px;  position: absolute; right: -7px; top: 0;">
            <a class="close cart-remove text-danger cursor-pointer" style="font-size: 1rem;" v-on:click="delete_item(item.id)" title="quitar producto">
              <i class="fa fa-times"></i>
            </a>
          </div>
        </div>


      </div>

      <!-- FOOTER CARTING -->
      <div class="dropdown-footer text-center" v-if="articles">
        <hr class="mt-1 mb-3">
        <!-- total -->
        <h6 class="font-weight-bold">
          {{trans('icommerce::cart.table.total')}}
          <span class="text-primary">
         @{{ currencySymbolLeft + ''}} @{{total | numberFormat}} @{{'' +currencySymbolRight }}
          </span>
        </h6>
        <!-- botones-->
        <a href="{{ url('checkout') }}" tabindex="-1" class="btn btn-warning btn-sm mx-1 text-white">
          {{trans('icommerce::cart.button.view_cart')}}
        </a>


      </div>

    </div>




</div>