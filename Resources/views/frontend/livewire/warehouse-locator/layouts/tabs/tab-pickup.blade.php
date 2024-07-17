<div class="tab-pane fade {{$tabSelected == $shippingMethods['pickup'] ? 'show active' : ''}}" id="pointModalWarehouseLocator" role="tabpanel" aria-labelledby="pointTabModalWarehouseLocator">

    @if(!$chooseOtherWarehouse)

        <div id="warehouseSelected">

        
            <div class="list-address">
                <div class="item-address">
                    <div class="form-check d-flex align-items-center position-static">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" checked>
                        <label class="form-check-label active" for="exampleRadios2">
                            @if(!is_null($warehouse))
                                <p class="mb-0">{{$warehouse->title}} | {{$warehouse->address}}</p>
                            @else
                                <h5>....</h5>
                            @endif
                        </label>
                        <div class="marked"></div>
                    </div>
                </div>
            </div>

           
            <div class="form-row justify-content-center mt-4">
                <div class="form-group col-md-6">
                    <button wire:click="$set('chooseOtherWarehouse', true)" type="button" class="btn outline btn-primary btn-block">
                        {{trans('icommerce::warehouses.button.choosed other warehouse')}}
                    </button>
                </div>
                <div class="form-group col-md-6">
                    @include('icommerce::frontend.livewire.warehouse-locator.layouts.tabs.btn-confirm')
                </div>
            </div>
        
        </div>

    @else

        <div id="otherWarehouse">

            <p class="text-small">
                <strong>{{trans('icommerce::warehouses.title.information')}}:</strong>
                {{trans('icommerce::warehouses.messages.select province and city')}}
            </p>

            <div class="form-point">
                @include('icommerce::frontend.livewire.warehouse-locator.layouts.tabs.pickup.selects-location')
                @include('icommerce::frontend.livewire.warehouse-locator.layouts.tabs.pickup.warehouse-selected')
                @include('icommerce::frontend.livewire.warehouse-locator.layouts.tabs.pickup.warehouses-map')
            </div>

            
            <div class="form-row justify-content-center mt-4">
                <div class="form-group col-md-4">
                    <button wire:click="$set('chooseOtherWarehouse', false)" type="button" class="btn outline btn-primary btn-block">
                        {{trans('icommerce::warehouses.button.back')}}
                    </button>
                </div>
                <div class="form-group col-md-6">
                    @include('icommerce::frontend.livewire.warehouse-locator.layouts.tabs.btn-confirm')
                </div>
            </div>


        </div>
    @endif
    
</div>