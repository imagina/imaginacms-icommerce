<div class="card-ckeckout card-shipping-methods mb-3">

  <h4 class="ckeckout-subtitle my-1 font-weight-bold">
    {{ trans('icommerce::shippingmethods.title.shippingmethods') }}
    <div v-if="updatingData">
      &nbsp
      <i class="fa fa-spinner fa-pulse"></i>
    </div>
  </h4>
  <table id="shippingList" class="table my-2">
    <tbody>
    <tr class="shipping-item" v-for="(ship, index) in shippingMethods">
      <td>
        <div class="card-header collapsed bg-white border-bottom pt-2 px-0" role="tab" :id="'shipping-heading'+index">
          <div class="form-check" data-parent="#shippingList" data-toggle="collapse"
               :data-target="'#shipping'+index" aria-expanded="true"
               :aria-controls="'shipping'+index">
            <input class="form-check-input" type="radio" v-model="shipping_name" :value="ship.name">
            <label class="form-check-label" >
              @{{ship.title | capitalize}}
            </label>
          </div>
        </div>
        <div :id="'shipping'+index" class="collapse" role="tabpanel" :aria-labelledby="'shipping'+index">
          <div class="card-block py-2">
            @{{ship.description}}
          </div>
        </div>
      </td>
    </tr>
    </tbody>
  </table>
  <input type="hidden" name="shipping_method" id="shipping_method" :value="shipping_method">
  <input type="hidden" name="shipping_code" id="shipping_code" :value="shipping_method">
  <input type="hidden" name="shipping_amount" id="shipping_amount" :value="shipping_amount">
  <input type="hidden" name="shipping_value" id="shipping_value" value="">
</div>