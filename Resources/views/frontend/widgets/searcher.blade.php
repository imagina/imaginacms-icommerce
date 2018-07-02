<div id="content_searcher" class="dropdown">
    <!-- input -->
    <div id="dropdownSearch"
         data-toggle="dropdown"
         aria-haspopup="true"
         aria-expanded="false"
         role="button"
         class="input-group dropdown-toggle">
        <input id="input_search"
               placeholder="Product name"
               class="form-control"
               type="text"
               v-model="criterion">
        <div class="input-group-append"
             v-on:click="view_result()">
            <button type="button"
                    class="btn btn-primary text-white rounded">
                GO
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
            there are no results
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
                        <!-- price -->
                        {{--<p class="mb-0 text-danger font-weight-bold">
                            $ @{{ item.price }}
                        </p>
                        <hr class=" border-primary mt-0 mx-auto mb-4 w-75 border-2">--}}
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
                See all results...
            </a>
        </div>
    </div>
</div>

<style>
    #content_searcher li{
        list-style: none;
    }
    #content_searcher li:hover{
        background-color: #3056A0 !important;
    }
    #content_searcher li:hover a{
        color: white !important
    }
    .dropdown-toggle::after{
        content: none;
    }
</style>

@section('scripts')
    @parent
    {!!Theme::script('js/app.js?v='.config('app.version'))!!}
    @php $locale = \LaravelLocalization::setLocale() ?: \App::getLocale(); @endphp
    }
    <script>
        const vue_searcher = new Vue({
            el: '#content_searcher',
            data: {
                result: [],
                criterion: '',
                path: '{{route('icommerce.api.product.search')}}',
                route_view: '{{route($locale.'search')}}',
            },
            methods: {
                search: function(){
                    this.criterion ? this.get_products() : this.result = [];
                },
                /*obtiene los productos */
                get_products: function(){
                    var path_search = this.path+'?search='+this.criterion;

                    axios({
                        method: 'Get',
                        responseType: 'json',
                        url: path_search
                    }).then(response => {
                        this.result = response.data;
                });
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
                    this.event_searcher();
                });
            }
        });
    </script>
@stop