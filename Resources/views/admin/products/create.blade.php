@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('icommerce::products.title.create product') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.icommerce.product.index') }}">{{ trans('icommerce::products.title.products') }}</a></li>
        <li class="active">{{ trans('icommerce::products.title.create product') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.icommerce.product.store'], 'method' => 'post','enctype' => 'multipart/form-data']) !!}
    <div class="row" id="main">
        <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">{{ trans('icommerce::products.title.create product') }}</div>
                
                @include('icommerce::admin.products.partials.create-fields')
               
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
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
