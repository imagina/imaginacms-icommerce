@auth
  @if (!$shopAsGuest)
    <div class="card mb-0 border-0"> <!-- Div contenedor usar una dirección de las que ya tiene agregadas. -->
      @if($billingAddress)
            <livewire:iprofile::address-list :addresses="$addresses" :addressSelected="$billingAddress" type="checkoutBilling" emit="billingAddressChanged"/>
      @endif
    </div> <!-- Fin usar una dirección de las q ya posee agregadas. -->
  @endif
@endauth

<div class="card mb-0 border-0">
  @if ($shopAsGuest && setting('icommerce::enableGuestShopping', null, true))
    @if (!$addressGuestBillingCreated)
      <livewire:iprofile::address-form :embedded="true" :route="$locale.'.icommerce.store.checkout'" type="billing"
                                       key="checkoutBillingAddress" :openInModal="false"
                                       livewireEvent="emitCheckoutAddressBilling" :addressGuest="$addressGuest"/>
    @else
      <div id="addressBillingTarget" class="py-3">
        <x-iprofile::address-card-item :address="$addressGuest"  key="cardBilling"/>

        <button id="editBillingAddressButton" class="btn btn-xs btn-primary d-block m-auto" wire:click.prevent="editAddressBillingEmit">
          {{trans('icommerce::checkout.buttons.editAddressButton')}}
        </button>
      </div>
    @endif
  @else
    @auth
      <livewire:iprofile::address-form :embedded="true" :route="$locale.'.icommerce.store.checkout'" type="billing"
                                       key="checkoutBillingAddress" :openInModal="true"/>
    @endauth
  @endif
</div>
