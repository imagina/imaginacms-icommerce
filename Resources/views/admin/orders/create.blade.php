@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('icommerce::orders.singular') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.icommerce.order.index') }}">{{ trans('icommerce::orders.title.orders') }}</a></li>
        <li class="active">{{ trans('icommerce::orders.title.create order') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.icommerce.order.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                <div class="box-header with-border">{{ trans('icommerce::orders.singular') }}</div>
                
                @include('icommerce::admin.orders.partials.create-fields')
              
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
                    { key: 'b', route: "<?= route('admin.icommerce.order.index') ?>" }
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
