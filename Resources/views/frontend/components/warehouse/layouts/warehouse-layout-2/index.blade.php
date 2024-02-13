<div>
    <div id="{{$warehouseLocatorId}}" class="warehouse-locator position-relative d-inline-block {{$warehouseLocatorClass}}">
        @if(!$iconOrderRight) <i class="{{ $icon ?? ' ' }} {{ $iconClass }}"></i> @endif

            @if($user && !empty($shippingAddress))
                <span class="{{ $textClass }}">
                {{trans('icommerce::warehouses.messages.hello')}} {{$user->first_name}},
                {{ $text ?? trans('icommerce::warehouses.messages.your address is') }}
                </span>
                <a class="address cursor-pointer {{ $addressClass }}" data-toggle="modal" data-target="#modalWarehouseLocator">
                    <u>{{$shippingAddress->address_1}}</u>
                </a>

            @else
                @if($user)
                    <a class="address cursor-pointer {{$addressClass}}" data-toggle="modal" data-target="#modalWarehouseLocator">
                        {{trans('icommerce::warehouses.messages.hello')}} {{$user->first_name}}, {{trans('icommerce::warehouses.messages.buying for')}} {{$warehouse->address}}
                    </a>
                @else
                    {{trans('icommerce::warehouses.messages.hello')}}, <a class="cursor-pointer" onclick="location.href='{{"/ipanel/#/auth/login/?redirectTo=".url()->current()}}'"> <!-- llamar al login -->
                        {{trans('icommerce::warehouses.messages.not logged')}}
                    </a>
                @endif

            @endif

        @if($iconOrderRight) <i class="{{ $icon ?? ' ' }} {{ $iconClass }}"></i> @endif

        @if($activeTooltip)
            @include('icommerce::frontend.components.warehouse.partials.tooltip')
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
@if($addressStyle)
#{{$warehouseLocatorId}} .address {
         {!! $addressStyle !!}
}
@endif
@if($addressStyleHover)
#{{$warehouseLocatorId}} .address:hover {
         {!! $addressStyleHover !!}
}
@endif
</style>
@include('icommerce::frontend.components.warehouse.partials.modal')
@include('icommerce::frontend.components.warehouse.partials.alert')
</div>