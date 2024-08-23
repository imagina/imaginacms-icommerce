<div class="warehouse-layout-tabs">

@if($showComponent)

    <ul class="nav nav-tabs nav-justified" id="myTabModalWarehouseLocator" role="tablist">
        <li class="nav-item" role="presentation" >
            <a class="nav-link {{$tabSelected == $shippingMethods['delivery'] ? 'active' : ''}}" 
            id="homeTabModalWarehouseLocator" data-toggle="tab" href="#homeModalWarehouseLocator" role="tab" aria-controls="homeModalWarehouseLocator" aria-selected="true"
            wire:click="changeTabSelected('{{$shippingMethods['delivery']}}')">
               {{trans('icommerce::warehouses.tabs.delivery')}}
            </a>
        </li>
        <li class="nav-item" role="presentation" >
            <a class="nav-link {{$tabSelected == $shippingMethods['pickup'] ? 'active' : ''}}" id="pointTabModalWarehouseLocator" data-toggle="tab" href="#pointModalWarehouseLocator" role="tab" aria-controls="pointModalWarehouseLocator" aria-selected="false"
            wire:click="changeTabSelected('{{$shippingMethods['pickup']}}')">
                {{trans('icommerce::warehouses.tabs.pickup')}}
            </a>
        </li>
    </ul>
    
    <div class="tab-content mt-4" id="myTabContentmyTabModalWarehouseLocator">
        @include('icommerce::frontend.livewire.warehouse-locator.layouts.tabs.tab-delivery')
        @include('icommerce::frontend.livewire.warehouse-locator.layouts.tabs.tab-pickup')     
    </div>

@else
    <span>cargando... </span>
@endif

</div>                