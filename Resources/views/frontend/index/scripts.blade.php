@section('scripts')
@parent
<script>
      
const vue_index_commerce = new Vue({
            el: '#content_index_commerce',
            data: {
                /*paginador*/
                preloaded: true,
                currencySymbolLeft: icommerce.currencySymbolLeft,
                currencySymbolRight: icommerce.currencySymbolRight,
                v_pages: 1,
                ////Paginación
                p_currence: 1,//Página Actual
                pages: 1,//Cantidad de páginas
                totalArticles:0,//Total de registros
                ////Paginación
                r_pages: {
                    first: 1,
                    latest: 5
                },
                /*dates*/
                articles: [],
                categorititle: ' {{$category->title}} ',
                /*order*/
                order: {
                    field: 'created_at',
                    way: 'DESC'
                },
                /*manufacturer*/
                /*rango de precio*/
                range_price: {
                    min_price: null,
                    max_price: null
                },                /*Filters !!!!!!!!!!!!!!!!!! */
                category:{!! $category ? json_encode($category) : "''"  !!},
                category_parent: {{$category->id}}, /*CATEGORIA PADRE*/
                categories: [], /*SUBCATEGORIAS*/
                categoryimg: [],
                categorybase: [],
                queryExternalCategory:false,
                indexCategory:0,
                price: {
                    from: 0,
                    to: 999999
                },
                /*order*/
                order_check: 'Organizar Por',
                /*rango de precio*/
                min_price: 0,
                max_price: 999999,
                v_max: false,
                v_min: false,
                /*wishlist*/
                user: {!! $currentUser ? $currentUser->id : 0 !!},
                /*currency*/
                currency: '$',
                preloader: true,
                loadProduct: false,
                categoriesmain: [],
                options:[],
                options_selected:[],
                products_wishlist:[],
            },
            mounted: function () {
                this.preloaded = false;
                this.getProducts();
                this.getCategory();
                this.getCategoryParent();
                //this.getCategoryCategory();
                this.getOptions();
                this.get_wishlist();
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
                /*obtiene las opciones de producto */
                getOptions: function () {
                    axios.get("{{ url('api/icommerce/v3/options') }}",{
                        params:{
                            include:"optionValues"
                        }
                    }).then(function (response) {
                        console.log(response.data);
                        vue_index_commerce.options=response.data.data;
                    });
                },
              /* products wishlist */
                 get_wishlist: function () {
                    if (this.user) {
                      let token="Bearer "+"{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
                        axios({
                            method: 'get',
                            responseType: 'json',
                            url: "{{url('/')}}"+"/api/icommerce/v3/wishlists"+'?filter={"user":' + this.user+'}',
                              headers:{
                                'Authorization':token
                              }

                        }).then(response => {
                            this.products_wishlist = response.data.data;
                            $.each(this.products_wishlist, function (index, item) {
                                if ( vue_show_commerce.product.id==item.product_id) {
                                    button = $('.btn-wishlist').prop( "disabled", false );
                                      button.find("i").addClass('fa-heart').removeClass('fa-heart-o');
                                }
                    });
                        })
                    }
                },

                /* product add wishlist */
                addWishList: function (item) {
                    if (this.user) {
                      let token="Bearer "+"{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
                        button = $('.btn-wishlist');
                        button.find("i").addClass('fa-spinner fa-spin').removeClass('fa-heart');
                        if (!this.check_wisht_list(item.id)) {
                            axios.post("{{url('/')}}"+"/api/icommerce/v3/wishlists", {
                                attributes:{
                                    user_id: this.user,
                                    product_id: item.id
                                }
                            },{
                              headers:{
                                'Authorization':token
                              }
                            }).then(response => {
                                this.get_wishlist();
                                 this.alerta("Producto agregado a la lista de deseos", "success");
                                 button.find("i").addClass('fa-heart').removeClass('fa-spinner fa-spin');
                            })
                        } else {
                            button.find("i").addClass('fa-heart-o').removeClass('fa-spinner fa-spin');
                            this.alerta("Ya este producto está en la lista de deseos", "warning");
                        }
                    }
                    else {
                        this.alerta("Por Favor, Inicie Sesión", "warning");
                    }
                },

                /*check if exist product in wisthlist*/
                check_wisht_list: function (id) {
                    var response = false;
                    $.each(this.products_wishlist, function (index, item) {
                        if ( id==item.product_id) {
                            response = true;
                        }
                    });
                    return response;
                },
                /*alertas*/
                alerta: function (menssage, type) {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": 400,
                        "hideDuration": 400,
                        "timeOut": 4000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    toastr[type](menssage);
                },
              loadCategory(indexCategory){
                this.indexCategory=indexCategory;
                this.queryExternalCategory=true;
                vue_index_commerce.loadProduct = true;
                /*Load Products */
                axios({
                  method: 'Get',
                  responseType: 'json',
                  url: "{{ route('api.icommerce.products.index') }}",
                  params: {
                    filter:{
                      order: this.order,
                      status: 1,
                      categories:indexCategory.id
                    },

                    page:1,
                    take:9,
                     include: 'category',
                  }
                }).then(response=> {
                  vue_index_commerce.order_response(response);
                  vue_index_commerce.categorititle=indexCategory.title;
                  vue_index_commerce.loadProduct = false;
                });
              },
              getProducts() {
                this.preloaded = true;
                var filter={
                  order: this.order,
                  status: 1,
                  categories:this.category.id,
                  priceRange: this.price,
                  optionValues: this.options_selected,
                };
                axios({
                  method: 'Get',
                  responseType: 'json',
                  url: "{{ route('api.icommerce.products.index') }}",
                  params: {
                    filter:filter,
                    take:9,
                    include: 'category',
                    page:this.p_currence
                  }
                }).then(response=> {
                  vue_index_commerce.order_response(response);
                    this.preloaded = false;
                });
              },
              getCategory() {
                axios({
                    method: 'Get',
                    responseType: 'json',
                    url: icommerce.url+'/api/icommerce/v3/categories/{{$category->id??''}}',
                    params: {
                        include: 'children',
                    }
                }).then(response=> {
                    vue_index_commerce.categorybase = response.data.data;
                });
              },
              getCategoryParent() {
                axios({
                    method: 'Get',
                    responseType: 'json',
                    url: icommerce.url+'/api/icommerce/v3/categories/?filter={"parentId":0}'
                }).then(response=> {
                    this.categoriesmain = response.data.data;
                });
              },
              /*Order response v2*/
              order_response: function(response){

                /*productos*/
                this.articles=response.data.data;
                /*paginador*/
                this.p_currence = response.data.meta.page.currentPage;
                this.pages = response.data.meta.page.lastPage;
                this.r_pages.latest = response.data.meta.page.lastPage;
                this.totalArticles = response.data.meta.page.total;

              },
              /*Order response v2*/
              /*Limpiar los filtros y traer todos los productos de la categoria*/
              clearAll: function(){
                this.order= {
                  by: 'created_at',
                  type: 'DESC'
                };
                this.indexCategory=0;
                this.queryExternalCategory=false;
                this.getProducts();
              },

              /*change paginate to limit*/
              change_page_limit: function (page, btn) {
                if (btn === 'first') {
                  this.r_pages.first = 1;
                  this.r_pages.latest = this.v_pages;
                }
                if (btn === 'last') {
                  this.r_pages.first = (this.pages - this.v_pages);
                  this.r_pages.latest = this.pages;
                }

                this.getProducts();
              },

              changePage(type,numberPage=0){
                if(type=="first"){
                  this.p_currence=1;
                }else if(type=="last"){
                  this.p_currence=this.r_pages.latest;
                }else if(type=="next"){
                  this.p_currence=this.p_currence+1;
                }else if(type=="back"){
                  if(this.p_currence>1)
                  this.p_currence=this.p_currence-1;
                  else
                  return false;
                }else if(type=="page"){
                  this.p_currence=numberPage;
                }
                this.getProducts();
              },

              /* configura la consulta por order by */
              order_by: function  (order) {
                switch (order) {
                  case 'all' :
                  this.order.field = 'created_at';
                  this.order.way = 'desc';
                  this.order = this.order;
                  break;
                  case 'rating' :
                  this.order.field = 'rating';
                  this.order.way = 'desc';
                  this.order = this.order;
                  break;
                  case 'nameaz' :
                  this.order.field = 'slug';
                  this.order.way = 'asc';
                  this.order = this.order;
                  break;
                  case 'nameza' :
                  this.order.field = 'slug';
                  this.order.way = 'desc';
                  this.order = this.order;
                  break;
                  case 'lowerprice' :
                  this.order.field = 'price';
                  this.order.way = 'asc';
                  this.order = this.order;
                  break;
                  case 'higherprice' :
                  this.order.field = 'price';
                  this.order.way = 'desc';
                  this.order = this.order;
                  break;
                }
                this.getProducts();
              },

              /* configuar la consulta por rango de precio */
              filter_price: function (min, max) {
                this.price = {
                  from: min,
                  to: max
                };
                this.getProducts();
              },

              /*agrega el producto al carro de compras*/
              addCart: function (item) {
                vue_carting.addItemCart(item.id,item.name,item.price);
              },

            }
        });        

</script>
@stop