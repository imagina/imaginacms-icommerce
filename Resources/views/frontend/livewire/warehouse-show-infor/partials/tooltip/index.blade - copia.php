<div id="{{$warehouseLocatorId}}Tooltip">
    <div class="warehouse-tooltip-screen"></div>
    <div class="warehouse-tooltip-container">
        <div class="warehouse-tooltip-body">
            <div class="warehouse-tooltip-close" onclick="closeTooltip('close')">×</div>
            <div class="warehouse-tooltip-body-title">
                {{trans('icommerce::warehouses.messages.you are going to buy for')}}
                {{$warehouse->address}}
            </div>
            <div class="warehouse-tooltip-body-description">
                {{trans('icommerce::warehouses.messages.products for this location')}}
            </div>

            <div class="row justify-content-center mt-4">
                <div class="col-sm-6 pb-3 pb-sm-0">
                    <button type="button" onclick="closeTooltip('keep')" class="btn btn-outline-primary btn-block">{{trans('icommerce::warehouses.button.keep')}}</button>
                </div>
                <div class="col-sm-6">

                    <button type="button" onclick="closeTooltip('change')" data-toggle="modal" data-target="#modalWarehouseLocator" class="btn btn-primary btn-block">
                        {{trans('icommerce::warehouses.button.change')}}
                    </button>

                </div>
            </div>
        </div>
    </div>

@include('icommerce::frontend.livewire.warehouse-show-infor.partials.tooltip.style')

</div>


<script>
    console.warn("INICIA SCRIPT TOOLTIP")
    
    document.addEventListener("DOMContentLoaded", function(event) {
        
        console.warn("INICIA SCRIPT TOOLTIP 222222222222222")

        function closeTooltip(from) {
            console.warn("EPAAAAAAAAA")
            const tooltip = document.getElementById('{{$warehouseLocatorId}}Tooltip');
            if (tooltip.parentNode) {
                tooltip.parentNode.removeChild(tooltip);
            }

            if(from=='keep'){
                //Update variable session
                window.livewire.emit('updateTooltipStatus');
            }
        
        }
        // Función para mostrar el Tooltip
        function mostrarTooltip() {
            const tooltip = document.getElementById('{{$warehouseLocatorId}}Tooltip');
            tooltip.style.display = 'block';
        }

        // Evento cuando la página se carga completamente

        mostrarTooltip();
        //document.addEventListener('DOMContentLoaded', mostrarTooltip);
    });

</script>