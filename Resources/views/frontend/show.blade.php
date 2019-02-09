@extends('layouts.master')

@section('meta')
    <meta name="title"
          content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}">
    <meta name="keywords" content="{!!isset($product->options->meta_keyword) ? $product->options->meta_keyword : ''!!}">
    <meta name="description"
          content="{!!isset($product->options->meta_description) ? $product->options->meta_description : $product->summary!!}">
    <meta name="robots"
          content="{{isset($product->options->meta_robots)?$product->options->meta_robots : 'INDEX,FOLLOW'}}">
    <!-- Schema.org para Google+ -->
    <meta itemprop="name"
          content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}">
    <meta itemprop="description"
          content="{!!isset($product->options->meta_description) ? $product->options->meta_description : $product->summary !!}">
    <meta itemprop="image"
          content=" {{url($product->options->mainimage ?? 'modules/icommerce/img/product/default.jpg') }}">
    <!-- Open Graph para Facebook-->
    <meta property="og:title"
          content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{url($product->slug)}}"/>
    <meta property="og:image"
          content="{{url($product->options->mainimage ?? 'modules/icommerce/img/product/default.jpg')}}"/>
    <meta property="og:description"
          content="{!!isset($product->options->meta_description) ? $product->options->meta_description : $product->summary !!}"/>
    <meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
    <meta property="og:locale" content="{{config('asgard.iblog.config.oglocal')}}">
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
    <meta name="twitter:title"
          content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}">
    <meta name="twitter:description"
          content="{!!isset($product->options->meta_description) ? $product->options->meta_description : $product->summary !!}">
    <meta name="twitter:creator" content="">
    <meta name="twitter:image:src"
          content="{{url($product->options->mainimage ?? 'modules/icommerce/img/product/default.jpg')}}">

@stop

@section('title')
    {{ $product->title }} | @parent
@stop

