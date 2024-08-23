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