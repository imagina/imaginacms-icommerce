<div class="my-3">
    {{-- Importante: dejar este div antes xq sino se bugueaba un poco el mapa con las animaciones --}}
    @if(!is_null($warehouseSelectedFromMap))
        <div class="text-center font-weight-bold mb-3">{{trans('icommerce::warehouses.title.warehouse selected')}}:</div>
        <div class="address-selected">
            <span class="text-primary">{{$warehouseSelectedFromMap['title']}}</span>
            <div class="text-small font-weight-bold">{{$warehouseSelectedFromMap['address']}}</div>
            <div class="text-small">{{$warehouseSelectedFromMap['province']}}, {{$warehouseSelectedFromMap['city']}}.</div> 
        </div>
    @endif
</div>