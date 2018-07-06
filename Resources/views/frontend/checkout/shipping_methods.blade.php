<div class="card card-block p-3 shippingMethods mb-3">
  <div class="row">
    <div class="col">
      <div class="row m-0">
        <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-1">
          4
        </div>
        <h3 class="d-flex align-items-center">
          {{ trans('icommerce::shipping.title') }}
        </h3>
      
      </div>
      
      
      <table class="table my-2">
        <tbody>
        <tr class="shipping-item" v-for="(ship, index) in shippingMethods">
          <td
            v-if="ship.configName!=='freeshipping' && ship.configName!=='flatrate' && ship.configName!=='localdelivery' && ship.configName!=='icommerceagree' "
            colspan="3">
            
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
                <a class="card-title">
                  @{{ship.configName | capitalize}}
                </a>
              </label>
            </div>
            <div v-if="ship.msj!=='error' && ship.msj!=='freeshipping'" :id="'shipping'+index" class="collapse"
                 role="tabpanel" :aria-labelledby="'shipping'+index">
              <div class="card-block" v-for="item in ship.items">
                <table>
                  <tbody>
                  <tr>
                    <td width="90">
                      <label>
                        <input type="radio" @click="calculate(index,item.price,ship.configName,$event)" class=""
                               v-model="shipping_method" :value="item.configName" id="shipping_method">
                        @{{item.price | twoDecimals}}
                      </label>
                    </td>
                    <td>
                      <label>
                        <div v-html="item.configTitle"></div>
                      
                      </label>
                    </td>
                  </tr>
                  
                  </tbody>
                </table>
              
              </div>
            </div>
            <div v-else>
              <div class="card-block">
                @{{ship.items}}
              </div>
            </div>
          </td>
          <td v-else width="90">
            <label class="w-100">
              <input
                class="w-25 float-left"
                type="radio"
                v-if="ship.deliveryfee"
                @click="calculate(index,ship.deliveryfee,ship.feetype,$event)"
                v-model="shipping_method"
                :value="ship.feetype"
                id="shipping_method">
              <input
                class="w-25 float-left"
                type="radio"
                v-else-if="ship.minimum"
                @click="calculate(index,ship.minimum,ship.configName,$event)"
                v-model="shipping_method"
                :value="ship.configName"
                id="shipping_method">
              <input
                class="w-25 float-left"
                type="radio"
                v-else-if="ship.cost"
                @click="calculate(index,ship.cost,ship.configName,$event)"
                v-model="shipping_method"
                :value="ship.configName"
                id="shipping_method">
              
              <input
                class="w-25 float-left"
                type="radio"
                v-else-if="ship.configName=='icommerceagree'"
                @click="calculate(index,0,ship.configName,$event)"
                v-model="shipping_method"
                :value="ship.configName"
                id="shipping_method">
              
              
              <div class="w-75 float-left delivery" v-if="ship.deliveryfee">@{{ship.deliveryfee | twoDecimals}}</div>
              
              <div class="w-75 float-left minimun" v-else-if="ship.minimum">@{{ship.minimum | twoDecimals}}</div>
              
              <div class="w-75 float-left cost" v-else-if="ship.cost">@{{ship.cost | twoDecimals}}</div>
            
            </label>
          
          </td>
          <td
            v-if="ship.configName!=='icommerceups' && ship.configName!=='icommerceups' && ship.configName!=='notmethods' && ship.configName!=='icommerceagree'">
            <div v-if="ship.minimum">{{ trans('icommerce::shipping.form.minimum') }}</div>
            <div v-else-if="ship.cost">{{ trans('icommerce::shipping.form.fixed') }}</div>
            <div
              v-else-if="ship.feetype && ship.feetype=='fixed_amount'">{{ trans('icommerce::shipping.form.fixed_amount') }}</div>
            <div
              v-else-if="ship.feetype && ship.feetype=='percentage_cart'">{{ trans('icommerce::shipping.form.percentage_cart') }}</div>
            <div
              v-else-if="ship.feetype && ship.feetype=='fixed_amount_product'">{{ trans('icommerce::shipping.form.fixed_amount_prod') }}</div>
          </td>
          <td
            v-if="ship.configName!=='icommerceups' && ship.configName!=='icommerceups' && ship.configName!=='notmethods'">
            @{{ ship.configTitle | capitalize }}
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

