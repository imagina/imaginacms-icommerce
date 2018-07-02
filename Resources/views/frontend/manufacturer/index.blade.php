@extends('layouts.master')

@section('meta')
    <meta name="description" content="catalogo">
    <!-- Schema.org para Google+ -->
    <meta itemprop="name" content="catalogo">
    <meta itemprop="description" content="catalogo">
@stop

@section('title')
    Catalogo | @parent
@stop

@section('content')
    <div class="page bg-white blog catalog">
       
        <section class="border-bottom iblock general-block31" data-blocksrc="general.block31">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-white mb-0 text-uppercase">
                                <li class="breadcrumb-item"><a href="{{url("/")}}">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Catalogo</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>      

        <section class="content container mt-3 mb-4">
            <div class="row"> 

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

                <div class="col-12 col-lg-9 category-body-1">
                    <div class="row">
                    
                        @if (count($manufacturers) !=0)
                        @php $cont = 0; @endphp

                            @foreach($manufacturers as $manufacturer)

                                <div class="col-xs-6 col-sm-3 contend post post{{$manufacturer->id}} mb-3">
                                    <a href="{{route('icommerce.manufacturers.details', ['id' => $manufacturer->id])}}">
                                        <div class="bg-imagen border p-1 d-flex align-items-center">
                                            @if(isset($manufacturer->options->mainimage)&&!empty($manufacturer->options->mainimage))
                                                <img class="image img-responsive"
                                                     src="{{url($manufacturer->options->mainimage)}}"
                                                     alt="{{$manufacturer->title}}"/>
                                                {{--
                                                <img class="image img-responsive"
                                                     src="{{url(str_replace('.jpg','_mediumThumb.jpg',$post->options->mainimage))}}"
                                                     alt="{{$post->title}}"/>
                                                --}}
                                            @else
                                                <img class="image img-responsive"
                                                     src="{{url('modules/iblog/img/post/default.jpg')}}"
                                                     alt="{{$manufacturer->name}}"/>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="content mt-2">
                                        <a href="{{route('icommerce.manufacturers.details', ['id' => $manufacturer->id])}}"><h2 class="text-center">{{$manufacturer->name}}</h2></a>
                                    </div>
                                </div>
                                @php $cont++; @endphp
                                {{--
                                @if($cont%3==0)
                                    <div class="clearfix" style="margin:10px 0"></div>
                                @endif
                                --}}

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
                                <h1>404 Post no encontrado</h1>
                                <hr>
                                <p style="text-align: center;">No hemos podido encontrar el Contenido que estás buscando.</p>
                        </div>

                        @endif

                    </div>
                </div>


            </div>
        </section>  

    </div>
@stop