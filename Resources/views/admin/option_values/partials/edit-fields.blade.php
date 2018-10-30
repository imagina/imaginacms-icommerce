@php
	$op = array('required' => 'required');
	$opSelect = array('id' => 'selType');
    $normalSelectArray = ['text'=>'Text','textarea'=>'Textarea','select'=>'Select','radio'=>'Radio','checkbox'=>'Checkbox'];
    $opInputId          = array('id' => 'id',  'name' => 'id[]');
    $opInputDescription = array('id' => 'description', 'name' => 'description_value[]');
    $opInputSortOrder   = array('id' => 'sort_order',  'name' => 'sort_order_value[]');
@endphp

<div class="box-body row">

	<div class="col-xs-12">

		@include('icommerce::admin.products.partials.flag-icon',['entity' => $entity,'att' => 'description'])
		{!! Form::normalInput('description',trans('icommerce::options.table.description'), $errors,$option_value,$op) !!}
		{!! Form::normalInputOfType('number','sort_order',trans('icommerce::options.form.sort_order'),$errors,$option_value) !!}
	</div>
</div>
