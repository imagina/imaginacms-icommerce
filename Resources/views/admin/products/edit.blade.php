@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('icommerce::products.title.edit product') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.icommerce.product.index') }}">{{ trans('icommerce::products.title.products') }}</a></li>
        <li class="active">{{ trans('icommerce::products.title.edit product') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.icommerce.product.update', $product->id], 'method' => 'put','enctype' => 'multipart/form-data']) !!}
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
                                        <a href="{{ route('admin.icommerce.product.edit', [$product->id]) }}?locale={{ $key }}">{{ $locale }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <h3 class="box-title" style="line-height: 30px;">{{ trans('bcrud::crud.edit') }}</h3>
                    @else
                        <h3 class="box-title">{{ trans('bcrud::crud.edit') }}</h3>
                    @endif
                </div>

                @include('icommerce::admin.products.partials.edit-fields')
                
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                    <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.icommerce.product.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                </div>
            </div>

        </div>

        @php
            $field = array(
                'name' => 'gallery' , 
                'label' => 'Gallery',
                'label_drag' => trans('iblog::post.form.drag'),
                'label_click' =>trans('iblog::post.form.click'),
                'route_upload' => route('icommerce.gallery.upload'),
                'route_delete' => route('icommerce.gallery.delete'),
                'folder' => 'assets/icommerce/product/gallery/'
            );
        @endphp
        @if(isset($product))
            <?php $rand = $product->id;?>
        @else
            <?php $rand = str_random(5);?>
            <input type="hidden" id="{{$field['name']}}" name="{{$field['name']}}" value="{{$rand}}">
        @endif

    </div>
    {!! Form::close() !!}

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">{{ trans('icommerce::products.gallery.title') }}</h4>
          </div>
          <div class="modal-body">
             @include('icommerce::admin.products.partials.gallery-img') 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('icommerce::products.gallery.ready') }}</button>
          </div>
        </div>
      </div>
    </div>
    
    {{--
    <div class="row">
        <div class="col-xs-12 column-gallery">
            @include('icommerce::admin.products.partials.gallery-img')
        </div> 
    </div>
    --}}
    
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

    <script>
        new Vue({
            el:'#main',
            data:{
                info:'texto inicial',
                mylabel : 'TestDataLabel',
                mylabels : ['happy', 'myhappy', 'hello'],
                mydata : [100, 40, 60]
            }
        })
    </script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.icommerce.product.index') ?>" }
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
