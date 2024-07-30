<div>

    <div id="{{$warehouseLocatorId}}" class="warehouse-locator position-relative d-inline-block {{$warehouseLocatorClass}}">
        @if(!$iconOrderRight) <i class="{{ $icon ?? ' ' }} {{ $iconClass }}"></i> @endif


            @livewire("icommerce::warehouse-show-infor",[
                "warehouseVar" => $warehouse,
                "textClass" => $textClass,
                "addressClass" => $addressClass
            ])


        @if($iconOrderRight) <i class="{{ $icon ?? ' ' }} {{ $iconClass }}"></i> @endif

        @if($activeTooltip)
            @include('icommerce::frontend.components.warehouse.partials.tooltip')
        @endif
    </div>

@include('icommerce::frontend.components.warehouse.partials.style-layout-2')
@include('icommerce::frontend.components.warehouse.partials.modal')
@include('icommerce::frontend.components.warehouse.partials.alert')


</div>

@section('scripts')
@parent
<script type="text/javascript">
    console.warn("============= WAREHOUSE LAYOUT 2 | INIT")

    function showComponent()
    {
        console.warn("Emit: warehouseBladeIsReady")
        window.livewire.emit('warehouseBladeIsReady');
    }

    document.addEventListener('DOMContentLoaded', showComponent);
</script>

@stop