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
		{!! Form::normalInputOfType('number','sort_order',trans('icommerce::options.form.sort_order'),$errors,$option) !!}
	</div>
</div>
