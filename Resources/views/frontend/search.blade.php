@extends('layouts.master')

@section('meta')
        <meta name="description" content="{{trans('icommerce.common.search.titlettt')}} ">
        <!-- Schema.org para Google+ -->
        <meta itemprop="name" content="{{trans('icommerce.common.search.title')}}">
        <meta itemprop="description" content="{{trans('icommerce.common.search.title')}}">
        <meta itemprop="image"
              content="{{url('/')}}">
@stop
@section('title')
    Busqueda de Productos  | @parent
@stop


@section('content')

    <!-- preloader -->
    <div id="content_preloader">
        <div id="preloader"></div>
    </div>

    <div id="content_index_commerce" class="page">

        @component('partials.widgets.breadcrumb')
            <li class="breadcrumb-item active" aria-current="page">
                Resultado de la Busqueda
            </li>
        @endcomponent

        <div class="container">
            <div class="row">


                <div class="col-lg-3 pb-5">

                    <div class="categories-children pb-4">

                        <h3 class="text-main  text-uppercase mb-4">
                            Categorias Principales
                        </h3>
                        <div v-if="categories && categories.length>0">
                            <div class="filter-order mb-3 " v-for="(category,index) in categories">

                                <a class="item" data-toggle="collapse" v-if="category.childrens && category.childrens.length>0 "
                                   v-bind:href="'#category-'+category.id" role="button" aria-expanded="false"
                                   v-bind:aria-controls="'category-'+category.id">
                                    <h5 class="p-3 bg-light d-block cursor-pointer mb-0" style="border-radius: 0 20px 0 0;">
                                        <i class="fa angle mr-1" aria-hidden="true"></i>
                                        @{{category.title}}
                                    </h5>

                                </a>

                                <a :href="url+'/'+category.slug" class="item p-3 bg-light d-block cursor-pointer"
                                   style="border-radius: 0 20px 0 0;" v-else-if="category.slug!='destacados'">
                                    <h5 class="mb-0">@{{category.title}}</h5>
                                </a>

                                <div class="collapse multi-collapse mb-2" v-bind:id="'category-'+category.id">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" v-for='i in category.childrens'>
                                            <a class="d-block w-100 cursor-pointer" data-sab="2" :href="'{{url('/')}}/'+i.slug">
                                                <span class="text-primary mr-2">•</span>
                                                @{{i.title}} </a>
                                        </li>
                                    </ul>
                                </div>


                            </div>
                        </div>

                    </div>



                </div>
                <div class="col-lg-9">
                    <!-- ===== CONTENT ===== -->

                    <div class="text-right">
                        <span class="mx-2 total-filter"> {{$products->total()}} Articulos</span>
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
                                                        {{formatMoney($product->price)}}
                                                    </div>
                                                    <a class="cart-no">&nbsp;</a>
                                                    @if($product->price)
                                                   {{-- <add-cart product="{{$product}}"/>--}}
                                                        <a class="cart text-primary cursor-pointer">&nbsp;</a>
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
                                    <div class="col">
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
                this.$nextTick(function () {
                    this.getCategory();
                });
                $('#content_preloader').fadeOut(1000, function () {
                    $('#content_index_commerce').animate({'opacity': 1}, 500);
                });
            },
            filters: {
                numberFormat: function (value) {
                    return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                }
            },
            methods: {
                getCategory() {
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
