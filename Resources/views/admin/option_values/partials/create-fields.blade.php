@php
	$op = array('required' => 'required');
    $opSelect = array('id' => 'selType');
    $normalSelectArray = ['text'=>'Text','textarea'=>'Textarea','select'=>'Select','radio'=>'Radio','checkbox'=>'Checkbox'];
@endphp
<div class="box-body row">
	@if ($entity->translationEnabled())
		<input type="hidden" name="locale" value={{App::getLocale()}}>
	@endif

	<div class="col-xs-12">

		@include('icommerce::admin.products.partials.flag-icon',['entity' => $entity,'att' => 'description'])
		{!! Form::normalInput('description',trans('icommerce::options.table.description'), $errors,null,$op) !!}
		{!! Form::normalInputOfType('number','sort_order',trans('icommerce::options.form.sort_order'),$errors) !!}
    <input type="hidden" name="option_id" value="{{$option->id}}">
	</div>
</div>
