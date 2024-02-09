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
    @auth
      @if (!$shopAsGuest)
        <div class="card mb-0 border-0"> <!-- Div contenedor usar una dirección de las que ya tiene agregadas. -->
          @if($shippingAddress)
                <livewire:iprofile::address-list :addresses="$addresses" :addressSelected="$shippingAddress" type="checkoutShipping" emit="shippingAddressChanged"/>
            @endif
        </div> <!-- Fin usar una dirección de las q ya posee agregadas. -->
      @endif
    @endauth

    <div class="card mb-0 border-0">
      @if ($shopAsGuest)
        @if (!$addressGuestShippingCreated)
          <livewire:iprofile::address-form :embedded="true" :route="$locale.'.icommerce.store.checkout'" type="shipping"
                                           key="checkoutShippingAddress" :openInModal="false"
                                           livewireEvent="emitCheckoutAddressShipping"
                                           :addressGuest="$addressGuestShipping"/>
        @else
          <div id="addressShippingTarget" class="py-3">
            <x-iprofile::address-card-item :address="$addressGuestShipping" key="cardShipping"/>

            <button class="btn btn-xs btn-primary d-block m-auto" wire:click.prevent="editAddressShippingEmit">
              {{trans('icommerce::checkout.buttons.editAddressButton')}}
            </button>
          </div>
        @endif
      @else
        @auth
          <livewire:iprofile::address-form :embedded="true" :route="$locale.'.icommerce.store.checkout'" type="shipping"
                                           key="checkoutShippingAddress" :openInModal="true"/>
        @endauth
      @endif
    </div>
  </div>
</div>