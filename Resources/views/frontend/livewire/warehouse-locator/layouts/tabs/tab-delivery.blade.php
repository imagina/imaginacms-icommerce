<div class="tab-pane fade {{$tabSelected== $shippingMethods['delivery'] ? 'show active' : ''}} " 
id="homeModalWarehouseLocator" role="tabpanel" aria-labelledby="homeTabModalWarehouseLocatorab">

    @if(is_null($user))

        @php $reedirectUrl = "/ipanel/#/auth/login/?redirectTo=".url('/'); @endphp
        <a class="cursor-pointer text-primary" onclick="location.href='{{$reedirectUrl}}'">
            {{trans('icommerce::warehouses.messages.not logged')}}
        </a>

    @else

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
            
            <livewire:iprofile::address-list :addresses="$userShippingAddresses" :addressSelected="$shippingAddress" emit="shippingAddressChanged"/>
            
            <div class="form-row justify-content-center mt-4">

                <div class="form-group col-md-6">
                    <button wire:click="$set('showAddressForm', true)" type="button" class="btn btn-primary btn-block">
                        {{trans('icommerce::warehouses.button.add new address')}}
                    </button>
                </div>

                <div class="form-group col-md-6">
                    @include('icommerce::frontend.livewire.warehouse-locator.layouts.tabs.btn-confirm')
                </div>

            </div>

        @endif
   
    @endif
   
</div>