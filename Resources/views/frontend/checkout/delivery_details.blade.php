<div class="card card-block p-3 mb-3">
  <div class="row m-0">
    <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-1">
      3
    </div>
    <h3 class="d-flex align-items-center">
      {{ trans('icommerce::delivery_details.title') }}
    </h3>
  </div>
  
  <hr class="my-2"/>
  
  <div class="form-check">
    
    <label class="form-check-label">
      <input type="checkbox"
             class="form-check-input"
             name="sameDeliveryBilling"
             id="sameDeliveryBilling"
             data-toggle="collapse"
             href="#collapseExample"
             aria-expanded="false"
             aria-controls="collapseExample"
             checked
             v-model="sameDeliveryBilling"
             @change="deliveryBilling()">
      {{ trans('icommerce::delivery_details.same_delivery_billing') }}
    </label>
  </div>
  
  <div class="collapse" id="collapseExample">
    
    <div class="card-block" id="ShippingAddress">
      
      <div class="card mb-0 border-0" v-if="addresses">
        <div class="card-header bg-white" role="tab" id="useExistingShipping">
          <label class="form-check-label">
            <input
              type="radio"
              class="form-check-input"
              name="existingOrNewShippingAddress"
              id="existingShippingAddress"
              value="1"
              data-parent="#ShippingAddress"
              data-toggle="collapse"
              data-target="#collapseExistingShipping"
              aria-expanded="true"
              aria-controls="collapseExistingShipping"
              checked>
            
            {{trans('icommerce::delivery_details.address.old_address')}}
          
          </label>
        </div>
        
        <div id="collapseExistingShipping" class="collapse show" aria-labelledby="useExistingShipping" role="tabpanel">
          <select class="form-control"
                  id=""
                  name="selectShippingAddress"
                  @change="changeAddress(selectedShippingAddress,2)"
                  v-model="selectedShippingAddress"
          >
            <option v-for="(address, index) in selectAddresses" v-bind:value="index" >@{{ address }}</option>
          
          </select>
        </div>
      </div>
      
      <div class="card mb-0 border-0">
        <div class="card-header bg-white" role="tab" id="useNewShipping" v-if="addresses">
          <label class="form-check-label">
            <input
              type="radio"
              class="form-check-input collapsed"
              name="existingOrNewShippingAddress"
              id="newShippingAddress"
              value="2"
              data-parent="#ShippingAddress"
              data-toggle="collapse"
              data-target="#collapseNewShipping"
              aria-expanded="true"
              aria-controls="collapseNewShipping">
  
            {{trans('icommerce::delivery_details.address.new_address')}}
          
          </label>
        </div>
        <div id="collapseNewShipping" :class="addresses ? 'collapse' : 'collapse show'" aria-labelledby="useNewShipping" role="tabpanel">
          
          
          <div class="form-group row">
            <div class="col pr-1">
              <label for="shipping_firstname">{{ trans('icommerce::delivery_details.form.first_name') }} </label>
              <input type="text" class="form-control" id="shipping_first_name" name="shipping_firstname"
                     v-model="shippingData.firstname">
            
            </div>
            <div class="col pl-1">
              <label for="shipping_lastname">{{ trans('icommerce::delivery_details.form.last_name') }}</label>
              <input type="text" class="form-control" id="shipping_last_name" name="shipping_lastname"
                     v-model="shippingData.lastname">
            </div>
          
          </div>
          
          <div class="form-group">
            <label for="shipping_company">{{ trans('icommerce::delivery_details.form.company') }}</label>
            <input type="text" class="form-control" id="shipping_company" name="shipping_company"
                   aria-describedby="companyB" v-model="shippingData.company">
          </div>
          
          <div class="form-group">
            <label for="shipping_address_1">{{ trans('icommerce::delivery_details.form.address1') }}</label>
            <input type="text" class="form-control mb-2" id="shipping_address_1" name="shipping_address_1"
                   v-model="shippingData.address_1">
          </div>
          <div class="form-group">
            <label for="shipping_address_2">{{ trans('icommerce::delivery_details.form.address2') }}</label>
            <input type="text" class="form-control" id="shipping_address_2" name="shipping_address_2"
                   v-model="shippingData.address_2">
          </div>
          
          <div class="form-group row">
            <div class="col pr-1">
              <label for="shipping_city">{{ trans('icommerce::delivery_details.form.city') }}</label>
              <input type="text" class="form-control" name="shipping_city" id="shipping_city"
                     v-model="shippingData.city">
            
            </div>
            <div class="col pl-1">
              <label for="shipping_code">{{ trans('icommerce::delivery_details.form.post_code') }}</label>
              <input type="number" class="form-control" name="shipping_postcode" id="shipping_postcode"
                     v-on:keyup="getShippingMethods()" @change="getShippingMethods()" v-model="shippingData.postcode">
            </div>
          
          </div>
          <div class="form-group">
            <label for="shipping_country">{{ trans('icommerce::delivery_details.form.country') }}</label>
            <select
              class="form-control"
              id="shipping_country"
              name="shipping_country"
              v-model="shippingData.country"
              v-on:change="getProvincesByCountry(shippingData.country, 2)">
              <option value="null">{{ trans('icommerce::delivery_details.form.select_option') }}</option>
              <option v-for="country in countries" v-bind:value="country.iso_2">@{{ country.name }}</option>
            </select>
          
          </div>
          
          
          <div class="form-group">
            <label for="shipping_zone">{{ trans('icommerce::delivery_details.form.state') }}</label>
            <select class="form-control"
                    id="shipping_zone"
                    name="shipping_zone"
                    v-model="shippingData.zone"
                    @change="taxFlorida(shippingData.zone,1)"
                    v-show="!statesShippingAlternative">
                <option v-for="state in statesDelivery" v-bind:value="state.name">@{{ state.name }}</option>
                <option value="null">{{ trans('icommerce::delivery_details.form.select_country') }}</option>
            </select>
            <input type="text"
                   class="form-control"
                   name="shipping_zone"
                   id="shipping_zone_alternative"
                   v-show="statesShippingAlternative"
                   v-model="shippingData.zone">
          </div>
        
        </div>
      </div>
    
    
    </div>
  </div>
</div>