@section('content')

    <div id="content_preloader" class="mt-4">
        <div id="preloader"></div>
    </div>

    <div id="content_show_commerce"
         class="page bg-white"
         data-icontenttype="page"
         data-icontentid="3">

        <!-- MIGA DE PAN  -->
        <div class="iblock general-block21" data-blocksrc="general.block21">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-4 mb-0 text-uppercase bg-white">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/') }}">
                                        Inicio
                                    </a>
                                </li>
                                <li class="breadcrumb-item" v-for="category in breadcrumb">
                                    <a v-bind:href="category.url">
                                        @{{ category.title }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">
                                    {{$product->title}}
                                </li>

                            </ol>
                            <hr class="mt-0">
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div id="content">
            <div class="container">
                <div class="row">

                    <!-- IMAGE PRODUCTO-->
                    <div class="col-md-5 pb-4">
                        <div class="carousel-product">
                            <div class="zoom-product">
                                <div class="big-img">
                                    <img class="img-fluid w-100"
                                         v-bind:src="product.mainimage"
                                         style="max-height: 480px">
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- DESCRIPTION PRODUCT -->
                    <div class="col-sm-12 col-md-7">
                        <!-- STARTS -->
                        <div>
                            <span class="rating">
                                <i class="fa fa-star pr-1"
                                   v-bind:class="[product.rating >= star ? 'text-secondary' : 'text-muted']"
                                   v-for="(star,key) in 5"></i>
                            </span>
                        </div>

                        <!-- TITLE -->
                        <h1 class="text-capitalize text-primary title-product">
                            {{$product->title}}
                            <br>
                            <small class="text-danger font-weight-bold" style="font-size: 15px">
                                Referencia: {{$product->reference??$product->sku }}
                            </small>
                        </h1>
                        <hr>

                        <!-- SUMMARY -->
                        <div class="text-muted text-justify"
                             v-html="product.summary"
                             style="font-size: 18px">
                            {{ $product->summary }}
                        </div>
                        <hr>
                        <!-- MANUFACTURER -->
                        @if($product->manufacturer_id!=null)
                        <div class="text-muted text-justify"
                             style="font-size: 18px">
                            @php
                                $locale = LaravelLocalization::setLocale() ?: App::getLocale();
                            @endphp
                            <strong>{{trans('icommerce::products.table.manufacturer')}}:</strong> <a
                                    href="{{route($locale . 'icommerce.manufacturers.details',[$product->manufacturer->id])}}"> {{$product->manufacturer->name?? '' }}</a>
                        </div>
                        <hr>
                        @endif
                        <div class="row">
                            <div class="col pdf">
                                @if(isset($product->options->certificate) && !empty($product->options->certificate))
                                    <a href="{{url($product->options->certificate)}}" target="_blank"
                                       class="btn btn-outline-light text-dark">
                                        <img class="img-fluid p-2 pr-3"
                                             src="{{ Theme::url('img/pdf.png') }}">
                                        {{trans('icommerce::products.table.certificate')}}
                                    </a>
                                @endif
                                @if(isset($product->options->datasheet) && !empty($product->options->datasheet))
                                    <a href="{{url($product->options->datasheet)}}" target="_blank"
                                       class="btn btn-outline-light text-dark">
                                        <img class="img-fluid p-2 pr-3"
                                             src="{{ Theme::url('img/pdf.png') }}">
                                        {{trans('icommerce::products.table.data_sheet')}}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <!-- PRICE -->
                        <div class="row align-items-center pt-2 border-bottom" v-if="product.unformatted_price > 0">
                            <div class="col-12 col-md-3 price mr-5">
                                <h4 class="text-primary font-weight-bold">
                                    @{{currencysymbolleft}} @{{ product.price_updated }}
                                </h4>
                            </div>
                        </div>


                        <!-- BUTTON QUANTITY -->
                        <div class="row py-3 px-0 col-12" style="height: 97px">
                          {{--<div class="col-md-6">
                            <h6 class="text-primary font-weight-bold">
                                {{trans('icommerce::products.table.quantity')}}:
                            </h6>
                            <div class="input-group mb-3  float-left pr-2">
                                <div class="input-group-prepend">
                                    <button class="btn btn-primary rounded-0"
                                            type="button"
                                            field="quantity"
                                            v-on:click="quantity >= 2 ? quantity-- : false">-
                                    </button>
                                </div>
                                <input type="text"
                                       class="form-control border-primary text-center"
                                       name="quantity"
                                       v-model="quantity"
                                       aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button class="btn btn-primary rounded-0"
                                            type="button"
                                            field="quantity"
                                            v-on:click="quantity < product.quantity ? quantity++ : false">+
                                    </button>
                                </div>
                            </div>
                          </div>--}}
                          <!-- options -->
                          <div class="options">
                            <div v-if="product.options.length>0 && option.option_values.length>0" v-for="(option,index) in product.options">
                              <h6 class="text-primary font-weight-bold text-uppercase mb-1">
                                @{{option.description}}
                              </h6>
                              <div class="d-inline-block" v-for="(value,indexOptValue) in option.option_values">
                                <div class="custom-control custom-radio mb-2">
                                  <input v-if="option.type!='checkbox'" type="radio" :name="option.description" :value="value.id" @change="update_product(index,indexOptValue)" :id="value.id" class="custom-control-input">
                                  <input v-else type="checkbox" :name="value.description" :value="value.id" :id="value.id" data-toggle="collapse" :data-target="'#'+value.description"  @change="update_product(index,indexOptValue)" class="custom-control-input">
                                  <label class="custom-control-label" v-bind:class="[ (value.type=='text') ? 'ml-2 mr-2' : '']" :for="value.id">
                                    <span v-if="value.type=='background' || value.type=='image'" v-bind:style="{ backgroundColor: value.option.background, backgroundImage: 'url(' + value.option.image + ')' }">
                                      &nbsp;
                                    </span>
                                    <label v-else>@{{value.description}}</label>
                                  </label>
                                </div>
                              </div>
                              <!-- OPTIONS CHILDS v2-->
                                <div :id="value.description" role="tabpanel" v-for="(value,indexOptValue) in option.option_values" v-if="value.children_option_values.length>0" class="collapse" >
                                  <h6 class="text-primary font-weight-bold text-uppercase mb-1">
                                    (@{{value.description}}) @{{value.child_option_description}}
                                  </h6>
                                  <div class="d-inline-block custom-control custom-radio mb-2" v-for="(child_option,indexChildOptValue) in value.children_option_values">
                                    <input type="radio" :name="value.description" :value="value.description+'-'+child_option.id" @change="update_product(index,indexOptValue,indexChildOptValue)" :id="value.description+'-'+child_option.id" class="custom-control-input">
                                    <label class="custom-control-label" :for="value.description+'-'+child_option.id">
                                      <span class="text-capitalize" v-if="child_option.type=='text'">
                                        @{{child_option.description}}
                                      </span>
                                      <span v-else-if="child_option.type=='image'" >
                                        <img :src="child_option.option.image" alt="">
                                        <!-- <img :src="child_option.option.image" alt=""> -->
                                      </span>
                                      <span v-else-if="child_option.type=='background'" v-bind:style="{ backgroundColor: child_option.option.background, backgroundImage: 'url(' + child_option.option.background + ')' }">
                                        &nbsp;
                                      </span>
                                    </label>
                                  </div>
                                </div>
                              <!-- OPTIONS CHILDS v2-->
                            </div>
                          </div>
                          <!-- options -->

                        </div>

                        <!-- BUTTONS -->
                        <div class="pt-3 px-0 col-12 font-weight-bold">
                            <!-- ADD TO CART -->
                            <button class="btn border-primary
                                           text-primary p-2
                                           bg-white rounded-0
                                           font-weight-bold"
                                    v-on:click="addCart(product)">
                                <i class="fa fa-shopping-cart pr-2"></i>
                                {{trans('icommerce::products.alerts.add')}}
                            </button>


                            <!-- ADD TO FAVORITE -->
                            <button class="btn btn-secondary
                                           text-primary rounded-0
                                           font-weight-bold p-2 ml-2"
                                    v-on:click="addWishList(product)" title="Añadir a la lista de deseo">
                                <i class="fa fa-heart"></i>
                                <span class=" pl-2 d-none d-lg-inline-block">{{trans('icommerce::products.alerts.add_to_wish_list')}}</span>
                            </button>
                        </div>

                        <!-- SOCIAL NETWORK -->

                        {{--<div class="btns-share">
                            @include('icommerce.partials.share-page')
                        </div>--}}
                    </div>

                    <!-- DESCRIPTION PRODUCT -->
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="parallelogram bg-secondary" style="width:200px ">
                                    <h3 class="text-primary text-uppercase">
                                        {{trans('icommerce::products.table.description')}}
                                    </h3>
                                </div>
                            </div>


                            <div v-html="product.description"
                                 class="py-3 text-muted ml-6 col-12"
                                 style="font-size: 18px">
                                {!! $product->description!!}
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <!-- RELATED PRODUCTS-->
    @include('icommerce::frontend.widgets.products_feature')

    <!-- CATEGORIES -->
    {{--@include('icommerce.widgets.categoryProducts')--}}

    <!-- BANNER FERIAS -->
        {{--@include('icommerce.partials.feria')--}}
    </div>
@stop

@section('scripts')
    @parent

    <script type="text/javascript">
        /********* VUE ***********/
        var vue_show_commerce = new Vue({
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
                sending_data: false,
                currencysymbolleft: icommerce.currencySymbolLeft,
                currencysymbolright: icommerce.currencySymbolRight,
                //New variables
                index_option_selected:0,
                index_option_value_selected:0,
                options_selected:[],
                //New variables
                index_product_option_value_selected:"select",
                index_child_product_option_value_selected:0,
                id_product_option_value_selected:0,
                option_type:null,
                option_value:''
            },
            filters: {
                numberFormat: function (value) {
                    return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                }
            },
            methods: {
              /* actualizar precio de producto */
              calculate_price(){
                //If you do not have options selected children take the price of the option value.
                //If you have selected children options, it does not take the price of the option value but of the children.
                var total=parseFloat(this.product.unformatted_price);
                for(var i=0;i<this.options_selected.length;i++){
                  for(o=0;o<this.options_selected[i].option_values.length;o++){
                    //If you do not have values ​​of selected children options, take the price of the option value
                    if(this.options_selected[i].option_values[o].child_options.length>0){
                      for(var z=0;z<this.options_selected[i].option_values[o].child_options.length;z++){
                        if(parseFloat(this.options_selected[i].option_values[o].child_options[z].price)>0){
                          //If the price is> 0, if it is 0 nothing happens.
                          if(this.options_selected[i].option_values[o].price_prefix=="+")
                          total=parseFloat(total)+parseFloat(this.options_selected[i].option_values[o].child_options[z].price);
                          else
                          total=parseFloat(total)-parseFloat(this.options_selected[i].option_values[o].child_options[z].price);
                        }// if price > 0
                      }//for child options
                    }else{
                      if(parseFloat(this.options_selected[i].option_values[o].price)>0){
                        //If the price is> 0, if it is 0 nothing happens
                        if(this.options_selected[i].option_values[o].price_prefix=="+")
                        total=parseFloat(total)+parseFloat(this.options_selected[i].option_values[o].price);
                        else
                        total=parseFloat(total)-parseFloat(this.options_selected[i].option_values[o].price);
                      }// if price > 0
                    }
                  }//for option values
                }//for
                this.product.price=total;
              },
              update_product(indexOption,indexOptionValue,indexChildOptValue=null){
                this.index_option_selected=indexOption;
                this.index_option_value_selected=indexOptionValue;
                //console.log('IndexOpt, IndexOptValue','indexChildOptValue',indexOption,indexOptionValue,indexChildOptValue);
                var b_option=0;//Exist option in array
                var position_option=null;
                var position_option_value=null;
                var b_option_value=0;//Exist option value in array

                var position_child_option_value=null;
                var b_child_option_value=0;
                //Options
                var option_id=this.product.options[indexOption].option_id;
                var option_type=this.product.options[indexOption].type;
                var product_option_id=this.product.options[indexOption].product_option_id;
                var option_description=this.product.options[indexOption].description;
                //Option value
                var option_value_id=this.product.options[indexOption].option_values[indexOptionValue].id;
                var price_prefix=this.product.options[indexOption].option_values[indexOptionValue].price_prefix;
                var price=parseFloat(this.product.options[indexOption].option_values[indexOptionValue].price);
                var product_option_value_id=this.product.options[indexOption].option_values[indexOptionValue].product_option_value_id;
                var option_value_description=this.product.options[indexOption].option_values[indexOptionValue].description;
                //Child Option Value
                if(indexChildOptValue!=null){
                  var child_option_value_id=this.product.options[indexOption].option_values[indexOptionValue].children_option_values[indexChildOptValue].id;
                  var child_price_prefix=this.product.options[indexOption].option_values[indexOptionValue].children_option_values[indexChildOptValue].price_prefix;
                  var child_price=parseFloat(this.product.options[indexOption].option_values[indexOptionValue].children_option_values[indexChildOptValue].price);
                  var child_option_description=this.product.options[indexOption].option_values[indexOptionValue].children_option_values[indexChildOptValue].option_description;
                  var child_option_value_description=this.product.options[indexOption].option_values[indexOptionValue].children_option_values[indexChildOptValue].description;
                }//index child option value
                for(i=0;i<this.options_selected.length;i++){
                  if(this.options_selected[i].id==option_id){
                    //Exist options in array
                    b_option=1;
                    position_option=i;
                    for(o=0;o<this.options_selected[i].option_values.length;o++){
                      if(this.options_selected[i].option_values[o].id==option_value_id){
                        b_option_value=1;
                        position_option_value=o;
                        for(var z=0;z<this.options_selected[i].option_values[o].child_options.length;z++){
                          if(child_option_value_id==this.options_selected[i].option_values[o].child_options[z].id){
                            b_child_option_value=1;
                            position_child_option_value=z;
                          }//if
                        }//child options
                        break;
                      }
                    }//for option values
                  }//exist option id
                }//for options
                if(option_type=="checkbox"){
                  //Multiple option values selected
                  if(b_option==1 && b_option_value==1 && indexChildOptValue==null){
                    /*
                    If there is the option and the option value in the array
                      removes it from it.
                    */
                    this.options_selected[position_option].option_values.splice(position_option_value,1);
                    //Validate if option_Values ​​has no records, also remove the option.
                    if(this.options_selected[position_option].option_values.length==0){
                      this.options_selected.splice(position_option,1);
                    }
                    this.index_option_selected=0;
                    this.index_option_value_selected=0;
                  }else{
                    if(b_option==1 && b_option_value==1 && indexChildOptValue!=null){
                      /*
                        There is the option and option value, so only add the child option
                      */
                      this.options_selected[position_option].option_values[position_option_value].child_options=[];
                      this.options_selected[position_option].option_values[position_option_value].child_options.push({
                        id:child_option_value_id,
                        price_prefix:child_price_prefix,
                        price:child_price,
                        option_description:child_option_description,
                        description:child_option_value_description
                      });
                    }else if(b_option==1){
                      /*
                        If the option exists but not the option value, just add the option value
                      */
                      this.options_selected[position_option].option_values.push({
                        id:option_value_id,
                        description:option_value_description,
                        product_option_value_id:product_option_value_id,
                        price:price,
                        price_prefix:price_prefix,
                        child_options:[]
                      });
                      if(indexChildOptValue!=null){
                        var position=this.options_selected[position_option].option_values.length;
                        position--;
                        this.options_selected[position_option].option_values[position].child_options.push({
                          id:child_option_value_id,
                          price_prefix:child_price_prefix,
                          price:child_price,
                          option_description:child_option_description,
                          description:child_option_value_description
                        });
                      }//if child option selected
                    }else{
                      /*
                      If it does not exist in the array, add the option and then its option value
                      */
                      this.options_selected.push({
                        id:option_id,
                        type:option_type,
                        description:option_description,
                        option_values:[]
                      });
                      var position=this.options_selected.length;
                      position--;
                      this.options_selected[position].option_values.push({
                        id:option_value_id,
                        description:option_value_description,
                        product_option_value_id:product_option_value_id,
                        price:price,
                        price_prefix:price_prefix,
                        child_options:[]
                      });
                      if(indexChildOptValue!=null){
                        console.log('Si no existe el option,lo agrega y posterior agrega el option value y su child option');
                        var position2=this.options_selected[position].option_values.length;
                        position2--;
                        this.options_selected[position_option].option_values[position2].child_options.push({
                          id:child_option_value_id,
                          price_prefix:child_price_prefix,
                          price:child_price,
                          option_description:child_option_description,
                          description:child_option_value_description
                        });
                      }//if child option selected
                    }
                  }//else
                }else{
                  /*Option type != checkbox
                  One option value each option selected.
                  */
                  for(i=0;i<this.options_selected.length;i++){
                    if(this.options_selected[i].id==option_id){
                      //Exist options in array
                      b_option=1;
                      this.options_selected[i].option_values=[];//Clear
                      this.options_selected[i].option_values.push({
                        id:option_value_id,
                        description:option_value_description,
                        product_option_value_id:product_option_value_id,
                        price:price,
                        price_prefix:price_prefix,
                        child_options:[]
                      });
                      if(indexChildOptValue!=null){
                        var position2=this.options_selected[i].option_values.length;
                        position2--;
                        this.options_selected[i].option_values[position2].child_options.push({
                          id:child_option_value_id,
                          price_prefix:child_price_prefix,
                          price:child_price,
                          option_description:child_option_description,
                          description:child_option_value_description
                        });
                      }//if child option selected
                      break;
                    }//exist option id
                  }//for options
                  if(b_option==0){
                    //Add option
                    this.options_selected.push({
                      id:option_id,
                      type:option_type,
                      description:option_description,
                      option_values:[]
                    });
                    var position=this.options_selected.length;
                    position--;
                    this.options_selected[position].option_values.push({
                      id:option_value_id,
                      description:option_value_description,
                      product_option_value_id:product_option_value_id,
                      price:price,
                      price_prefix:price_prefix,
                      child_options:[]
                    });
                    if(indexChildOptValue!=null){
                      var position2=this.options_selected[position].option_values.length;
                      position2--;
                      this.options_selected[i].option_values[position2].child_options.push({
                        id:child_option_value_id,
                        price_prefix:child_price_prefix,
                        price:child_price,
                        option_description:child_option_description,
                        description:child_option_value_description
                      });
                    }//if child option selected
                  }//b_option==0
                }//Option type != checkbox
                this.calculate_price();
                this.product.options_selected=this.options_selected;
              },
                /* obtiene los productos */
                get_product: function () {
                    axios({
                        method: 'Get',
                        responseType: 'json',
                        url: this.path
                    }).then(function (response) {

                        vue_show_commerce.product = response.data.product[0];
                        vue_show_commerce.product.price_updated = response.data.product[0].unformatted_price;
                        vue_show_commerce.product_gallery = response.data.product[0].gallery;
                        vue_show_commerce.related_products = response.data.related_products;
                        vue_show_commerce.currency = response.data.currency;
                        vue_show_commerce.product_comments = response.data.product_comments;
                        vue_show_commerce.count_comments = response.data.count_comments;
                        vue_show_commerce.products_children = response.data.products_children;
                        vue_show_commerce.breadcrumb = response.data.breadcrumb;
                        vue_show_commerce.categories = response.data.categories;
                    });
                },

                /*change quantity, product children*/
                check_children: function (tr, operation, product) {
                    (operation === '+') ?
                        product.quantity_cart < parseInt(product.quantity) ?
                            product.quantity_cart++ :
                            this.alerta("{{trans('icommerce::products.alerts.no_more')}}", "warning")
                        :
                        false;
                    (operation === '-') ?
                        (product.quantity_cart >= 1) ?
                            product.quantity_cart-- :
                            this.alerta("{{trans('icommerce::products.alerts.no_zero')}}", "warning")
                        :
                        false;

                    this.save_product_children(product.quantity_cart, product);
                },

                /*save/update/delete product for add to cart*/
                save_product_children: function (quantity, product) {
                    var products = this.products_children_cart;
                    var pos = -1;

                    if (products.length >= 1) ;
                    {
                        $.each(products, function (index, item) {
                            item.id === product.id ? pos = index : false;
                        });
                    }

                    if (parseInt(quantity)) { //add/update item
                        //product['quantity_cart'] = quantity;

                        pos >= 0 ?
                            this.products_children_cart[pos] = product :
                            this.products_children_cart.push(product);

                    } else if (!parseInt(quantity) && pos !== -1) {//delete item
                        this.products_children_cart.splice(pos, 1);
                    }
                },

                /*agrega el producto al carro de compras*/
                addCart: function (data) {
                    if (data) {
                        data.unformatted_price=data.price_updated;
                        data['quantity_cart'] = this.quantity;
                        data = [data];
                    } else {
                        data = this.products_children_cart;
                    }
                    vue_show_commerce.sending_data = true;

                    axios.post('{{ url("api/icommerce/add_cart") }}', data).then(function (response) {
                        if (response.data.status) {
                            vue_show_commerce.alerta("{{trans('icommerce::products.alerts.add_cart')}}", "success");
                            vue_show_commerce.quantity = 1;
                            vue_carting.get_articles();
                        } else {
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
                            url: '{{ route("icommerce.api.wishlist.user") }}?id=' + this.user
                        }).then(function (response) {
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

                            axios.post('{{ route("icommerce.api.wishlist.add") }}', data).then(function (response) {
                                vue_show_commerce.get_wishlist();
                                vue_show_commerce.alerta("{{trans('icommerce::wishlists.alerts.add')}}", "success");
                            })
                        } else {
                            this.alerta("{{trans('icommerce::wishlists.alerts.product_in_wishlist')}}", "warning");
                        }
                    }
                    else {
                        this.alerta("{{trans('icommerce::wishlists.alerts.must_login')}}", "warning");
                    }
                },

                /*check if exist product in wisthlist*/
                check_wisht_list: function (id) {
                    var list = this.products_wishlist;
                    var response = false;

                    $.each(list, function (index, item) {
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
                    }).then(function (response) {
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
            nav: false
        });

        function main_imgbig() {
            var img = $('#owl-carousel-product .owl-item').find('img');
            var e = img.attr('src');
            var carousel = img.closest(".carousel-product");

            carousel.children('.zoom-product').trigger('zoom-product.destroy');
            carousel.children('.zoom-product').zoom({url: e});
            carousel.find(".zoom-product .big-img img").attr("src", e);
        }

        main_imgbig();


        $("#owl-carousel-product .owl-item img").bind("click touchstart", function () {
            var e = $(this).attr("src");
            var carousel = $(this).closest(".carousel-product");

            carousel.children('.zoom-product').trigger('zoom-product.destroy');
            carousel.children('.zoom-product').zoom({url: e});
            carousel.find(".zoom-product .big-img img").attr("src", e);
        });
    </script>

    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    @include('icommerce::frontend.partials.schema_product')
@stop
