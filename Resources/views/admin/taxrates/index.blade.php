@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('icommerce::taxrates.title.taxrates') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('icommerce::taxrates.title.taxrates') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.icommerce.taxrates.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('icommerce::taxrates.button.create taxrates') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('icommerce::taxrates.table.name') }}</th>
                                <th>{{ trans('icommerce::taxrates.table.rate') }}</th>
                                <th>{{ trans('icommerce::taxrates.table.type') }}</th>
                                <th>{{ trans('icommerce::taxrates.table.geozone') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($taxrates)): ?>
                            <?php foreach ($taxrates as $taxrates): ?>
                            <tr>
                                <td>
                                    <a href="{{ route('admin.icommerce.taxrates.edit', [$taxrates->id]) }}">
                                        {{ $taxrates->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.icommerce.taxrates.edit', [$taxrates->id]) }}">
                                        {{ $taxrates->rate }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.icommerce.taxrates.edit', [$taxrates->id]) }}">
                                        {{ $taxrates->type }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.icommerce.taxrates.edit', [$taxrates->id]) }}">
                                        {{ $taxrates->geozone->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.icommerce.taxrates.edit', [$taxrates->id]) }}">
                                        {{ $taxrates->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.icommerce.taxrates.edit', [$taxrates->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.icommerce.taxrates.destroy', [$taxrates->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                              <th>{{ trans('icommerce::taxrates.table.name') }}</th>
                              <th>{{ trans('icommerce::taxrates.table.rate') }}</th>
                              <th>{{ trans('icommerce::taxrates.table.type') }}</th>
                              <th>{{ trans('icommerce::taxrates.table.geozone') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('icommerce::taxrates.title.create taxrates') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.icommerce.taxrates.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@endpush
