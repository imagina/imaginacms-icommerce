@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('icommerce::products.title.products') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('icommerce::products.title.products') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.icommerce.product.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('icommerce::products.button.create product') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">

                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr class="filts">
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                            </tr>
                            <tr class="titles">
                                <th>ID</th>
                                <th>{{trans('icommerce::products.table.title')}}</th>
                                <th>SKU</th>
                                <th>{{trans('icommerce::categories.single')}}</th>
                                <th>{{trans('icommerce::manufacturers.single')}}</th>
                                <th>Status</th>
                                <th>Stock Status</th>
                                <th>{{trans('icommerce::products.table.price')}}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            </tbody>

                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>{{trans('icommerce::products.table.title')}}</th>
                                <th>SKU</th>
                                <th>{{trans('icommerce::categories.single')}}</th>
                                <th>{{trans('icommerce::manufacturers.single')}}</th>
                                <th>Status</th>
                                <th>Stock Status</th>
                                <th>{{trans('icommerce::products.table.price')}}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
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
        <dd>{{ trans('icommerce::products.title.create product') }}</dd>
    </dl>
@stop

@push('js-stack')


    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.icommerce.product.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">


        $(function () {

            function escapeSpecialChars(jsonString) {
                 return jsonString.replace(/&quot;/g, '"')
                 .replace(/&amp;/g, "&");
            }

            var locale = "<?php echo $locale ?>";

            $('.data-table thead .filts th').each( function (i) {
                if(i!=7 && i!=8 && i!=9){
                    var title = $('.data-table thead .titles th').eq($(this).index()).text();
                    var serach = '<input style="width:100%;"type="text" placeholder="Search ' + title + '" />';
                    $(this).html('');
                    $(serach).appendTo(this).keyup(
                        function(){
                            var vl = $(this).val();
                            
                            if(vl=="{{trans('icommerce::status.enabled')}}"){
                              vl = 1;  
                            }
                            if(vl=="{{trans('icommerce::status.disabled')}}"){
                              vl = 0;  
                            }

                            if(vl=="{{trans('icommerce::stock_status.instock')}}"){
                              vl = 1;  
                            }

                            if(vl=="{{trans('icommerce::stock_status.outstock')}}"){
                              vl = 0;  
                            }
                           
                            table.fnFilter(vl,i)
                    })
                }
            });

            
            var table = $('.data-table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('admin.icommerce.product.searchProducts')}}",
                "lengthMenu": [[20, 35, 50, 100], [20, 35, 50, 100]],
                "columns": [
                    {"data":"id","name":"icommerce__products.id"},
                    {"data":"title","name":"icommerce__products.title",
                    "render":function ( data, type, row, meta ) {

                        if (typeof data === "object")
                            return data[locale];
                        else
                            return data;

                    }},
                    {"data":"sku","name":"icommerce__products.sku"},
                    {"data":"cattitle","name":"icommerce__categories.title",
                    "render":function ( data, type, row, meta ) {

                        var data = JSON.parse(escapeSpecialChars(data));

                        if (typeof data === "object")
                            return data[locale];
                        else
                            return data;

                    }},
                    {"data":"name","name":"icommerce__manufacturers.name"},
                    {"data":"status","name":"icommerce__products.status",
                    "render":function ( data, type, row, meta ) {
                        if(data==0){
                            return "{{trans('icommerce::status.disabled')}}";
                        }else{
                            return "{{trans('icommerce::status.enabled')}}";
                        }
                        
                    }},
                    {"data":"stock_status","name":"icommerce__products.stock_status",
                    "render":function ( data, type, row, meta ) {
                        
                        if(data==0){
                            return "{{trans('icommerce::stock_status.outstock')}}";
                        }else{
                            return "{{trans('icommerce::stock_status.instock')}}";
                        }
                        
                    }},
                    {"data":"price","name":"icommerce__products.price"},
                    {"data":"created_at","name":"icommerce__products.created_at"},
                    {"data":"id","name":"icommerce__products.id"},
                   
                ],
                 "columnDefs": [ {
                    "targets": 9,
                    "data": "",
                    "render": function ( data, type, row, meta ) {

                        rBase = "{{url('')}}";
                        rEdit = "/backend/icommerce/products/"+data+"/edit";
                        ruta = rBase+rEdit;

                        htmla = '<a href="'+ruta+'" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> {{ trans('bcrud::crud.edit') }}</a>';

                        rDel = "/backend/icommerce/products/"+data;
                        rutaDel = rBase+rDel;
                       
                        htmlDel = '<a href="#" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="'+rutaDel+'" class="btn btn-xs btn-default" style="margin-left:2px;"><i class="fa fa-trash"></i></a>';

                        @if (!$entity->translationEnabled())

                            htmlResult = htmla + htmlDel;

                        @else

                            htmlini = '<div class="btn-group">';
                            htmlfin = '</div>';
                            
                            htmlBtn = ' <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>';

                            htmlUlIni = '<ul class="dropdown-menu dropdown-menu-right"><li class="dropdown-header">{{ trans('bcrud::crud.edit_translations') }}:</li>';
                            @foreach ($entity->getAvailableLocales() as $key => $locale)

                                htmlLi = '<li><a href="'+ruta+'"?locale={{ $key }}">{{ $locale }}</a></li>';

                            @endforeach

                            htmlUlFin = '</ul>';

                            html = htmlini + htmla + htmlBtn + htmlUlIni + htmlLi + htmlUlFin + htmlfin;

                            htmlResult = html + htmlDel;
                            
                        @endif

                        return htmlResult;

                    }
                  } ],
                "order": [[ 8, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }

            });

           

        });


    </script>
@endpush