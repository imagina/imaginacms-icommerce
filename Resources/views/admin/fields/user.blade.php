<!-- select -->

<div @include('bcrud::inc.field_wrapper_attributes') >

    <label>{!! $field['label'] !!}</label>

    <?php $entity_model = $crud->model; ?>
    <select
            name="{{ $field['name'] }}"
            @include('bcrud::inc.field_attributes')
    >

        @if ($entity_model::isColumnNullable($field['name']))
            @if (isset($field['nullable']) && $field['nullable']==false)
            @else
                <option value="">-</option>
            @endif
        @endif

        @if (isset($field['emptyvalue']))
            <option value="{{$field['emptyvalue']}}">-</option>
        @endif

        @if (isset($field['model']))
            @foreach ($field['model']::all() as $connected_entity_entry)
                <option value="{{ $connected_entity_entry->getKey() }}"

                        @if ( ( old($field['name']) && old($field['name']) == $connected_entity_entry->getKey() ) || (!old($field['name']) && isset($field['value']) && $connected_entity_entry->getKey()==$field['value']))

                        selected
                @else
                    {{$connected_entity_entry->getKey() == $currentUser->id ? 'selected' : ''}}
                        @endif
                >{{$connected_entity_entry->present()->fullname()}} ({{$connected_entity_entry->{$field['attribute']} }}
                    )
                </option>
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

</div>