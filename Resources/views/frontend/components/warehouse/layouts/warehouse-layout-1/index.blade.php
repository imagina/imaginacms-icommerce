<div>

    <div id="{{$warehouseLocatorId}}" class="warehouse-locator cursor-pointer position-relative d-inline-block {{$warehouseLocatorClass}}"
        @if($user)
            data-toggle="modal" data-target="#modalWarehouseLocator"
        @else
            onclick="location.href='{{"/ipanel/#/auth/login/?redirectTo=".url()->current()}}'"
        @endif
    >
        @if(!$iconOrderRight) <i class="{{ $icon ?? 'fa-solid fa-map-location' }} {{ $iconClass }}"></i> @endif
        <span class="{{ $textClass }}">{{ $text ?? 'Tu Ubicación' }}</span>
        @if($iconOrderRight) <i class="{{ $icon ?? 'fa-solid fa-map-location' }} {{ $iconClass }}"></i> @endif
        @if($activeTooltip)
            @include('icommerce::frontend.livewire.warehouse-locator.partials.tooltip')
        @endif

    </div>

    <style>
        @if($warehouseLocatorStyle)
        #{{$warehouseLocatorId}} {
        {!! $warehouseLocatorStyle !!}
        }
        @endif
        @if($warehouseLocatorStyleHover)
        #{{$warehouseLocatorId}}:hover {
        {!! $warehouseLocatorStyleHover !!}
        }
        @endif
        @if($iconStyle)
        #{{$warehouseLocatorId}} i {
        {!! $iconStyle !!}
        }
        @endif
        @if($iconStyleHover)
        #{{$warehouseLocatorId}}:hover i {
        {!! $iconStyleHover !!}
        }
        @endif
        @if($textStyle)
        #{{$warehouseLocatorId}} span {
        {!! $textStyle !!}
        }
        @endif
        @if($textStyleHover)
        #{{$warehouseLocatorId}}:hover span {
        {!! $textStyleHover !!}
        }
        @endif
    </style>
    @include('icommerce::frontend.components.warehouse.partials.modal')
    @include('icommerce::frontend.components.warehouse.partials.alert')

</div>