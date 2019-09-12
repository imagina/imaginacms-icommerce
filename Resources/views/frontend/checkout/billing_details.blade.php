<div class="card card-block p-3 mb-3">
  <div class="row m-0 pointer" data-toggle="collapse" href="#PaymentAddress" role="button" aria-expanded="false" aria-controls="PaymentAddress">
    <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-1">
      2
    </div>
    <h3 class="d-flex align-items-center my-1">
      {{ trans('icommerce::billing_details.title') }}
    </h3>
  </div>



  {{--
    <a href="#" id="expandBillingDetails">{{ trans('icommerce::billing_details.form.expand_form') }}</a>
    --}}

  <div class="showBilling collapse show" id="PaymentAddress" role="tablist" aria-multiselectable="true">
    <hr class="my-2"/>

    <div class="card mb-0 border-0" v-if="user && user.addresses.length>0"> <!-- Div contenedor usar una dirección de las que ya tiene agregadas. -->
      <div class="card-header bg-white" role="tab" id="useExistingPayment">
        <label class="form-check-label">
          <input
            type="radio"
            class="form-check-input"
            name="existingOrNewPaymentAddress"
            id="existingPaymentAddress"
            value="1"
            data-parent="#PaymentAddress"
            data-toggle="collapse"
            data-target="#collapseExistingPayment"
            aria-expanded="true"
            aria-controls="collapseExistingPayment"
            v-model="useExistingOrNewPaymentAddress"
            checked>

          {{trans('icommerce::billing_details.address.old_address')}}

        </label>
      </div>

      <div id="collapseExistingPayment" :class="useExistingOrNewPaymentAddress==1 ? 'collapse in show' : 'collapse'"  aria-labelledby="useExistingPayment" role="tabpanel">
        <select class="form-control" v-model="selectedBillingAddress" >
          <option value="0">Selecciona una dirección</option>
          <option v-for="(address, index) in user.addresses" :value="address.id">@{{address.first_name ? address.first_name : address.firstName}} @{{address.last_name ? address.last_name : address.lastName}} - @{{ address.address_1 ? address.address_1 : address.address1 }}</option>
        </select>
      </div>

    </div> <!-- Fin usar una dirección de las q ya posee agregadas. -->
    <div class="card mb-0 border-0">
      <div class="card-header bg-white" role="tab" id="useNewPayment" v-if="user && user.addresses">
        <label class="form-check-label">
          <input
            type="radio"
            class="form-check-input collapsed"
            name="existingOrNewPaymentAddress"
            id="newPaymentAddress"
            value="2"
            data-parent="#PaymentAddress"

            v-model="useExistingOrNewPaymentAddress"
          >
          <!-- <input
            type="radio"
            class="form-check-input collapsed"
            name="existingOrNewPaymentAddress"
            id="newPaymentAddress"
            value="2"
            data-parent="#PaymentAddress"
            data-toggle="collapse"
            data-target="#collapseNewPayment"
            aria-expanded="true"
            aria-controls="collapseNewPayment"
            v-model="useExistingOrNewPaymentAddress"
          > -->

          {{trans('icommerce::billing_details.address.new_address')}} <!-- Quiero usar una nueva dirección -->

        </label>
      </div>
      <!-- <div id="collapseNewPayment" :class="user && user.addresses.length>0 && useExistingOrNewPaymentAddress==1 ? 'collapse' : 'collapse show'" aria-labelledby="useNewPayment" role="tabpanel"> -->
      <div id="collapseNewPayment" :class="useExistingOrNewPaymentAddress==1 ? 'collapse' : 'collapse show'" aria-labelledby="useNewPayment" role="tabpanel">

        <div class="form-group row pt-2">
          <div class="col pr-1">
            <label for="payment_firstname">{{ trans('icommerce::billing_details.form.first_name') }} </label>
            <input type="text" class="form-control" id="payment_firstname" name="payment_firstname"
                   v-model="billingData.firstname">

          </div>
          <div class="col pl-1">
            <label for="payment_lastname">{{ trans('icommerce::billing_details.form.last_name') }}</label>
            <input type="text" class="form-control" id="payment_lastname" name="payment_lastname"
                   v-model="billingData.lastname">
          </div>

        </div>

        <div class="form-group">
          <label for="payment_company">{{ trans('icommerce::billing_details.form.company') }}</label>
          <input type="text" class="form-control" id="payment_company" name="payment_company" aria-describedby="company"
                 v-model="billingData.company">
        </div>

        <div class="form-group">
          <label for="payment_address_1">{{ trans('icommerce::billing_details.form.address1') }}</label>
          <input type="text" class="form-control mb-2" id="payment_address_1" name="payment_address_1"
                 v-model="billingData.address_1">
        </div>
        <div class="form-group">
          <label for="payment_address_2">{{ trans('icommerce::billing_details.form.address2') }}</label>
          <input type="text" class="form-control" id="payment_address_2" name="payment_address_2"
                 v-model="billingData.address_2">
        </div>

        <div class="form-group">

          <label for="payment_country">{{ trans('icommerce::billing_details.form.country') }}</label>
          <select class="form-control" v-model="billingData.countryIndex" @blur="getProvincesByCountry(1)">
            <option value="null">{{ trans('icommerce::billing_details.form.select_country') }}</option>
            <option v-for="(country,index) in countries" v-bind:value="index">@{{ country.name }}</option>
          </select>

        </div>


        <div class="form-group">

          <label for="payment_zone">{{ trans('icommerce::billing_details.form.state') }}</label>
          <select class="form-control" v-model="billingData.zoneIndex" >
            <option value="null">{{ trans('icommerce::billing_details.form.select_option') }}</option>
            <option v-for="(state,index) in statesBilling" :value="index">@{{ state.name }}</option>
          </select>

        </div>

        <div class="form-group row">
          <div class="col pr-1">
            <label for="payment_city">{{ trans('icommerce::billing_details.form.city') }}</label>
{{--            <select class="form-control" v-model="billingData.cityIndex">
              <option value="null">{{ trans('icommerce::billing_details.form.select_option') }}</option>
              <option v-for="(city,index) in cities" v-bind:value="index">@{{ city.name }}</option>
            </select>--}}
            <input type="text"
                   class="form-control"
                   v-model="billingData.city">
          </div>
          <div class="col pl-1">
            <label for="payment_code">{{ trans('icommerce::billing_details.form.post_code') }}</label>
            <input type="number"
                   class="form-control"
                   name="payment_postcode"
                   id="payment_postcode"
                   v-model="billingData.postcode">
          </div>

        </div>

        <div class="form-group text-center">
          <button type="button" class="btn btn-primary" @click="addAddress('billing')" name="button">Agregar dirrección</button>
        </div>

      </div>
    </div>

  </div>

</div>
