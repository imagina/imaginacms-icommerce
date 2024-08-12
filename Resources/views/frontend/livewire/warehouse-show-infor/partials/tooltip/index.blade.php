<div id="{{$warehouseLocatorId}}Tooltip">
    <div class="warehouse-tooltip-screen"></div>
    <div class="warehouse-tooltip-container">
        <div class="warehouse-tooltip-body">
            <div class="warehouse-tooltip-close" wire:click="processTooltip('close')">×</div>
            <div class="warehouse-tooltip-body-title">
                {{trans('icommerce::warehouses.messages.you are going to buy for')}}
                {{$warehouse->address}}
            </div>
            <div class="warehouse-tooltip-body-description">
                {{trans('icommerce::warehouses.messages.products for this location')}}
            </div>

            <div class="row justify-content-center mt-4">
                <div class="col-sm-6 pb-3 pb-sm-0">
                    <button type="button" wire:click="processTooltip('keep')" class="btn btn-outline-primary btn-block">{{trans('icommerce::warehouses.button.keep')}}</button>
                </div>
                <div class="col-sm-6">

                    <button type="button"  wire:click="processTooltip('change')" data-toggle="modal" data-target="#modalWarehouseLocator" class="btn btn-primary btn-block">
                        {{trans('icommerce::warehouses.button.change')}}
                    </button>

                </div>
            </div>
        </div>
    </div>

@include('icommerce::frontend.livewire.warehouse-show-infor.partials.tooltip.style')

</div>