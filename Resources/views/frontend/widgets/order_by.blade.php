<div class="filter-order text-right">
    <div class="d-inline-block text-primary">
        <b>{{ trans('icommerce::common.sort.title') }}</b>
    </div>
    <div class="d-inline-block" style="width: 200px">
        <select class="form-control form-control-sm"
                v-model="order_check"
                v-on:change="order_by()">
            <option value="all" selected>{{ trans('icommerce::common.sort.all') }}</option>
            {{--<option value="rating">Rating</option>--}}
            <option value="nameaz">{{ trans('icommerce::common.sort.name_a_z') }}</option>
            <option value="nameza">{{ trans('icommerce::common.sort.name_z_a') }}</option>
            <option value="lowerprice">{{ trans('icommerce::common.sort.price_low_high') }}</option>
            <option value="higherprice">{{ trans('icommerce::common.sort.price_high_low') }}</option>
        </select>
    </div>
</div>