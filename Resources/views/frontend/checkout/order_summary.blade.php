<div class="card card-block order p-3 mb-3">
  <div class="row">
    <div class="col">
      <div class="row m-0">
        <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-2 py-1">
          <i class="fa fa-check px-1"></i>
        </div>
        <h3 class="d-flex align-items-center">
          {{ trans('icommerce::order_summary.title') }}
        </h3>
      </div>
      
      <hr class="my-2"/>
      
      <div class="row">
        
        <div class="col">
          <h5 class="dropdown-header mb-0">
            @{{ quantity }}
            <span v-if="quantity>1">{{ trans('icommerce::order_summary.items_car') }}</span>
            <span v-else>{{ trans('icommerce::order_summary.item_car') }}</span>
          </h5>
          <hr class="mt-0 mb-3"/>
          <div class="box-items-cart">
            <div class="row item_carting px-3 w-100 m-0" v-for="item in items">
              <div class="col-3 pr-0 pb-2">
                <a v-if="item.mainimage != null" v-bind:href="item.slug" class="cart-img float-left">
                  <img v-if="item.mainimage != null" class="img-fluid" v-bind:src="item.mainimage"
                       v-bind:alt="item.name">
                  <img v-else class="img-fluid"
                       src="{{url('modules/icommerce/img/product/default.jpg')}}"
                       v-bind:alt="item.name">
                </a>
              </div>
              <div class="col-9">
                <a class="close cart-remove text-primary float-right" v-on:click="deleteItem(item)"> <i
                    class="fa fa-times"></i> </a>
                <h5 class="mb-0">
                  @{{ item.name }}
                </h5>
                <p class="mb-0">

                  @{{ item.price | numberFormat }}

                  @{{ '/ x '+item.quantity }}
                </p>
                <div class="col-7 p-0 mb-2">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <input type="button" value="-"
                             class="btn btn-outline-primary border-right-0 quantity-down"
                             field="quantity"
                             v-on:click="item.quantity > 0 ? update_quantity(item, '-') : alerta('the quantity can not be less than 0', 'error')">
                    </div>
                    <input type="text"
                           name="quantity"
                           v-model="item.quantity"
                           class="quantity form-control border-primary"
                           v-on:change="update_cart(item)">
                    <div class="input-group-append">
                      <input type="button" value="+"
                             class="btn btn-outline-primary border-left-0 quantity-up"
                             field="quantity"
                             v-on:click="update_quantity(item, '+')">
                    </div>
                  </div>
                </div>
                <span v-show="item.freeshipping==1 && isFreeshippingCountry()" class="badge badge-success text-white">{{trans('icommerce::order_summary.freeshipping')}}
                            </span>
              </div>
              <hr class="mt-0 mb-3 w-100">
            </div>
          </div>
          <hr class="mt-1 mb-2"/>
          <div class="dropdown-footer">
            <div class="row">
              <div class="col-4">
                <p>
                <div>{{ trans('icommerce::order_summary.car_sub') }}</div>
                </p>
              </div>
              <div class="col-8 text-right">
                <p>
                <div v-if="!updatingData">

                  @{{ subTotal | numberFormat }}

                </div>
                <div v-else>
                  <i class="fa fa-spinner fa-pulse"></i>
                </div>
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <p>
                <div>{{ trans('icommerce::order_summary.shipping') }}</div>
                </p>
              </div>
              <div class="col-8 text-right">
                <p>
                <div v-if="!updatingData">
                  <div v-if="! shipping_method">
                    {{ trans('icommerce::order_summary.shipping_not_selected')}}
                  
                  </div>
                  <div v-else>
                    @{{shipping_method }}
                    <br>
                    @{{ shipping!=0 ? shipping : '' | numberFormat }}
   
                  </div>
                </div>
                <div v-else>
                  <i class="fa fa-spinner fa-pulse"></i>
                </div>
                </p>
              </div>
            </div>
            <div v-show="tax" class="row">
              <div class="col-4">
                <p>
                <div>{{ trans('icommerce::order_summary.tax') }}</div>
                </p>
              </div>
              <div class="col-8 text-right">
                <p>
                <div v-if="!updatingData">

                  @{{ taxTotal | numberFormat }}
   
                </div>
                <div v-else>
                  <i class="fa fa-spinner fa-pulse"></i>
                </div>
                </p>
              </div>
            
            </div>
            <input type="hidden" name="tax_amount" v-model="taxTotal">
          </div>
          
          <hr class="mt-0 mb-1"/>
          <div class="dropdown-footer">
            <div class="row">
              <div class="col-4">
                <h5 class="font-weight-bold">
                  <div>{{ trans('icommerce::order_summary.total') }}</div>
                </h5>
              </div>
              <div class="col-8">
                <h5 class="font-weight-bold text-right" v-if="!updatingData">

                  @{{ orderTotal | numberFormat }}
       
                </h5>
                <h5 v-else>
                  <i class="fa fa-spinner fa-pulse"></i>
                </h5>
                <input type="hidden" name="total" id="total" :value="orderTotal">
              </div>
            </div>
          </div>
        </div>
      
      </div>
      
      <button type="button" class="btn btn-warning btn-lg w-100 mt-3 placeOrder" @click="submitOrder($event)"
              :disabled="placeOrderButton || updatingData">
        <div v-if="quantity>0" v-show="!placeOrderButton && !updatingData">
          {{ trans('icommerce::order_summary.submit') }}
        </div>
        <div class="fa-1x" v-show="placeOrderButton">
          <i class="fa fa-spinner fa-pulse"></i> {{ trans('icommerce::order_summary.sending') }}
        </div>
        <div class="fa-1x" v-show="updatingData">
          <i class="fa fa-spinner fa-pulse"></i>
        </div>
      </button>
    </div>
  </div>
</div>