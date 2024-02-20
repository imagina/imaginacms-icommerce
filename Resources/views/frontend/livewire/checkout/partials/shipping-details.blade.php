@if (!setting('icommerce::warehouseFunctionality', null, false))
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
@endif

<div class="@if ($sameShippingAndBillingAddresses) collapse @else collapse-show @endif" id="collapseExample">
  <div class="card-block" id="ShippingAddress">
    @auth
      @if (!$shopAsGuest)
        <div class="card mb-0 border-0"> <!-- Div contenedor usar una dirección de las que ya tiene agregadas. -->
          @if (!setting('icommerce::warehouseFunctionality', null, false))
            @if($shippingAddress)
              <livewire:iprofile::address-list :addresses="$addresses" :addressSelected="$shippingAddress"
                                               type="checkoutShipping" emit="shippingAddressChanged"/>
            @endif
          @else
            <x-iprofile::address-card-item :address="$shippingAddress"/>
          @endif
        </div> <!-- Fin usar una dirección de las q ya posee agregadas. -->
      @endif
    @endauth

    <div class="card mb-0 border-0">
      @if ($shopAsGuest && setting('icommerce::enableGuestShopping', null, true))
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
        @if (!setting('icommerce::warehouseFunctionality', null, false))
          @auth
            <livewire:iprofile::address-form :embedded="true" :route="$locale.'.icommerce.store.checkout'"
                                             type="shipping"
                                             key="checkoutShippingAddress" :openInModal="true"/>
          @endauth
        @else
          <div class="col py-2">
            <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#modalWarehouseLocator">
              {{trans('icommerce::common.pages.buttonChangeShippingAddressWarehouse')}}
            </a>
          </div>
        @endif
      @endif
    </div>
  </div>
</div>