<div class="dropdown order-by-filter">
    <button class="btn bg-transparent border-0 p-0 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ trans('icommerce::common.sort.title') }}
    </button>
    <div class="dropdown-menu rounded-0 p-3" aria-labelledby="dropdownMenuButton">
        <a class="d-block w-100 cursor-pointer"  @click="order_by('nameaz')">{{ trans('icommerce::common.sort.name_a_z') }}</a>
        <a class="d-block w-100 cursor-pointer"  @click="order_by('nameza')">{{ trans('icommerce::common.sort.name_z_a') }}</a>
        <a class="d-block w-100 cursor-pointer"  @click="order_by('lowerprice')">{{ trans('icommerce::common.sort.price_low_high') }}</a>
        <a class="d-block w-100 cursor-pointer"  @click="order_by('higherprice')">{{ trans('icommerce::common.sort.price_high_low') }}</a>
    </div>
</div>