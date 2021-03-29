@auth
  <div class="form-check">
    
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
      
      
      <div class="card mb-0 border-0"> <!-- Div contenedor usar una dirección de las que ya tiene agregadas. -->
        
        @if($shippingAddress)
          
          <div class="form-group">
            <label for="selectShippingAddress">  {{trans('iprofile::addresses.title.myAddresses')}} </label>
            <select
              class="form-control"
              wire:model.lazy="shippingAddressSelected"
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
    
    
    </div>
  </div>
@endauth