@if (method_exists($entity, 'isTranslatableAttribute') && ($entity->isTranslatableAttribute($att)) && config('bcrud.backpack.crud.show_translatable_field_icon'))

	<i class="fa fa-flag-checkered pull-{{ config('bcrud.backpack.crud.translatable_field_icon_position') }}" style="margin-top: 3px;" title="This field is translatable."></i>

@endif