{{--<div class="filter-order col-md-3 col-">
        <h3> {{ trans('icommerce::common.sort.title') }}</h3>
        <div class="d-inline-block">
            <a class="d-block w-100" value="all">{{ trans('icommerce::common.sort.all') }}</a>
            <a class="d-block w-100" value="nameaz">{{ trans('icommerce::common.sort.name_a_z') }}</a>
            <a class="d-block w-100" value="nameza">{{ trans('icommerce::common.sort.name_z_a') }}</a>
            <a class="d-block w-100" value="lowerprice">{{ trans('icommerce::common.sort.price_low_high') }}</a>
            <a class="d-block w-100" value="higherprice">{{ trans('icommerce::common.sort.price_high_low') }}</a>
        
    </div>
</div>
--}}

<div class="filter-order col-md-3 col-6">
   
    <h3>Ordenar Por</h3>
    <div class="d-inline-block">
            
            <a class="d-block w-100 cursor-pointer"  @click="order_by('nameaz')">{{ trans('icommerce::common.sort.name_a_z') }}</a>
            <a class="d-block w-100 cursor-pointer"  @click="order_by('lowerprice')">{{ trans('icommerce::common.sort.price_low_high') }}</a>
            <a class="d-block w-100 cursor-pointer"  @click="order_by('higherprice')">{{ trans('icommerce::common.sort.price_high_low') }}</a>
        </ul>
    </div>
</div>