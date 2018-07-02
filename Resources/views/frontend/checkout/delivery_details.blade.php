<div class="card card-block p-3 mb-3">
    <div class="row m-0">
        <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-1">
                3
        </div>
        <h3 class="d-flex align-items-center">
            {{ trans('icommerce::delivery_details.title') }} 
        </h3>
    </div>

    <hr class="my-2" />

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
            <div class="card-block">
   
        <div class="form-group row">
            <div class="col pr-1">
             <label for="shipping_firstname">{{ trans('icommerce::delivery_details.form.first_name') }} </label>
             <input type="text" class="form-control" id="shipping_first_name" name="shipping_firstname" v-model="shippingData.first_name">

            </div>
            <div class="col pl-1">
             <label for="shipping_lastname">{{ trans('icommerce::delivery_details.form.last_name') }}</label>
             <input type="text" class="form-control" id="shipping_last_name" name="shipping_lastname" v-model="shippingData.last_name">
            </div>

        </div>

        <div class="form-group">
            <label for="shipping_company">{{ trans('icommerce::delivery_details.form.company') }}</label>
            <input type="text" class="form-control" id="shipping_company" name="shipping_company" aria-describedby="companyB" v-model="shippingData.company">
        </div>
    
        <div class="form-group">
            <label for="shipping_address_1">{{ trans('icommerce::delivery_details.form.address1') }}</label>
            <input type="text" class="form-control mb-2" id="shipping_address_1" name="shipping_address_1" v-model="shippingData.address_1">
        </div>
        <div class="form-group">
            <label for="shipping_address_2">{{ trans('icommerce::delivery_details.form.address2') }}</label>
            <input type="text" class="form-control" id="shipping_address_2" name="shipping_address_2" v-model="shippingData.address_2">
        </div>
            
        <div class="form-group row">
            <div class="col pr-1">
             <label for="shipping_city">{{ trans('icommerce::delivery_details.form.city') }}</label>
             <input type="text" class="form-control" name="shipping_city" id="shipping_city" v-model="shippingData.city">

            </div>
            <div class="col pl-1">
             <label for="shipping_code">{{ trans('icommerce::delivery_details.form.post_code') }}</label>
             <input type="number" class="form-control" name="shipping_postcode" id="shipping_postcode" v-on:keyup="shippingMethods()" @change="shippingMethods()" v-model="shippingData.postcode">
            </div>

        </div>
        <div class="form-group">
            <label for="shipping_country">{{ trans('icommerce::delivery_details.form.country') }}</label>
            <select 
                class="form-control" 
                id="shipping_country" 
                name="shipping_country"
                v-model="shippingData.country"
                v-on:change="getCountriesJson(shippingData.country, 2)">
                <option value="null">Choose option</option>
                <option  v-for="country in countries" v-bind:value="country.iso_2" >@{{ country.name }}</option>
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
                <option value="null">Select country</option>
            </select>
             <input  type="text" 
                class="form-control" 
                name="shipping_zone" 
                id="shipping_zone_alternative"
                v-show="statesShippingAlternative"
                v-model="shippingData.zone">
        </div>
 
      </div>
    </div>
</div>