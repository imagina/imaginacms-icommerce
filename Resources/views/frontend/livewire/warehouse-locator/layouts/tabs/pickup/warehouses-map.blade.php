@if(!is_null($warehousesLocation) && count($warehousesLocation)>0) 
    
    <p class="text-small">
        <strong>{{trans('icommerce::warehouses.title.important')}}:</strong> 
        {{trans('icommerce::warehouses.messages.select a point of the map')}}
    </p>

    <x-isite::maps  
        mapId="map_canvas_pickup"
        :usingLivewire="true" 
        :showLocationName="false" 
        :locations="$warehousesLocation"
        :initMultipleLocations="true"
        :activeClickInMarker="true"
        :emitAfterClickMarker="true"
        :activeAnimationInMarker="true" />

@endif
   
@if($showNotWarehouses)
    <div class="alert alert-danger" role="alert">
        {{trans('icommerce::warehouses.messages.not warehouses found for the location')}}
    </div>
@endif