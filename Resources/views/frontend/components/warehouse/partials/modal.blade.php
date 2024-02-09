@once
<div class="modal fade" id="modalWarehouseLocator" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalWarehouseLocatorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalWarehouseLocatorLabel">
                    <i class="{{$iconModal ?? 'fa-solid fa-map-location'}} mr-2"></i>{{$titleModal ?? '¿Cómo te gustaría recibir tu pedido?'}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="modal-subtitle text-center">
                        {{$subtitleModal ?? 'Elige un método de entrega'}}
                    </div>

                    <!-- WAREHOUSE LOCATOR | LIVEWIRE COMPONENT -->
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
@endonce