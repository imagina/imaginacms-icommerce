<div class="card card-block p-3 mb-3">
    <div class="row m-0">
        <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-1">
                2
        </div>
        <h3 class="d-flex align-items-center">
            {{ trans('icommerce::billing_details.title') }} 
        </h3>
    </div>

    <hr class="my-2" />
    <a href="#" id="expandBillingDetails">{{ trans('icommerce::billing_details.form.expand_form') }}</a>
    <div class="showBilling">
        <input type="hidden" name="payment_firstname" id="payment_first_name" :value="billingData.first_name">
        <input type="hidden" name="payment_lastname" id="payment_last_name" :value="billingData.last_name">
        <div class="form-group">
            <label for="payment_company">{{ trans('icommerce::billing_details.form.company') }}</label>
            <input type="text" class="form-control" id="payment_company" name="payment_company" aria-describedby="company" v-model="billingData.company">
        </div>
    
        <div class="form-group">
            <label for="payment_address_1">{{ trans('icommerce::billing_details.form.address1') }}</label>
            <input type="text" class="form-control mb-2" id="payment_address_1" name="payment_address_1"  v-model="billingData.address_1">
        </div>
        <div class="form-group">
            <label for="payment_address_2">{{ trans('icommerce::billing_details.form.address2') }}</label>
            <input type="text" class="form-control" id="payment_address_2" name="payment_address_2"  v-model="billingData.address_2">
        </div>
            
        <div class="form-group row">
            <div class="col pr-1">
             <label for="payment_city">{{ trans('icommerce::billing_details.form.city') }}</label>
             <input type="text" class="form-control" name="payment_city" id="payment_city" v-model="billingData.city">

            </div>
            <div class="col pl-1">
             <label for="payment_code">{{ trans('icommerce::billing_details.form.post_code') }}</label>
             <input type="number" class="form-control" name="payment_postcode" id="payment_postcode" v-model="billingData.postcode" @change="shippingMethods()" @keyup="shippingMethods()">
            </div>

        </div>
        <div class="form-group">
            <label for="payment_country">{{ trans('icommerce::billing_details.form.country') }}</label>
            <select 
                class="form-control" 
                id="payment_country" 
                name="payment_country"  
                v-model="billingData.country"
                v-on:change="getCountriesJson(billingData.country, 1)">
                <option value="null">{{ trans('icommerce::billing_details.form.select_option') }}</option>
                <option  v-for="country in countries" v-bind:value="country.iso_2" >@{{ country.name }}</option>
            </select>

        </div>


        <div class="form-group">
            <label for="payment_zone">{{ trans('icommerce::billing_details.form.state') }}</label>
            <select class="form-control" 
                    id="payment_zone" 
                    name="payment_zone"  
                    v-model="billingData.zone"
                    @change="taxFlorida(billingData.zone,1)"
                    v-show="!statesBillingAlternative">
                <option v-for="state in statesBilling" v-bind:value="state.name">@{{ state.name }}</option>
                <option value="null">{{ trans('icommerce::billing_details.form.select_country') }}</option>
            </select>
            <input  type="text" 
                    class="form-control" 
                    name="payment_zone" 
                    id="payment_zone_alternative"
                    v-show="statesBillingAlternative"
                    v-model="billingData.zone"
                     >
        </div> 
    </div>
</div>