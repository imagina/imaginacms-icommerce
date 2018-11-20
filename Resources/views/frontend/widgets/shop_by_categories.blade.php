@php
    $categories=get_product_category(['parent_id'=>0,'order' => 'asc', 'take' => 12, 'exclude' => [333,334,335]]);

@endphp


<div id="shop-category" class="bg-light pt-4 pb-5">
    <div class="container">
        <div class="row">
        @if(count($categories))
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
                        <!--
                            <div class="h-50 background_image"
                                 style="background-image: url('{{$image}}')">
                            </div>
                            -->
                            <div class="card-img-top d-flex">
                                <img class="rounded-0 background_image align-self-center d-block mx-auto" src="{{ $image }}" style="max-height: 100%">
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
                <div class="col-12 mt-4 text-center">
                    <a href="{{ route('icommerce.categories') }}"
                       class="btn btn-outline-secondary">
                        <i class="fa fa-eye"></i>
                        {{trans('icommerce::categories.messages.see_all')}}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>


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
        });
    </script>

    @parent
@stop