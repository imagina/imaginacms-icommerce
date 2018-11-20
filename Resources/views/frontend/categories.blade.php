@extends('layouts.master')

@section('meta')
    <meta name="description" content="Categories">
    <!-- Schema.org para Google+ -->
    <meta itemprop="name" content="Categories">
    <meta itemprop="description" content="Categories">

@stop
@section('title')
    {{trans('icommerce::categories.plural')}} | @parent
@stop


@section('content')
    <!-- preloader -->
    <div id="content_preloader"><div id="preloader"></div></div>

    <div class="iblock general-block13"
         style="opacity: 0"
         data-blocksrc="general.block13">

        <!-- ===== PAGINATE ====== -->
        <div class="iblock general-block21" data-blocksrc="general.block21">
            <div class="container">
                <div class="row">
                    <div class="col">

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-4 text-uppercase">
                                <li class="breadcrumb-item">
                                    <a href="/">{{trans('icommerce::common.home.title')}}</a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">
                                    {{trans('icommerce::categories.plural')}}
                                </li>
                            </ol>
                        </nav>

                    </div>
                </div>
            </div>
        </div>


        <div id="shop-category" class="bg-light pt-4 pb-5">
            <h2 class="text-center text-secondary">
                {{trans('icommerce::categories.shop_by_category')}}
            </h2>
            <hr class="border-primary border-2 mb-0">
            <hr class="border-secondary w-10 border-2 mb-0">

            <div class="container">
                <div class="row">
                @if(count($categories) >= 1)
                    @foreach($categories as $category)
                        <!-- vaidation image -->
                            @php
                                if(isset($category->options->mainimage) && !empty($category->options->mainimage)){
                                    $image = url(str_replace('.jpg','_mediumThumb.jpg',$category->options->mainimage));
                                }else{
                                    $image = url('modules/bcrud/img/default.jpg');
                                }
                            @endphp
                            <div class="col col-sm-6 col-lg-3">
                                <div class="card mt-4 border-top-0 border-left-0">
                                    <!-- image -->
                                    <div class="background_image"
                                         style="background-image: url('{{$image}}')">
                                    </div>

                                    <div class="card-body">
                                        <h6 class="card-title text-primary text-center"
                                            style="height: 38px; overflow: hidden"
                                            title="{{$category->title}}">
                                            <a href="{{url($category->slug)}}"
                                               class="text-capitalize">
                                                {{$category->title}}
                                            </a>
                                        </h6>
                                        <hr class="border-primary">
                                        @if(count($category->children))
                                            <ul id="list-category" class="pl-0 mb-0">

                                                @foreach($category->children as $index => $children)
                                                    <li class="@if($index >4)item-hide @endif">
                                                        <i class="view-more text-primary
                                                          fa fa-angle-double-right
                                                          font-weight-bold mr-2"
                                                           aria-hidden="true">
                                                        </i>
                                                        <a href="{{url($children->slug)}}"
                                                           title="{{ $children->title }}">
                                                            {{$children->title}}
                                                        </a>
                                                    </li>
                                                @endforeach
                                                @if($index >4)
                                                    <div class="text-center pt-2">
                                                        <i class="view-more text-primary fa fa-angle-double-down font-weight-bold"
                                                           aria-hidden="true"
                                                           style="cursor: pointer">
                                                        </i>
                                                    </div>
                                                @endif
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    <!-- PAGINATION -->
                        <div id="pagination"
                             class="col-12">
                            <div class="pagination paginacion-blog row">
                                <div class="pull-right">
                                    {{$categories->links('pagination::bootstrap-4')}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts-owl')
    <script>
        $(document).ready(function () {
            $('#shop-category').find('.item-hide').slideUp();

            $(".view-more").click(function () {
                $(this).parents('ul').find('.item-hide').slideToggle();

                if ($(this).hasClass('fa-angle-double-down')) {
                    $(this).addClass('fa-angle-double-up');
                    $(this).removeClass('fa-angle-double-down');
                } else {
                    $(this).addClass('fa-angle-double-down');
                    $(this).removeClass('fa-angle-double-up');
                }
            });

            setTimeout(function(){
                $('#content_preloader').fadeOut(1000,function(){
                    $('.iblock').animate({'opacity':1},500);
                });
            },1500);
        });
    </script>

    @parent
@stop