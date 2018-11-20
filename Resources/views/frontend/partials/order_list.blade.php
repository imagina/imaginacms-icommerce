@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                {{--
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.icommerce.order.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('icommerce::orders.button.create order') }}
                    </a>
                </div>
                --}}
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
                                <th>{{trans('icommerce::orders.table.id')}}</th>
                                <th>{{trans('icommerce::orders.table.email')}}</th>
                                <th>{{trans('icommerce::orders.table.total')}}</th>
                                <th>{{trans('icommerce::orders.table.status')}}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->total }}</td>
                                <td>{{icommerce_get_Orderstatus()->get($order->order_status)}}</td>
                                <td>
                                    <a href="{{ route('admin.icommerce.order.edit', [$order->id]) }}">
                                        {{ $order->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.icommerce.order.edit', [$order->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        {{--
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.icommerce.order.destroy', [$order->id]) }}"><i class="fa fa-trash"></i></button>
                                        --}}

                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{trans('icommerce::orders.table.id')}}</th>
                                <th>{{trans('icommerce::orders.table.email')}}</th>
                                <th>{{trans('icommerce::orders.table.total')}}</th>
                                <th>{{trans('icommerce::orders.table.status')}}</th>
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

@stop

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.icommerce.order.create') ?>" }
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
@stop
