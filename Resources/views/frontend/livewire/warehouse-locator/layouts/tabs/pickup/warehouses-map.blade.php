@if(!is_null($warehousesLocation) && count($warehousesLocation)>0) 
    
    <x-isite::maps  
        mapId="map_canvas_pickup"
        :usingLivewire="true" 
        :showLocationName="false" 
        :locations="$warehousesLocation"
        :initMultipleLocations="true"
        :activeClickInMarker="true"
        :emitAfterClickMarker="true" />

@endif
   
@if($showNotWarehouses)
    <div class="alert alert-danger" role="alert">
        No existen bodegas disponibles para la ubicacion seleccionada
    </div>
@endif