@extends('layouts.master')

@section('meta')
    <meta name="description" content="{{trans('icommerce::manufacturers.uri')}}">
    <!-- Schema.org para Google+ -->
    <meta itemprop="name" content="{{trans('icommerce::manufacturers.uri')}}">
    <meta itemprop="description" content="{{trans('icommerce::manufacturers.uri')}}">
@stop

@section('title')
    {{trans('icommerce::manufacturers.uri')}} | @parent
@stop

@section('content')
    <div class="page bg-white blog catalog">
       
        <div class="iblock general-block21" data-blocksrc="general.block21">
            <div class="container">
                <div class="row">
                    <div class="col">

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-4 text-uppercase">
                                <li class="breadcrumb-item">
                                    <a href="#">{{trans('icommerce::common.home.title')}}</a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">
                                    {{trans('icommerce::manufacturers.uri')}}
                                </li>
                            </ol>
                        </nav>

                    </div>
                </div>
            </div>
        </div>

        <section class="content container mt-3 mb-4">
            <div class="row">

                {{--
                <div class="col-12 col-lg-3 d-none d-lg-block">

                    <div class="aboutus">
                        sidebar
                       
                    </div>

                    <div class="novedades">
                       sidebar
                       
                    </div>

                    <div class="promociones">
                        sidebar
                       
                    </div>

                </div>
                --}}

                <div class="col-12  category-body-1">
                    
                    @if (count($manufacturers) !=0)
                    @php $cont = 0; @endphp

                        @foreach($manufacturers as $manufacturer)

                            @if($cont%4 == 0)
                            <div class="row">
                            @endif
                            <div class="col-12 col-sm-6 col-md-3 contend post post{{$manufacturer->id}} mb-3">
                                <a href="{{url('brands/'.$manufacturer->id)}}">
                                    <div class="bg-imagen brand-image border p-1 d-flex align-items-center"
                                    @if(isset($manufacturer->options->mainimage)&&!empty($manufacturer->options->mainimage))
                                        style="background-image: url('{{url($manufacturer->options->mainimage)}}')"
                                        alt="{{$manufacturer->title}}"
                                    @else
                                        style="background-image: url('{{url('modules/iblog/img/post/default.jpg')}}')"
                                        alt="{{$manufacturer->name}}"
                                    @endif>
                                    {{--
                                    @if(isset($manufacturer->options->mainimage)&&!empty($manufacturer->options->mainimage))
                                        <img class="image img-responsive"
                                             src="{{url($manufacturer->options->mainimage)}}"
                                             alt="{{$manufacturer->title}}"/>
                                    @else
                                        <img class="image img-responsive"
                                             src="{{url('modules/iblog/img/post/default.jpg')}}"
                                             alt="{{$manufacturer->name}}"/>
                                    @endif
                                    --}}
                                    </div>
                               </a>
                                <div class="content mt-2">
                                    <a href="">
                                    <h5 class="text-center">{{$manufacturer->name}}</h5>
                                    </a>
                                </div>
                            </div>

                            @php $cont++; @endphp

                            @if($cont%4 == 0)
                                </div>
                            @endif

                        @endforeach

                        <div class="clearfix"></div>

                        <div class="w-100 mb-3">
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>
                        
                        <div class="pagination-blog w-100">

                            <div class="float-right">
                                {{$manufacturers->links()}}
                            </div>

                        </div>

                    @else

                    <div class="col-xs-12 con-sm-12">
                        <div class="white-box">
                            <h3>Ups... :(</h3>
                            <h1>{{trans('icommerce::errors.404.Sorry, this page is not available')}}</h1>
                            <hr>
                            <p style="text-align: center;">{{trans('icommerce::errors.404.Try later')}}</p>
                    </div>

                    @endif

                </div>


            </div>
        </section>

    </div>
@stop