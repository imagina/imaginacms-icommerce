<div class="tab-pane fade {{$tabSelected== $shippingMethods['delivery'] ? 'show active' : ''}} " 
id="homeModalWarehouseLocator" role="tabpanel" aria-labelledby="homeTabModalWarehouseLocatorab">

    @if(count($userShippingAddresses)==0 || $showAddressForm)

        <livewire:iprofile::address-form 
            :embedded="true" 
            type="shipping"  
            key="checkoutShippingAddress" 
            :openInModal="false" 
            :insideModal="true"
            :showCancelBtn="true"
            :userAddresses="$userShippingAddresses"/>
    @else
        
        <h5>Falta Implementacion de:</h5>
        <ul>
            <li>Componente Address Card Item FALTA EL SELECT @Juan</li>
            <li>Una vez se tenga lo del select, faltan los procesos de verificacion de warehouse para la direccion seleccionada</li>
        </ul>

        {{--
        <x-iprofile::addressCardItem :address="$shippingAddress"/>
        --}}

        <livewire:iprofile::address-list :addresses="$userShippingAddresses" :addressSelected="$shippingAddress" emit="shippingAddressChanged"/>

        {{-- BTN NEW ADDRESS --}}
        <div class="form-row justify-content-center mt-4">

            <div class="form-group col-md-6">
                <button wire:click="$set('showAddressForm', true)" type="button" class="btn btn-primary btn-block">Agregar nueva dirección</button>
            </div>

            <div class="form-group col-md-6">
                @include('icommerce::frontend.livewire.warehouse-locator.layouts.tabs.btn-confirm')
            </div>

        </div>

    @endif
   
   
</div>