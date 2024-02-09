<div class="tab-pane fade {{$tabSelected == $shippingMethods['pickup'] ? 'show active' : ''}}" id="pointModalWarehouseLocator" role="tabpanel" aria-labelledby="pointTabModalWarehouseLocator">

    @if(!$chooseOtherWarehouse)

        <div id="warehouseSelected">

        
            <div class="list-address">
                <div class="item-address">
                    <div class="form-check d-flex align-items-center position-static">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" checked>
                        <label class="form-check-label active" for="exampleRadios2">
                            <p class="mb-0">{{$warehouse->title}} | {{$warehouse->address}}</p>
                        </label>
                        <div class="marked"></div>
                    </div>
                </div>
            </div>

            <!-- End Listado de tiendas marcadas -->
            <div class="form-row justify-content-center mt-4">
                <div class="form-group col-md-6">
                    <button wire:click="$set('chooseOtherWarehouse', true)" type="button" class="btn outline btn-primary btn-block">Escoger otra Tienda</button>
                </div>
                <div class="form-group col-md-6">
                    @include('icommerce::frontend.livewire.warehouse-locator.layouts.tabs.btn-confirm')
                </div>
            </div>
        
        </div>

    @else

        <div id="otherWarehouse">

            <p class="text-small">
                <strong>Importante:</strong> 
                Seleccione el punto en el mapa con el puntero rojo después de clic en Confirmar. Solo se mostrarán los productos para la tienda seleccionada.
            </p>


            <div class="form-point">

                <h5>Falta Implementacion de:</h5>
                <ul>
                    <li>Selectores de Locations</li>
                    <li>Mapa con Warehouses</li>
                    <li>Seleccion de Marcador</li>
                    <li>Mostrar informacion de Marcador en la parte superior</li>
                </ul>
                

            </div>

            
            <div class="form-row justify-content-center mt-4">
                <div class="form-group col-md-4">
                    <button wire:click="$set('chooseOtherWarehouse', false)" type="button" class="btn outline btn-primary btn-block">Volver</button>
                </div>
                <div class="form-group col-md-6">
                    @include('icommerce::frontend.livewire.warehouse-locator.layouts.tabs.btn-confirm')
                </div>
            </div>


        </div>
    @endif
    

</div>