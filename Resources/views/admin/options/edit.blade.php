@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('icommerce::options.title.edit option') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.icommerce.option.index') }}">{{ trans('icommerce::options.title.options') }}</a></li>
        <li class="active">{{ trans('icommerce::options.title.edit option') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.icommerce.option.update', $option->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">

             <div class="box">

                <div class="box-header with-border">
                    @if ($entity->translationEnabled())
                    <!-- Single button -->
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                {{trans('bcrud::crud.language')}}
                                : {{ $entity->getAvailableLocales()[$request->input('locale')?$request->input('locale'):App::getLocale()] }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($entity->getAvailableLocales() as $key => $locale)
                                    <li>
                                        <a href="{{ route('admin.icommerce.option.edit', [$option->id]) }}?locale={{ $key }}">{{ $locale }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <h3 class="box-title" style="line-height: 30px;">{{ trans('bcrud::crud.edit') }}</h3>
                    @else
                        <h3 class="box-title">{{ trans('bcrud::crud.edit') }}</h3>
                    @endif
                </div>

                @include('icommerce::admin.options.partials.edit-fields')
                
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.icommerce.option.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.icommerce.option.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
@endpush
