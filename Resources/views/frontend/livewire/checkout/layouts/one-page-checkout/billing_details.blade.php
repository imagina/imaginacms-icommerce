<div class="card card-block p-3 mb-3">
  <div class="row m-0 pointer" data-toggle="collapse" href="#PaymentAddress" role="button" aria-expanded="false"
       aria-controls="PaymentAddress">
    <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-2">
      2
    </div>
    <h3 class="d-flex align-items-center my-1 h5">
      {{ trans('icommerce::billing_details.title') }}
    </h3>
  
    @if($errors->has('billingAddress'))
      <br/>
      <span class="alert alert-danger" role="alert">{{ $errors->first('billingAddress') }}</span>
    @endif
  </div>
  
  
  {{--
    <a href="#" id="expandBillingDetails">{{ trans('icommerce::billing_details.form.expand_form') }}</a>
    --}}
  
  <div class="showBilling collapse show" id="PaymentAddress" role="tablist" aria-multiselectable="true">
    <hr class="my-2"/>
    
    @auth
      <div class="card mb-0 border-0"> <!-- Div contenedor usar una dirección de las que ya tiene agregadas. -->
          
          @if($billingAddress)

              <div class="form-group">
                  <label for="selectBillingAddress">  {{trans('iprofile::addresses.title.myAddresses')}} </label>
                  <select
                          class="form-control"
                          wire:model="billingAddressSelected"
                          id="selectBillingAddress">
                      <option value="">Selecciona una dirección</option>

                      @foreach($addresses as $address)
                          <option value="{{$address->id}}">{{$address->first_name}} {{ $address->last_name }}
                              - {{  $address->address_1 }}</option>
                      @endforeach
                  </select>
                  {!! $errors->first("billingAddress", '<span class="help-block">:message</span>') !!}
              </div>

              <x-iprofile::address-card-item :address="$billingAddress" />
          @endif

       
      </div> <!-- Fin usar una dirección de las q ya posee agregadas. -->
    
      <div class="card mb-0 border-0">

          <livewire:iprofile::address-form :embedded="true" :route="$locale.'.icommerce.store.checkout'" type="billing" key="checkoutBillingAddress" :openInModal="true"/>

      </div>
    @endauth
  </div>

</div>
