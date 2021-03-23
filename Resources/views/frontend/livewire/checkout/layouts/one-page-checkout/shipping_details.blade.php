<div class="card card-block p-3 mb-3">
  <div class="row m-0">
    <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-2">
      {{$step}}
    </div>
    <h3 class="d-flex align-items-center h5">
      {{ trans('icommerce::delivery_details.title') }}
    </h3>
  </div>
  
  <hr class="my-2"/>
  
  <div class="form-check" v-if="user && user.addresses">
    
    <label class="form-check-label">
      <input type="checkbox"
             class="form-check-input"
             name="sameShippingAndBillingAddresses"
             id="sameShippingAndBillingAddresses"
             data-toggle="collapse"
             href="#collapseExample"
             aria-expanded="false"
             aria-controls="collapseExample"
             checked
             wire:model="sameShippingAndBillingAddresses">
      {{ trans('icommerce::delivery_details.same_delivery_billing') }}
    </label>
  </div>
  
  <div wire:ignore.self class="collapse" id="collapseExample">
    
    <div class="card-block" id="ShippingAddress">

      @auth
        <div class="card mb-0 border-0"> <!-- Div contenedor usar una dirección de las que ya tiene agregadas. -->

          @if($shippingAddress)

            <div class="form-group">
              <label for="selectShippingAddress">  {{trans('iprofile::addresses.title.myAddresses')}} </label>
              <select
                      class="form-control"
                      wire:model="shippingAddressSelected"
                      id="selectShippingAddress">
                <option value="">Selecciona una dirección</option>

                @foreach($addresses as $address)
                  <option value="{{$address->id}}">{{$address->first_name}} {{ $address->last_name }}
                    - {{  $address->address_1 }}</option>
                @endforeach
              </select>
            </div>
                <x-iprofile::address-card-item :address="$shippingAddress" />
          @endif

        </div> <!-- Fin usar una dirección de las q ya posee agregadas. -->

        <div class="card mb-0 border-0">
          <livewire:iprofile::address-form :embedded="true" :route="$locale.'.icommerce.store.checkout'" type="shipping" key="checkoutShippingAddress" :openInModal="true"/>
        </div>
      @endauth

    </div>
  </div>
</div>
