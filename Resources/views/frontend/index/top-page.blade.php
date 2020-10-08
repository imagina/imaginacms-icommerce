 @if(isset($category) && !empty($category))

        <div class="top-page border-top border-bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-transparent text-white mb-0">
                                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Inicio</a></li>
                                    @if(isset($category->parent) && !empty($category->parent))
                                        <li class="breadcrumb-item">
                                            <a href="{{ $category->parent->url }}">
                                                {{ $category->parent->title }}
                                            </a>
                                        </li>
                                    @endif
                                    <li class="breadcrumb-item active"
                                        aria-current="page">
                                        {{$category->title}}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-9" v-if="articles.length >= 1">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="mx-2 total-filter"> @{{ totalArticles }} Articulos</span>
                                </div>
                                <div class="col text-right" >
                                    @includeFirst(['icommerce.widgets.order_by','icommerce::frontend.widgets.order_by']) |
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@else

            <div class="top-page border-top border-bottom">
                <div class="container">
                    <div class="row ">
                        <div class="col-lg-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-transparent text-white mb-0">
                                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Inicio</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{trans('icommerce::common.search.search_result')}}
                                        <span class="font-weight-bold">
                                            "{{ isset($criterion) ? $criterion : ''}}"
                                        </span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
@endif