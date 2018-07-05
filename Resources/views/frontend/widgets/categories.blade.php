@if(isset($category) && !empty($category))
    <h6 class="mb-3 text-secondary">
        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
        {{trans('icommerce::categories.filter')}}
    </h6>

    <div class="card border-0 card-items mb-3">
        <div class="card-header text-uppercase bg-primary  py-2 px-3 text-white">
            {{trans('icommerce::categories.subcategory')}}
        </div>
        <ul id="list-category"
            class="list-group list-group-flush">
            @foreach($category->children()->orderBy('title')->get() as $index =>$cat)
                @if($index<5)
                    <li class="list-group-item border-0 pl-4">
                        <i class="fa fa-angle-double-right text-primary"
                           style="margin-left: -12px"></i>
                        <a id="cat_{{$cat->id}}"
                           href="{{$cat->url}}"
                           class="">
                            {{$cat->title}}
                        </a>
                    </li>
                @else
                    <li class="list-group-item border-0 pl-4 item-hide">
                        <i class="fa fa-angle-double-right text-primary"
                           style="margin-left: -12px"></i>
                        <a id="cat_{{$cat->id}}"
                           href="{{$cat->url}}"
                           class="">
                            {{$cat->title}}
                        </a>
                    </li>
                @endif
            @endforeach
            <div class="text-center pt-2">
                <i class="view-more text-primary
                  fa fa-angle-double-down
                  font-weight-bold"
                   aria-hidden="true"
                   style="cursor: pointer"
                   title="desplegar">
                </i>
            </div>
        </ul>
    </div>
@endif



@section('scripts-owl')
    <script>
        $(document).ready(function(){
            $('#list-category').find('.item-hide').slideUp();

            $(".view-more").click(function() {
                $('#list-category').find('.item-hide').slideToggle();

                if ($(this).hasClass('fa-angle-double-down')){
                    $(this).addClass('fa-angle-double-up');
                    $(this).removeClass('fa-angle-double-down');
                }else{
                    $(this).addClass('fa-angle-double-down');
                    $(this).removeClass('fa-angle-double-up');
                }
            });
        });
    </script>

    @parent
@stop