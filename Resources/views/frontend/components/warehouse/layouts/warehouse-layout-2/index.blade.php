<div>

    <div id="{{$warehouseLocatorId}}" class="warehouse-locator position-relative d-inline-block {{$warehouseLocatorClass}}">
        @if(!$iconOrderRight) <i class="{{ $icon ?? ' ' }} {{ $iconClass }}"></i> @endif


            @livewire("icommerce::warehouse-show-infor",[
                "warehouseVar" => $warehouse,
                "textClass" => $textClass,
                "addressClass" => $addressClass
            ])

            {{--
            @if($user && !empty($shippingAddress))
                <span class="{{ $textClass }}">
                {{trans('icommerce::warehouses.messages.hello')}} {{$user->first_name}},
                {{ $text ?? trans('icommerce::warehouses.messages.your address is') }}
                </span>
                <a class="address cursor-pointer {{ $addressClass }}" data-toggle="modal" data-target="#modalWarehouseLocator">
                    <u>{{$shippingAddress->address_1}}</u>
                </a>

            @else
                
                <a class="address cursor-pointer {{$addressClass}}" data-toggle="modal" data-target="#modalWarehouseLocator">
                    {{trans('icommerce::warehouses.messages.hello')}} {{$user ? $user->first_name : ""}}, {{trans('icommerce::warehouses.messages.buying for')}} 
                    
                    @livewire("icommerce::warehouse-show-infor",[
                        "warehouseVar" => $warehouse
                    ])
                    
                </a>

            @endif
            --}}

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