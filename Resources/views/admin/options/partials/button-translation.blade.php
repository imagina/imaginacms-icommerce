
@if (!$entity->translationEnabled())

	<!-- Single edit button -->
	<a href="{{ route('admin.icommerce.option.edit', [$option->id]) }}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> {{ trans('bcrud::crud.edit') }}</a>

	@else

	<!-- Edit button group -->
	<div class="btn-group">
		@if($option->type=="select" || $option->type=="radio" || $option->type=="checkbox")
		<a href="{{ route('admin.icommerce.option_value.index', [$option->id]) }}" class="btn btn-xs btn-default"><i class="fa fa-plus"></i> {{trans('icommerce::option_values.button.values')}}</a>
		@endif
	  <a href="{{ route('admin.icommerce.option.edit', [$option->id]) }}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> {{ trans('bcrud::crud.edit') }}</a>
	  <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    <span class="caret"></span>
	    <span class="sr-only">Toggle Dropdown</span>
	  </button>
	  <ul class="dropdown-menu dropdown-menu-right">
  	    <li class="dropdown-header">{{ trans('bcrud::crud.edit_translations') }}:</li>
	  	@foreach ($entity->getAvailableLocales() as $key => $locale)
		  	<li><a href="{{ route('admin.icommerce.option.edit', [$option->id]) }}?locale={{ $key }}">{{ $locale }}</a></li>
	  	@endforeach
	  </ul>
	</div>

@endif
