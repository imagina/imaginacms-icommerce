<div class="card card-block p-3 shippingMethods mb-3">
  <div class="row">
    <div class="col">
      <div class="row m-0">
        <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-1">
          4
        </div>
        <h3 class="d-flex align-items-center">
          {{ trans('icommerce::shippingmethods.title.shippingmethods') }}
          <div v-if="updatingData">
            &nbsp;
            <i class="fa fa-spinner fa-pulse"></i>
          </div>
        </h3>

      </div>

      <table class="table my-2">
        <tbody>
          <tr class="shipping-item" v-for="(ship, index) in shippingMethods">
            <td >
              <div
              class="card-header collapsed bg-white border-0"
              role="tab"
              id="headingOne"
              :href="'shipping'+index"
              data-parent="#shippingList"
              data-toggle="collapse"
              :data-target="'#shipping'+index"
              aria-expanded="true"
              :aria-controls="'shipping'+index">
              <label class="mb-0">
                <input type="radio" class=""
                v-model="shipping_name" :value="ship.name">
                <a class="card-title">
                  @{{ship.title | capitalize}}
                </a>
              </label>
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
</div>
</div>
