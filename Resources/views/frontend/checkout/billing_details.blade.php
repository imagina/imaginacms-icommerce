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
    
    <div class="card mb-0 border-0" v-if="user && user.addresses"> <!-- Div contenedor usar una dirección de las que ya tiene agregadas. -->
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
      
      <div id="collapseExistingPayment" :class="useExistingOrNewPaymentAddress==1 ? 'collapse in show' : 'collapse'"  aria-labelledby="useExistingPayment" role="tabpanel" >
        
        <div class="form-group" >
          <select
            :class="'form-control '+ ($v.form.selectedBillingAddress.$error ? 'is-invalid' : '')"
            v-model="form.selectedBillingAddress"
            id="selectBillingAddress">
            <option value="">Selecciona una dirección</option>
            <option v-for="(address, index) in user.addresses" :value="address.id">@{{address.first_name ? address.first_name : address.firstName}} @{{address.last_name ? address.last_name : address.lastName}} - @{{ address.address_1 ? address.address_1 : address.address1 }}</option>
          </select>
        </div>
        
        <div id="billingAddressResume" class="card p-2" v-if="billingAddress" style="font-size: 12px">
          <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.name")}}:</b> @{{billingAddress.firstName}} @{{ billingAddress.lastName }}</p>
          <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.phone")}}:</b> @{{billingAddress.telephone}}</p>
          <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.address")}}:</b> @{{billingAddress.address1}} @{{ billingAddress.address2 ?  ", "+billingAddress.address2 : ""}}</p>
          <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.city")}}:</b> @{{billingAddress.city}}</p>
          <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.state")}}:</b> @{{billingAddress.state}}</p>
          <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.country")}}:</b> @{{billingAddress.country}}</p>
          
          @php
            $addressesExtraFields = is_array(setting('iprofile::userAddressesExtraFields')) ? setting('iprofile::userAddressesExtraFields') : is_array(json_decode(setting('iprofile::userAddressesExtraFields'))) ? json_decode(setting('iprofile::userAddressesExtraFields')) : json_decode(json_encode(setting('iprofile::userAddressesExtraFields')));
          @endphp
          @foreach($addressesExtraFields as $extraField)
            @if($extraField->active)
              <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.$extraField->field")}}:</b> @{{billingAddress[@php echo $extraField->field; @endphp ] || '-'}}</p>
            
            @endif
          @endforeach
          
          <p class="card-text m-0" v-if="billingAddress.default">
            {{trans("iprofile::addresses.form.default")}}
            <span v-if="billingAddress.type == 'billing'">({{trans("iprofile::addresses.form.billing")}})</span>
            <span v-if="billingAddress.type == 'shipping'">({{trans("iprofile::addresses.form.shipping")}})</span>
          </p>
        </div>
      
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
            <input :class="'form-control '+ ($v.billingData.firstname.$error ? 'is-invalid' : '')" type="text" id="paymentFirstname" name="payment_firstname"
                   v-model="billingData.firstname">
          
          </div>
          <div class="col pl-1">
            <label for="payment_lastname">{{ trans('icommerce::billing_details.form.last_name') }}</label>
            <input :class="'form-control '+ ($v.billingData.lastname.$error ? 'is-invalid' : '')" type="text" id="paymentLastname" name="payment_lastname"
                   v-model="billingData.lastname">
          </div>
        
        </div>
        
        <div class="form-group">
          <label for="payment_address_1">{{ trans('icommerce::billing_details.form.address1') }}</label>
          <input :class="'form-control '+ ($v.billingData.address_1.$error ? 'is-invalid' : '')" type="text" id="paymentAddress1" name="payment_address_1"
                 v-model="billingData.address_1">
        </div>
        <div class="form-group">
          <label for="payment_telephone">{{ trans('icommerce::billing_details.form.telephone') }}</label>
          <input type="text" :class="'form-control '+ ($v.billingData.telephone.$error ? 'is-invalid' : '')" id="paymentTelephone" name="payment_telephone"
                 v-model="billingData.telephone">
        </div>
        
        <div class="form-group">
          <label for="payment_country">{{ trans('icommerce::billing_details.form.country') }}</label>
          <select id="paymentCountry"
                  :class="'form-control '+ ($v.billingData.countryIndex.$error ? 'is-invalid' : '')"
                  v-model="billingData.countryIndex"
                  @change="getProvincesByCountry(billingData.countryIndex,1)">
            <option value="null">{{ trans('icommerce::billing_details.form.select_country') }}</option>
            <option v-for="(country,index) in countries" :value="country.iso_2">@{{ country.name }}</option>
          </select>
        
        </div>
        
        
        <div class="form-group">
          
          <label for="payment_zone">{{ trans('icommerce::billing_details.form.state') }}</label>
          <select id="paymentState"
                  :class="'form-control '+ ($v.billingData.zoneIndex.$error ? 'is-invalid' : '')"
                  v-model="billingData.zoneIndex" >
            <option value="null">{{ trans('icommerce::billing_details.form.select_option') }}</option>
            <option v-for="(state,index) in statesBilling" :value="state.iso_2">@{{ state.name }}</option>
          </select>
        
        </div>
        
        <div class="form-group ">
          <label for="payment_city">{{ trans('icommerce::billing_details.form.city') }}</label>
          <input id="paymentCity"
                 type="text"
                 :class="'form-control '+ ($v.billingData.city.$error ? 'is-invalid' : '')"
                 v-model="billingData.city">
        </div>
        
        
        <!--17-09-2020::JCEC - primera version del address extra fields
                                      toca irlo mejorando-->
        @php
          $registerExtraFields = is_array(setting('iprofile::registerExtraFields')) ? setting('iprofile::registerExtraFields') : is_array(json_decode(setting('iprofile::registerExtraFields'))) ? json_decode(setting('iprofile::registerExtraFields')) : json_decode(json_encode(setting('iprofile::registerExtraFields')));
        @endphp
        @foreach($addressesExtraFields as $extraField)
          @if($extraField->active)
            <div class="form-group ">
              <label for="{{$extraField->field}}">{{trans("iprofile::frontend.form.$extraField->field")}}</label>
              <input id="billing{{$extraField->field}}"
                     type="text"
                     class="form-control"
                     v-model="billingData.options.{{$extraField->field}}">
            
            </div>
          @endif
        @endforeach
        
        <div class="form-check" >
          
          <label class="form-check-label">
            <input type="checkbox"
            
                   v-model="billingData.default">
            {{ trans('iprofile::frontend.form.defaultBilling') }}
          </label>
        </div>
        
        <div class="form-group text-center">
          
          <button type="button" class="btn btn-primary" @click="addAddress('billing')" name="button">Agregar dirección</button>
        </div>
      
      </div>
    </div>
  
  </div>

</div>
