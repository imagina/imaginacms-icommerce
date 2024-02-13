@if(!is_null($warehouseSelectedFromMap))
    <div class="my-3">
            <div class="text-center font-weight-bold mb-3">Tienda seleccionada:</div>
            <div class="address-selected">
                <span class="text-primary">{{$warehouseSelectedFromMap['title']}}</span>
                <div class="text-small font-weight-bold">{{$warehouseSelectedFromMap['address']}}</div>
                <div class="text-small">{{$warehouseSelectedFromMap['province']}}, {{$warehouseSelectedFromMap['city']}}.</div>
            </div>
    </div>
@endif