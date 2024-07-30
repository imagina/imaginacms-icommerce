<div class="warehouseShowInfor">
    @if($showComponent)

        {!! $title!!}

        @if($activeTooltip)
            @include('icommerce::frontend.livewire.warehouse-show-infor.partials.tooltip.index')
        @endif

    @else

        <div class="spinner-border spinner-border-sm mr-3" role="status">
            <span class="sr-only">Loading...</span>
        </div>

    @endif

</div>