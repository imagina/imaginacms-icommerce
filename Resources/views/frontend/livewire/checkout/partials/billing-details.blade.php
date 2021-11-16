@auth
  <div class="card mb-0 border-0"> <!-- Div contenedor usar una dirección de las que ya tiene agregadas. -->
    
    @if($billingAddress)
      
      <div class="form-group">
        <label for="selectBillingAddress">  {{trans('iprofile::addresses.title.myAddresses')}} </label>
        <select
          class="form-control"
          wire:model.lazy="billingAddressSelected"
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