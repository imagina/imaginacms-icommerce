<div class="filter-order-by">
	<div class="form-group row">
		<label for="f-order-by" class="col-xs-2 col-form-label mr-2">
			{{ trans('icommerce::common.sort.title') }}:
		</label>
		<div class="col-xs-10">
			<select id="f-order-by" class="form-control form-control-sm">
		  		<option>{{ trans('icommerce::common.sort.name_a_z') }}</option>
		  		<option>{{ trans('icommerce::common.sort.name_z_a') }}</option>
		  		<option>{{ trans('icommerce::common.sort.price_low_high') }}</option>
		  		<option>{{ trans('icommerce::common.sort.price_high_low') }}</option>
			</select>
		</div>
	</div>
</div>

