@extends('layouts.master')

@section('meta')
        <meta name="description" content="{{trans('icommerce.common.search.title')}} ">
        <!-- Schema.org para Google+ -->
        <meta itemprop="name" content="{{trans('icommerce.common.search.title')}}">
        <meta itemprop="description" content="{{trans('icommerce.common.search.title')}}">
        <meta itemprop="image"
              content="{{url('/')}}">
@stop
@section('title')
    {{trans('icommerce.common.search.title')}}  | @parent
@stop


@section('content')


    {{--   <!-- preloader -->
       <div id="content_preloader">
           <div id="preloader"></div>
       </div>
   --}}


    <div id="content_index_commerce" class="page">

        <div class="container pt-5">
            <div class="row">

                {{--<div class="col-12 text-right pb-5 d-none d-lg-block" v-if="articles.length >= 1">
                    | <span class="mx-2 total-filter"> @{{ totalArticles }} Articulos</span>
                    | @include('icommerce.widgets.order_by') |
                </div>--}}


                <div class="col-lg-3 pb-5">
                    {{--  @include('icommerce.widgets.categories')
  --}}
                    <hr class="border-primary">

                    <div class="d-none d-lg-block">
                        {{-- @include('icommerce.widgets.destacados')--}}
                    </div>

                </div>
                <div class="col-lg-9 border-left pb-5">
                    <!-- ===== CONTENT ===== -->

                    <div class="text-right pb-5 d-block d-lg-none">
                        <span class="mx-2 total-filter"> {{$products->total()}} Articulos</span>
                        {{--@include('icommerce.widgets.order_by') |--}}
                    </div>

                    <div id="content">

                        <div id="cont_products" class="mt-4">
                            @if(count($products))
                                <div class="row products-index mb-5">
                                    @foreach($products as $product)
                                        <div class="col-6 col-sm-6 col-md-4 mb-4">
                                            <!-- PRODUCT -->
                                            <div class="card-product mb-4">
                                                <div class="bg-img cursor-pointer ">
                                                    <a href="{{$product->url}}">
                                                        <img class="card-img-top" alt="{{$product->name}}"
                                                             src="{{$product->mainImage->path}}">
                                                    </a>
                                                </div>
                                                <div class="mt-3 pb-3 text-center">
                                                    <div class="category">
                                                        {{ $product->category->title }}
                                                    </div>

                                                    <a href="{{$product->url}}" class="name cursor-pointer">
                                                        {{$product->name}}
                                                    </a>

                                                    <div class="price mt-3">
                                                        <i class="fa fa-shopping-cart icon"></i>
                                                        {{$product->price}}
                                                    </div>
                                                    <a class="cart-no">&nbsp;</a>
                                                    @if($product->price)
                                                   {{-- <add-cart product="{{$product}}"/>--}}
                                                    @else
                                                    <a href="{{ URL::to('/contacto') }}"
                                                       class="cart text-primary cursor-pointer">
                                                        Contacta con nosotros
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                            <!-- si no hay productos -->
                                <div class="row products-index mb-5">
                                    <div>
                                        No se encontraron productos...
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop
@section('scripts')
    @parent
    <script>
        /* =========== VUE ========== */
        const vue_index_commerce = new Vue({
            el: '#content_index_commerce',

            data: {
                categories: [],
                filters: {
                    order: {
                        field: 'created_at',
                        way: 'DESC'
                    },
                    range_price: {
                        min_price: null,
                        max_price: null
                    },
                },
                preloader: true,
                loadProduct: false,
            },
            mounted: function () {
                this.preloaded = false;
            },
            filters: {
                numberFormat: function (value) {
                    return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                }
            },
            methods: {
                getCategoryChildrens() {
                    axios({
                        method: 'Get',
                        responseType: 'json',
                        url: "{{ route('api.icommerce.categories.index') }}",
                        params: {
                            filter: {
                                parentId: 0
                            },
                            include: 'children',
                        }
                    }).then(response => {
                        this.categories = response.data.data;
                    });
                },
            }
        });
    </script>
@stop
