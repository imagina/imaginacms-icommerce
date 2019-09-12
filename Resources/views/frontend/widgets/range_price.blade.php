{{-- <div class="card border-0 card-items mb-3">
    <div class="card-header bg-primary  py-2 px-3 text-white">
        {{trans('icommerce::common.range.title')}}
    </div>

    <div class="range_price_contend card-body pl-4 pt-3">
        <!-- rango -->
        <div id="slider-range"></div>
        <!-- valores -->
        <div class="pt-2 pr-3">
            <span id="amount" class="text-primary"></span>
        </div>
    </div>
</div>
--}}

<div class="filter-price col-md-3 col-6">
    <h3 class="text-capitalize">{{trans('icommerce::common.range.title')}}</h3>
    <div class="d-inline-block">
        <a class="cursor-pointer d-block w-100" @click="filter_price([min_price,150])"> $0.00 - $150.00</a>
        <a class="cursor-pointer d-block w-100" @click="filter_price([150,300])">$150.00 - $300.00</a>
        <a class="cursor-pointer d-block w-100" @click="filter_price([300,450])">$300.00 - $450.00</a>
        <a class="cursor-pointer d-block w-100" @click="filter_price([450,max_price])">$450.00 +</a>
    </div>
</div>
