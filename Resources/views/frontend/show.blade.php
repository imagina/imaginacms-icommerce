@extends('layouts.master')
@include('icommerce::frontend.partials.carting')
@section('content')

    <!-- preloader -->
    <div id="content_preloader"><div id="preloader"></div></div>

    <div id="content_show_commerce"
         class="page"
         data-icontenttype="page"
         style="opacity: 0"
         data-icontentid="3">

        <!-- ===== PAGINATE ====== -->
        <div class="iblock general-block31" data-blocksrc="general.block31">
            <div class="container">
                <div class="row">
                    <div class="col">

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-4 text-uppercase">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item" v-for="category in breadcrumb">
                                    <a v-bind:href="category.url">
                                        @{{ category.title }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">
                                        @{{ product.title }}
                                </li>
                            </ol>
                        </nav>

                    </div>
                </div>
            </div>
        </div>

        <!-- ==== CONTENT ==== -->
        <div class="iblock general-block32" data-blocksrc="general.block32">

            <div class="container">
                <div class="row">

                    <!-- photo and gallery -->
                    <div class="col-sm-12 col-md-5 pb-4">
                        <div class="pb-5">
                            <div class="carousel-product">
                                <div class="zoom-product">
                                    <div class="big-img">
                                        <div class="background_image"
                                             :style="'background-image: url('+product.mainimage+')'">
                                        </div>
                                    </div>
                                </div>

                                <div id="owl-carousel-product" class="owl-carousel">
                                    <div class="owl-item">
                                        <img v-bind:src="product.mainimage" alt="">
                                    </div>
                                    <!--
                                    <div class="owl-item" v-for="(img,index) in product_gallery">
                                        <img v-bind:src="product_gallery[index]" alt="">
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>

                        <div class="pb-5">
                            {!!ibanner(3,'ibanners::frontend.base')!!}
                        </div>
                    </div>

                    <!-- dates -->
                    <div class="col-sm-12 col-md-7">
                        <!-- title -->
                        <h1>
                            @{{ product.title }}
                            <!-- SKU -->
                            <br>
                            <small class="text-danger font-weight-bold" style="font-size: 15px">
                                SKU#: @{{ product.sku }}
                            </small>
                        </h1>

                        <!-- word -->
                        <h6>
                            <small>
                                <a
                                        href="#tabp3"
                                        aria-controls="tabp3"
                                        aria-selected="false">
                                    BE THE FIRST TO REVIEW THIS PRODUCT
                                </a>
                            </small>
                        </h6>

                        <!-- STARTS -->
                        <span style="font-size: 12px">
                            <i class="fa fa-star pr-1"
                               v-bind:class="[product.rating >= star ? 'text-warning' : 'text-muted']"
                               v-for="(star,key) in 5"></i>
                        </span>

                        <div class="row align-items-center pt-2">
                            <!-- price -->
                            <div class="col-md-4 price mr-5" v-if="products_children === false">
                                <h4 class="font-weight-bold mb-1">
                                    <del class="text-muted pr-2"
                                         v-if="product.price_discount"
                                         style="font-size: 14px">
                                        @{{ currency.symbol_left }} @{{ product.price }} @{{ currency.symbol_right }}
                                    </del>
                                    <span class="text-danger font-weight-bold"
                                          v-if="!product.price_discount">
                                        @{{ currency.symbol_left }} @{{ product.price }} @{{ currency.symbol_right }}
                                    </span>
                                    <span class="text-danger font-weight-bold"
                                          v-if="product.price_discount">
                                        @{{ currency.symbol_left }} @{{ product.price_discount }} @{{ currency.symbol_right }}
                                    </span>
                                </h4>
                            </div>

                            <div v-if="product.pdf" class="col pdf">
                                <a v-bind:href="product.pdf"
                                   class="btn btn-outline-light text-dark">
                                    <img class="img-fluid p-2 pr-3"
                                         src="{{ Theme::url('img/pdf.png') }}">
                                    Product Brochure
                                </a>
                            </div>
                        </div>

                        <div class="w-100"></div>

                        <div class="py-3" v-if="!products_children">

                            <div class="input-group mb-3 w-25 float-left pr-2">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-primary"
                                            type="button"
                                            field="quantity"
                                            v-on:click="quantity >= 2 ? quantity-- : false">
                                        -
                                    </button>
                                </div>
                                <input type="text"
                                       class="form-control border-primary text-center"
                                       name="quantity"
                                       v-model="quantity"
                                       aria-label=""
                                       aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary"
                                            type="button"
                                            field="quantity"
                                            v-on:click="quantity < product.quantity ? quantity++ : false">
                                        +
                                    </button>
                                </div>
                            </div>

                            <a class="btn btn-outline-primary text-primary"
                               v-on:click="addWishList(product)">
                                <i class="fa fa-heart">
                                </i>
                            </a>
                        </div>

                        <div class="py-3" v-if="!products_children">
                            <button class="btn btn-danger text-white addToCar w-30"
                                    v-on:click="addCart(product)" v-show="!sending_data">
                                <i class="fa fa-shopping-cart pr-3"></i>
                                Add to cart
                            </button>
                            <button class="btn btn-danger text-white w-30" v-show="sending_data">
                                <div class="fa-1x"><i class="fa fa-spinner fa-pulse"></i> Sending</div>
                            </button>
                        </div>

                        <!-- Sub products -->
                        <table id="table_children"
                               class="table table-responsive mb-0 cart-table w-100"
                               v-if="products_children != false">
                            <thead>
                            <tr>
                                <th class="text-center w-15"></th>
                                <th class="text-center w-35">Product</th>
                                <th class="text-center w-10">Sku</th>
                                <th class="text-center w-15">Unit Price</th>
                                <th class="text-center w-10">Quantity</th>
                                <th class="w-15 text-md-right">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Children Product -->
                            <tr v-for="(sub,index) in products_children" v-bind:class="[sub.id == product.id ? 'subproduct-active' : '']">
                                <!-- image -->
                                <td class="text-center">
                                    <a v-bind:href="sub.url">
                                        <img class="cart-img img-fluid"
                                             v-bind:src="sub.mainimage"
                                             style="height: 70px"
                                             v-bind:alt="sub.title">
                                    </a>
                                </td>
                                <!-- title -->
                                <td >
                                    <span >
                                        <a :class="[sub.id != product.id ? 'text-dark' : '']" v-bind:href="sub.url">
                                            <h5>
                                                @{{ sub.title }}
                                            </h5>
                                        </a>
                                    </span>
                                </td>
                                <!-- sku -->
                                <td class="text-center" style="font-size: 14px">
                                    <span class="font-weight-bold">
                                        <a>@{{ sub.sku }}</a>
                                    </span>
                                </td>
                                <!-- price -->
                                <td class="text-center align-middle" style="font-size: 14px">
                                    $ @{{ sub.price }}
                                </td>
                                <!-- quantity -->
                                <td style="font-size: 14px">
                                    <div class="input-group" >
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-primary"
                                                    type="button"
                                                    field="quantity"
                                                    v-on:click="check_children(index,'-',sub)"
                                                    style="padding: 4px">
                                                -
                                            </button>
                                        </div>
                                        <input type="text"
                                               class="form-control border-primary text-center"
                                               name="quantity"
                                               v-model="sub.quantity_cart"
                                               value="0"
                                               aria-describedby="basic-addon1"
                                               style="font-size: 12px; padding: 6px">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary"
                                                    type="button"
                                                    field="quantity"
                                                    v-on:click="check_children(index,'+',sub)"
                                                    style="padding: 4px">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-md-right"
                                    style="font-size: 14px">
                                    <span class="font-weight-bold">
                                        @{{ currency.symbol_left }}
                                        <span class="price_children">
                                            @{{ parseFloat(parseFloat(sub.price.replace(',', '')) * sub.quantity_cart).toFixed(2) }}
                                        </span>
                                        @{{ currency.symbol_right }}
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="py-3 mb-3" v-if="products_children != false">
                            <button class="btn btn-danger text-white w-30"
                                    v-on:click="addCart()" v-show="!sending_data" >
                                <i class="fa fa-shopping-cart pr-3"></i>
                                Add to cart
                            </button>

                            <button class="btn btn-danger text-white w-30" v-show="sending_data" >
                                <div class="fa-1x"><i class="fa fa-spinner fa-pulse"></i> Sending</div>
                            </button>
                        </div>

                        <div class="py-2 mt-3">
                            <a onclick="window.open('http://www.facebook.com/sharer.php?u=' + vue_show_commerce.product.url,'Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+'')"
                               class="btn btn-outline-dark btn-sm mb-2">
                                <i class="fa fa-facebook"></i>
                                SHARE
                            </a>
                            <a onclick="window.open('http://twitter.com/share?url=' + vue_show_commerce.product.url,'Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+'')"
                               class="btn btn-outline-dark btn-sm mb-2">
                                <i class="fa fa-twitter"></i>
                                TWEET
                            </a>
                            <a onclick="window.open('https://plus.google.com/share?url=' + vue_show_commerce.product.url,'Google plus','width=585,height=666,left='+(screen.availWidth/2-292)+',top='+(screen.availHeight/2-333)+'')"
                               class="btn btn-outline-dark btn-sm mb-2">
                                <i class="fa fa-google-plus"></i>
                                SHARE
                            </a>
                            <a href="" class="btn btn-outline-dark btn-sm mb-2">
                                <i class="fa fa-print"></i>
                                PRINT
                            </a>
                        </div>

                        <div class="py-3">
                            <img class="img-fluid pr-4 mb-3"
                                 src="{{ Theme::url('img/paypal.png') }}">
                            <img class="img-fluid mb-3"
                                 src="{{ Theme::url('img/paypal-credit.png') }}">
                        </div>

                        <div class="row border border-right-0 border-left-0 my-4 mx-1">
                            <div class="col-auto">
                                <div class="media  py-4">
                                    <img class="align-self-center mr-3"
                                         src="{{ Theme::url('img/car.png') }}">
                                    <div class="media-body text-left">
                                        <p class="m-0">1-3 BUSINESS DAYS<br>
                                            AVERAGE DELIVERY</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="media py-4">
                                    <img class="align-self-center mr-3"
                                         src="{{ Theme::url('img/save.png') }}">
                                    <div class="media-body text-left">
                                        <p class="m-0">SAFE & SECURE<br>
                                            SHOPPING</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="media py-4">
                                    <img class="align-self-center mr-3"
                                         src="{{ Theme::url('img/day.png') }}">
                                    <div class="media-body text-left">
                                        <p class="m-0">SAFE & SECURE<br>
                                            SHOPPING</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>

                    </div>

                    <div class="w-100"></div>

                    <div class="pt-5 pb-3 w-100">

                        <ul class="nav nav-tabs bg-light w-100"
                            id="myTab"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link border-0 rounded-0 active"
                                   id="tabp1"
                                   data-toggle="tab"
                                   href="#details"
                                   role="tab"
                                   aria-controls="details"
                                   aria-selected="true">
                                    DETAILS
                                </a>
                            </li>
                            {{--<li class="nav-item">
                                <a class="nav-link border-0 rounded-0"
                                   id="tabp2"
                                   data-toggle="tab"
                                   href="#shipping"
                                   role="tab"
                                   aria-controls="shipping"
                                   aria-selected="false">
                                    SHIPPING INFO
                                </a>
                            </li>--}}
                            <li class="nav-item">
                                <a class="nav-link border-0 rounded-0"
                                   id="tabp3"
                                   data-toggle="tab"
                                   href="#reviews"
                                   role="tab"
                                   aria-controls="reviews"
                                   aria-selected="false">
                                    REVIEWS (@{{ count_comments }})
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content w-100" id="myTabContent">
                            <div class="tab-pane py-4 px-2 fade show active"
                                 id="details"
                                 role="tabpanel"
                                 aria-labelledby="tabp1">
                                <div v-html="product.description"></div>
                            </div>
                            {{--<div class="tab-pane py-4 px-2 fade"
                                 id="shipping"
                                 role="tabpanel"
                                 aria-labelledby="tabp2">
                                <p class="text-justify">
                                    This strong tether, made from 1-inch tubular web with a built-in
                                    bungee, works as a “live bait” water rescue attachment to your PFD.
                                    As a connection between a PFD and a line, the tether enhances
                                    attachment options in rescue situations. Comes with brite
                                    double-locking connector. Rated strength: 11 kN (2,473 lbf)
                                </p>
                            </div>--}}
                            <div class="tab-pane py-4 px-2 fade"
                                 id="reviews"
                                 role="tabpanel"
                                 aria-labelledby="tabp3">

                                <div class="fb-comments"
                                     v-bind:data-href="product.url"
                                     data-numposts="5"
                                     data-width="100%">

                                </div>

                                <div id="fb-root"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        @include('icommerce.widgets.related_products')

    </div>

    <style>
        .subproduct-active {
            background-color: #0F4A5B;
            color: white;
        }

        .subproduct-active td span a {
            color: white;
        }

        .subproduct-active td span a:hover {
            color: #25858a;
        }
    </style>
@stop

@section('scripts')
    @parent
    {!!Theme::script('js/app.js?v='.config('app.version'))!!}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.5/js/mdb.min.js"></script>

    <script type="text/javascript">
        const vue_show_commerce = new Vue({
            el: '#content_show_commerce',
            created: function () {
                this.$nextTick(function () {
                    this.get_product();
                    this.get_wishlist();

                    setTimeout(function () {
                        $('#content_preloader').fadeOut(1000, function () {
                            $('#content_show_commerce').animate({'opacity': 1}, 500);
                        });
                    }, 1800);
                });
            },
            data: {
                path: '{{ route('icommerce.api.product',[$product->id]) }}',
                product: '',
                product_gallery: [],
                products_children: false,
                products_children_cart: [],
                related_products: false,
                quantity: 1,
                currency: '',
                /*wishlist*/
                products_wishlist: [],
                user: {!! $user !!},
                product_comments: [],
                count_comments: 0,
                product_parent: false,
                products_brother: false,
                /*breadcrumb*/
                breadcrumb: [],
                sending_data: false
            },
            methods: {
                /* obtiene los productos */
                get_product: function(){
                    axios({
                        method: 'Get',
                        responseType: 'json',
                        url: this.path
                    }).then(function(response){
                        vue_show_commerce.product = response.data.product[0];
                        vue_show_commerce.product_gallery = response.data.product[0].gallery;
                        vue_show_commerce.related_products = response.data.related_products;
                        vue_show_commerce.currency = response.data.currency;
                        vue_show_commerce.product_comments = response.data.product_comments;
                        vue_show_commerce.count_comments = response.data.count_comments;
                        vue_show_commerce.products_children = response.data.products_children;
                        vue_show_commerce.breadcrumb = response.data.breadcrumb;
                    });
                },

                /*change quantity, product children*/
                check_children: function(tr,operation,product){
                    (operation === '+') ?
                        product.quantity_cart < parseInt(product.quantity) ?
                            product.quantity_cart++ :
                            this.alerta("{{trans('icommerce::products.alerts.no_more')}}", "warning")
                        :
                        false;
                    (operation === '-')  ?
                        (product.quantity_cart >= 1) ?
                            product.quantity_cart-- :
                            this.alerta("{{trans('icommerce::products.alerts.no_zero')}}", "warning")
                        :
                        false;

                    this.save_product_children(product.quantity_cart,product);
                },

                /*save/update/delete product for add to cart*/
                save_product_children: function(quantity, product) {
                    var products = this.products_children_cart;
                    var pos = -1;

                    if(products.length >= 1) ;{
                        $.each(products, function (index, item) {
                            item.id === product.id ? pos = index : false;
                        });
                    }

                    if (parseInt(quantity)) { //add/update item
                        //product['quantity_cart'] = quantity;

                        pos >= 0 ?
                            this.products_children_cart[pos] = product :
                            this.products_children_cart.push(product);

                    }else if(!parseInt(quantity) && pos !== -1){//delete item
                        this.products_children_cart.splice(pos,1);
                    }
                },

                /*agrega el producto al carro de compras*/
                addCart: function (data) {
                    if(data){
                        data['quantity_cart'] = this.quantity;
                        data = [data];
                    }else{
                        data = this.products_children_cart;
                    }
                    vue_show_commerce.sending_data = true;

                    axios.post('{{ url("api/icommerce/add_cart") }}', data).then(function(response){
                        if(response.data.status){
                            vue_show_commerce.alerta("{{trans('icommerce::products.alerts.add_cart')}}", "success");
                            vue_show_commerce.quantity = 1;
                            vue_carting.get_articles();
                        }else{
                            vue_show_commerce.alerta(
                                "{{trans('icommerce::products.alerts.no_add_cart')}}",
                                "error");
                        }
                        vue_show_commerce.sending_data = false;
                    });
                },

                /* products wishlist */
                get_wishlist: function () {
                    if (this.user) {
                        axios({
                            method: 'get',
                            responseType: 'json',
                            url: '{{ route("icommerce.api.wishlist.user") }}?id='+this.user
                        }).then(function(response) {
                            vue_show_commerce.products_wishlist = response.data;
                        })
                    }
                },

                /* product add wishlist */
                addWishList: function (item) {
                    if (this.user) {
                        if (!this.check_wisht_list(item.id)) {
                            var data = {
                                user_id: this.user,
                                product_id: item.id
                            };

                            axios.post('{{ route("icommerce.api.wishlist.add") }}', data).then(function(response){
                                vue_show_commerce.get_wishlist();
                                vue_show_commerce.alerta("{{trans('icommerce::wishlists.alerts.add')}}", "success");
                            })
                        }else{
                            this.alerta("{{trans('icommerce::wishlists.alerts.product_in_wishlist')}}", "warning");
                        }
                    }
                    else {
                        this.alerta("{{trans('icommerce::wishlists.alerts.must_login')}}", "warning");
                    }
                },

                /*check if exist product in wisthlist*/
                check_wisht_list: function(id){
                    var list = this.products_wishlist;
                    var response = false;

                    $.each(list,function(index,item){
                        id === item.id ? response = true : false;
                    });

                    return response;
                },

                /*get comments of product*/
                get_comments: function () {
                    axios({
                        method: 'Get',
                        responseType: 'json',
                        url: this.path
                    }).then(function(response){
                        vue_show_commerce.product_comments = response.data.product_comments;
                        vue_show_commerce.count_comments = response.data.count_comments;
                    });
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
                }
            }
        });
    </script>

    <script type="text/javascript">
        $('.zoom-product').zoom({
            magnify: 1
        });

        var owla = $("#owl-carousel-product");
        owla.owlCarousel({
            items: 4,
            slideSpeed: 250,
            rewindSpeed: 350,
            margin: 1,
            responsiveClass: true,
            dots: true,
            nav:false
        });

        function main_imgbig() {
            var img = $('#owl-carousel-product .owl-item').find('img');
            var e = img.attr('src');
            var carousel = img.closest(".carousel-product");

            carousel.children('.zoom-product').trigger('zoom-product.destroy');
            carousel.children('.zoom-product').zoom({ url: e });
            carousel.find(".zoom-product .big-img img").attr("src",e);
        }

        main_imgbig();


        $("#owl-carousel-product .owl-item img").bind("click touchstart", function () {
            var e = $(this).attr("src");
            var carousel = $(this).closest(".carousel-product");

            carousel.children('.zoom-product').trigger('zoom-product.destroy');
            carousel.children('.zoom-product').zoom({ url: e });
            carousel.find(".zoom-product .big-img img").attr("src",e);
        });
    </script>

    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@stop

