<div class="filter-order-by">
	<div class="form-group row col align-items-center mb-0">
		<label for="f-order-by" class="col-xs-2 col-form-label mr-2">
			{{ trans('icommerce::common.sort.title') }}:
		</label>
		<div class="col-xs-10">
			<select id="f-order-by" name="f-order-by" class="form-control form-control-sm" wire:model="orderBy">
				@foreach( $this->configs['orderBy']['options'] as  $orderOption)
					<option value="{{$orderOption['name']}}">{{ trans($orderOption['title']) }}</option>
				 @endforeach
				
			</select>
		</div>
	</div>
</div>