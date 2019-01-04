@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('icommerce::paymentmethods.title.paymentmethods') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('icommerce::paymentmethods.title.paymentmethods') }}</li>
    </ol>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12">
            
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                @if(isset($paymentMethods) && count($paymentMethods)>0)
                    
                    @php $c= 0; @endphp
                    <ul class="nav nav-tabs">
                        @foreach ($paymentMethods  as $index => $method)
                        <li @if($c==0) class='active' @endif>
                        <a data-toggle="tab" href="#{{$method['name']}}">{{$method->title}}</a>
                        </li>
                        @php $c++; @endphp
                        @endforeach
                    </ul>

                    @php $c= 0; @endphp
                    <div class="tab-content">
                        @foreach ($paymentMethods  as $ind => $method)
                        <div id="{{$method['name']}}" class="tab-pane fade @if($c==0) in active @endif ">

                            <h3>{{$method->title}}</h3>
                            @include($method->name.'::admin.'.$method->name.'s.index') 
                           
                        </div>
                        @php $c++; @endphp
                        @endforeach
                    </div>
                    
                @else
                    <div class="alert alert-danger">
                        {{ trans('icommerce::paymentmethods.messages.no payment methods') }}
                    </div>
                @endif
                
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>

@stop