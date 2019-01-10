@php
	$op = array('required' => 'required');
	$opSelect = array('id' => 'selType');
    $normalSelectArray = ['text'=>'Text','textarea'=>'Textarea','select'=>'Select','radio'=>'Radio','checkbox'=>'Checkbox'];
    $opInputId          = array('id' => 'id',  'name' => 'id[]');
    $opInputDescription = array('id' => 'description', 'name' => 'description_value[]');
    $opInputSortOrder   = array('id' => 'sort_order',  'name' => 'sort_order_value[]');
@endphp

<div class="box-body row">
	@if ($entity->translationEnabled())
	<input type="hidden" name="locale" value={{ $request->input('locale')?$request->input('locale'):App::getLocale() }}>
	@endif

	<div class="col-xs-12">
		@include('icommerce::admin.products.partials.flag-icon',['entity' => $entity,'att' => 'description'])
		{!! Form::normalInput('description',trans('icommerce::options.table.description'), $errors,$option,$op) !!}
		{!! Form::normalSelect('type', trans('icommerce::options.form.type'), $errors, $normalSelectArray,$option,$opSelect) !!}
		<div class="form-group dropdrown">
			<label for="parentOption">trans('icommerce::options.form.parent_option')</label>
			<select class="form-control" name="parent_id" id="parent_option">
				<option value="0">trans('icommerce::options.form.select parent option')</option>
				@foreach($parentOptions as $optionP)
					@if($option->id!=$optionP->id)
						<option value="{{$optionP->id}}" @if($option->parent_id==$optionP->id) selected @endif>{{$optionP->description}}</option>
					@endif
				@endforeach
			</select>
		</div>
		{!! Form::normalInputOfType('number','sort_order',trans('icommerce::options.form.sort_order'),$errors,$option) !!}
	</div>
</div>
