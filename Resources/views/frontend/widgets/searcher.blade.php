
<div id="search-box" class="">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6">
                <div class="search-product ">


                    <div id="content_searcher" class="dropdown">
                        <!-- input -->
                        <div id="dropdownSearch"
                             data-toggle="dropdown"
                             aria-haspopup="true"
                             aria-expanded="false"
                             role="button"
                             class="input-group dropdown-toggle">
                            <input id="input_search"
                                   placeholder="Nombre del producto"
                                   class="form-control border-0"
                                   type="text"
                                   v-model="criterion">


                            <div class="input-group-btn"
                                 v-on:click="view_result()">
                                <button type="button" style="margin-top: 1px; margin-right: 1px"
                                        class="">
                                    <span class="fa fa-search"></span>
                                </button>
                            </div>
                        </div>

                        <!-- dropdaown search result -->
                        <div id="display_result"
                             class="dropdown-menu w-100 rounded-0 py-3 m-0"
                             aria-labelledby="dropdownSearch"
                             style="z-index: 999999;">

                            <h6 class="text-primary text-center"
                                v-if="result.length <= 0">
                                {{ trans('icommerce::common.search.no_results') }}
                            </h6>

                            <div v-if="result.length >= 1">
                                <div class="cart-items px-3 mb-3"
                                     v-for="(item,index) in result"
                                     v-if="index <= 4" style="max-height: 70px">
                                    <!--Shopping cart items -->
                                    <div class="cart-items-item row">
                                        <!-- image -->
                                        <a v-bind:href="item.url"
                                           class="cart-img pr-0  float-left col-3 text-center">
                                            <img class="img-fluid"
                                                 v-bind:src="item.mainimage"
                                                 v-bind:alt="item.title"
                                                 style="max-height: 76px">
                                        </a>
                                        <!-- dates -->
                                        <div class="float-left col-9">
                                            <!-- title -->
                                            <h6 class="mb-0">
                                                <a v-bind:href="item.url"
                                                   class="text-secondary font-weight-bold text-lowercase">
                                                    @{{ item.title }}
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>

                            <!-- view more -->
                            <div v-if="result.length >= 1"
                                 class="px-3 text-right">
                                <a v-bind:href="[route_view+'?search='+criterion]"
                                   class="text-secondary font-weight-bold">
                                    {{ trans('icommerce::common.search.see_all') }}
                                </a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>




@section('scripts-owl')
    @parent

    @php $locale = \LaravelLocalization::setLocale() ?: \App::getLocale(); @endphp
    <script>
        const vue_searcher = new Vue({
            el: '#content_searcher',
            data: {
                result: [],
                criterion: '',
                path: '',
                route_view: '',
            },
            methods: {
                search: function(){
                    this.criterion ? this.get_products() : this.result = [];
                },
                /*obtiene los productos */
                get_products: function(){

                },
                /*evento enter sobre el buscar*/
                event_searcher: function() {
                    $("#input_search").keyup(function (e) {
                        var val = $(this).val();

                        if (val){
                            if (e.keyCode === 13) {
                                vue_searcher.view_result();
                            } else {
                                vue_searcher.search();
                            }
                        }else{
                            vue_searcher.result = []
                        }
                    });
                },
                /*carga la vista con todos los resultados*/
                view_result: function(){
                    if (this.criterion) {
                        window.location.href = this.route_view + '?search=' + this.criterion;
                    }else{
                        $("#input_search").focus();
                    }
                }
            },
            mounted: function () {
                this.$nextTick(function () {
                  vue_searcher.event_searcher();
                });
            }
        });
    </script>
@stop
