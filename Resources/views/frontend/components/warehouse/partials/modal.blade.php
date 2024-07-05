<div class="modal fade" id="modalWarehouseLocator" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalWarehouseLocatorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalWarehouseLocatorLabel">
                    <i class="{{$iconModal ?? 'fa-solid fa-map-location'}} mr-2"></i>{{$titleModal ?? trans('icommerce::warehouses.modal.choose a shippping method')}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="my-3">
                    
                    @if(!empty($subtitleModal))
                        <div class="modal-subtitle text-center">
                            {{$subtitleModal}}
                        </div>
                    @endif

                    @livewire("icommerce::warehouse-locator", [
                        "layout" => $layoutLocator,
                        "warehouse" => $warehouse,
                        "shippingAddress" => $shippingAddress,
                        "shippingMethods" => $shippingMethods
                    ])


                </div>
            </div>

        </div>
    </div>
</div>

@include('icommerce::frontend.components.warehouse.partials.style-modal')