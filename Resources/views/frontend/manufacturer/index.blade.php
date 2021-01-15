@extends('layouts.master')


@section('title')
  {{trans('icommerce::manufacturers.title.manufacturers')}}  | @parent
@stop

@section('content')
  
  <div class="page">

    @php($titleFilter = config("asgard.icommerce.config.filters.manufacturers.title"))
    
    <x-isite::breadcrumb>
      <li class="breadcrumb-item active"
          aria-current="page">
        {{trans($titleFilter)}}
      </li>
    </x-isite::breadcrumb>
    
    <section class="iblock general-block31 pb-5" data-blocksrc="general.block31">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="text-title text-center mb-5">
              <h1 class="title text-uppercase"> {{trans($titleFilter)}} </h1>
            </div>
            <div class="row" id="p_autores">
              
    
                @foreach($manufacturers as $manufacturer)
                  
                  <div class="col-lg-4 mb-4">
                    <div class="card card-autor border-0">
                      <a href="{{$manufacturer->url}}">
                        <div class="bg-image cover-img-4-3">
                          <img src="{{$manufacturer->mediaFiles()->mainimage->path}}"
                               alt="{{$manufacturer->title}}"/>
                        </div>
                      </a>
                      <div class="card-body ">
                        <h4 class="name">
                          <a href="{{$manufacturer->url}}">
                            {{$manufacturer->name}}
                          </a>
                        </h4>
                        <div class="summary">
                          {!! $manufacturer->description !!}
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
         
            
            </div>
          
          </div>
        </div>
      </div>
    </section>
  
  </div>
@stop
