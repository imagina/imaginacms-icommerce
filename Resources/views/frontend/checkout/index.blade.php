@extends('layouts.master')

@section('content')
<!-- preloader -->

<div id="content_preloader">
  <div id="preloader"></div>
</div>

<div id="checkout" class="page checkout">

  <div class="container">
    <div class="row">
      <div class="col">

        <h2 class="text-center my-5">{{ trans('icommerce::checkout.title') }}</h2>

      </div>
    </div>

  </div>
  <!-- ======== @Region: #content ======== -->
  <div id="content" class="pb-5">
    <div class="container">
      <div v-if="quantity > 0">
        <div class="row text-right">
          <div class="col py-2">
            <a class="btn btn-success waves-effect waves-light" href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
          </div>
        </div>
        <form id="checkoutForm" method="POST" url="{{url('/checkout')}}">
          <div class="currency">
            <input v-if="currency" type="hidden" name="currency_id" :value="currency.id">
            <input v-if="currency" type="hidden" name="currency_code" :value="currency.code">
            <input v-if="currency" type="hidden" name="currency_value" :value="currency.value">
          </div>
          <div class="row">

            <div class="col-12 col-md-6 col-lg-4">
              @includeFirst(['icommerce.checkout.customer','icommerce::frontend.checkout.customer'])

            </div>
            <div class="col-12 col-md-6 col-lg-4">
              @includeFirst(['icommerce.checkout.billing_details','icommerce::frontend.checkout.billing_details'])
              @includeFirst(['icommerce.checkout.delivery_details','icommerce::frontend.checkout.delivery_details'])

            </div>
            <div class="col-12 col-md-12 col-lg-4">

              @includeFirst(['icommerce.checkout.shipping_methods','icommerce::frontend.checkout.shipping_methods'])
              @includeFirst(['icommerce.checkout.payment','icommerce::frontend.checkout.payment'])
              @includeFirst(['icommerce.checkout.order_summary','icommerce::frontend.checkout.order_summary'])

            </div>

          </div>
          {{ csrf_field() }}
        </form>
        <div class="row text-right">
          <div class="col py-2">
            <a class="btn btn-success" href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
          </div>
        </div>
      </div>
      <div v-else class="row">
        <div class="alert alert-primary" role="alert">
          {{ trans('icommerce::checkout.no_products_1') }}
          <a href="{{ url('/') }}" class="alert-link">
            {{ trans('icommerce::checkout.no_products_here') }}
          </a>
          {{ trans('icommerce::checkout.no_products_2') }}
        </div>


      </div>
    </div>
  </div>
  <style type="text/css">

  label.error {
    color: red;
    background: transparent;
    border-color: #ebccd1;
    padding: 1px 12px;
  }

  input.error, select.error {
    color: #a94442;
    background: transparent;
    border-color: #a94442;
  }

  .shippingMethods .card-header:after {
    font-family: 'FontAwesome';
    content: "\f106";
    float: right;
  }

  .shippingMethods .card-header.collapsed:after {
    /* symbol for "collapsed" panels */
    content: "\f107";
  }
  </style>
</div>
@stop
@section('scripts')


@parent

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.5/js/mdb.min.js"></script>
<script type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<!--<script src="https://lifemedical.imaginacolombia.com/modules/icommerce/js/json/index.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/v-mask/dist/v-mask.min.js"></script>
<script type="text/javascript">
Vue.use(VueMask.VueMaskPlugin);
</script>

  <script type="text/javascript">
  var checkout = new Vue({
    el: '#content',
    created: function () {
      this.$nextTick(function () {
        this.getCurrency();
        this.getPaymentMethods();
        this.getShippingMethods();
        this.userId=0;
        this.userId= {!! $currentUser ? $currentUser->id : 0 !!};
        if(this.userId!=0){
          let token="Bearer "+"{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
          axios.get("{{url('/')}}"+"/api/profile/v1/users/"+this.userId,{
            params:{
              filter:{

              },
              include:'addresses'
            },headers:{
              'Authorization':token
            }
          }).then(response=> {
            this.user=response.data.data;
            this.addresses=response.data.data.addresses;
          }).catch(error=> {
          });
        }
        let _this=this;
        setTimeout(function(){
          _this.getCart();
         }, 3000);
        if(this.user){
          if(this.addresses.length==0){
            checkout.useExistingOrNewPaymentAddress=2;
          }
        }//if user auth
        if(this.shippingMethods.length>0)
        this.shipping_name=this.shippingMethods[0].name;
        axios.get('{{url('/api/ilocations/allmincountries')}}')
          .then(function (response) {
            if (response.status == 200) {
              checkout.countries = response.data;
            }
          });
        /*** TIME OUT TO CLOSE THE PRELOADER GIFT ***/
        setTimeout(function () {
          $('#content_preloader').fadeOut(1000, function () {
            $('#checkout').animate({'opacity': 1}, 500);
          });
        }, 1800);
      });

    },
    data: {
      //Vars
      cart:[],
      currency: "",
      payments: [],
      shippingMethods: [],
      user: null,
      paymentSelected: "",
      billingData: {
        firstname: '',
        lastname: '',
        company: '',
        address_1: '',
        address_2: '',
        city: '',
        cityIndex: null,
        city_id:null,
        postcode: '',
        country: null,
        countryIndex:null,
        zone: null,
        zoneIndex:null,
        email:'',
        nit:''
      },
      shippingData: {
        firstname: '',
        lastname: '',
        company: '',
        address_1: '',
        address_2: '',
        city: '',
        postcode: '',
        country: '',
        zone: '',
      },
      addresses: [],
      quantity: 0,
      subTotal: 0,
      selectAddresses:[],
      shipping: 0,
      discount: 0.0,
      orderTotal: 0,
      coupon_code:null,
      newUser:{
        name:'',
        lastName:'',
        email:'',
        owner_cellphone:'',
        password:'',
        password_confirmation:''
      },
      email:'',
      password:'',
      customerType: {!! $currentUser ? 2 : 1 !!},
      tokenUser:null,
      shipping_name:'',
      shipping_method: '',
      shipping_amount: 0,
      guestOrCustomer1: true,
      sameDeliveryBilling: true,
      weight: 0,
      countries: [],
      cities:[],
      tax: false,
      taxValue:{{ isset($tax) ? $tax : 0}},
      taxTotal: 0,
      statesBilling: [],
      statesDelivery: [],
      statesShippingAlternative: false,
      statesBillingAlternative: false,
      statesDeliveryAlternativeValue: '',
      placeOrderButton: false,
      passwordGuest:123456,
      deliveryData: {
        country: ''
      },
      updatingData: false,
      useExistingOrNewPaymentAddress: '1',
      useExistingOrNewShippingAddress: '1',
      shippingMethodSelected: false,
      selectedBillingAddress: 0,
      selectedShippingAddress: 0,

    },
    computed:{
      calculate_total(){
        var value=0;
        if(checkout.cart){
          for(var i=0;i<checkout.cart.products.length;i++){
            value+=checkout.cart.products[i].priceUnit*checkout.cart.products[i].quantity;
          }
        }
        checkout.orderTotal=value;
      }
    },
    watch: {

    },
    filters: {
      capitalize: function (value) {
        if (!value) return ''
        if (value.toString() == 'ups' || value.toString() == 'usps')
          return value.toString().toUpperCase();
        value = value.toString()
        return value.charAt(0).toUpperCase() + value.slice(1)
      },
      numberFormat: function (value) {
        if (value != ''){
          //return checkout.currency.symbol_left+ " " + (parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')) + " " + checkout.currency.symbol_right;
          if(checkout.currency.symbol_left)
            value=checkout.currency.symbol_left+ " " + (parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
          if(checkout.currency.symbol_right){
            value+=" " + checkout.currency.symbol_right
          }
          return value
        }
        else
          return value;
      }
    },
    methods: {
      getCurrency(){
        axios.get("{{url('/')}}"+"/api/icommerce/v3/currencies/1",{
          params:{
            filter:{
              field:"default_currency"
            }
          }
        })
        .then(response=> {
          this.currency=response.data.data;
        })
        .catch(function (error) {
        });
      },
      getPaymentMethods(){
        axios.get("{{url('/')}}"+"/api/icommerce/v3/payment-methods")
        .then(response=> {
          this.payments=response.data.data;
        })
        .catch(function (error) {
        });
      },
      getShippingMethods(){
        axios.get("{{url('/')}}"+"/api/icommerce/v3/shipping-methods")
        .then(response=> {
          this.shippingMethods=response.data.data;
        })
        .catch(function (error) {
        });
      },
      clearFieldsUser(){
        checkout.newUser.name="";
        checkout.newUser.lastName="";
        checkout.newUser.email="";
        checkout.newUser.owner_cellphone="";
        checkout.newUser.password="";
        checkout.newUser.password_confirmation="";
      },
      registerUser(){
        axios.post("{{url('/')}}"+"/api/profile/v1/auth/register", {
          attributes:{
            first_name:checkout.newUser.name,
            last_name:checkout.newUser.lastName,
            email:checkout.newUser.email,
            password:checkout.newUser.password,
            password_confirmation:checkout.newUser.password_confirmation,
            fields:[
              {
                name:"cellularPhone",
                value:checkout.newUser.owner_cellphone,
              }
            ],
            activated:1,
            roles:['User']
          }

        })
        .then(function (response) {
          toastr.success("Usuario creado exitosamente.");
          checkout.email=checkout.newUser.email;
          checkout.password=checkout.newUser.password;
          checkout.loginUser();
          checkout.clearFieldsUser();
        }).catch(function (error) {
          console.log(error);
          // console.log('error:');
          // console.log(error.response.data);
          let errors=[];
          if('errors' in error.response.data){
            errors=JSON.parse(error.response.data.errors);
            // console.log('errors');
            // console.log(errors);
          }
          for (var i in errors) {
              // alert(errors[i]);
              toastr.error(errors[i]);
          }
        });
      },
      loginUser(){
        axios.post("{{url('/')}}"+"/api/profile/v1/auth/login", {
          username:checkout.email,
          password:checkout.password
        })
        .then(function (response) {
          checkout.user=response.data.data.userData;
          checkout.tokenUser=response.data.data.userToken;
        })
        .catch(function (error) {
          console.log(error);
          if('errors' in error.response.data){
            toastr.error(error.response.data.errors);
          }
        });
      },
      submitOrder(){
        //Validations:
        if(!checkout.cart)
          toastr.error("Debe generar un carrito de compras.");
        else if(checkout.selectedBillingAddress==0)
          toastr.error("Debe seleccionar una dirección.");
        else if(!checkout.paymentSelected)
        toastr.error("Debe seleccionar un método de pago.");
        else if(!checkout.paymentSelected)
        toastr.error("Debe seleccionar un método de pago.");
        else if(checkout.shipping_name=="")
        toastr.error("Debe seleccionar un método de envío.");
        else{
          var user_id=0;
          if(checkout.user)
            user_id=checkout.user.id;
          else
            user_id= {!! Auth::user() ? Auth::user()->id : 0 !!};
          if(user_id<=0)
            toastr.error('Debes estar autenticado');
          else{
            var token="";
            if(checkout.tokenUser)
              token=checkout.tokenUser;
            else
              token="Bearer "+"{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
            checkout.placeOrderButton = true;
            var shippingMethodId=0;
            for(var i=0;i<checkout.shippingMethods.length;i++){
              if(checkout.shippingMethods[i].name==checkout.shipping_name){
                shippingMethodId=checkout.shippingMethods[i].id;
                break;
              }
            }
            var indexAddress=0;
            for(var i=0;i<checkout.user.addresses.length;i++){
              if(checkout.user.addresses[i].id==checkout.selectedBillingAddress){
                indexAddress=i;
                break;
              }
            }
            /*console.log('user addresses');
            console.log(checkout.user.addresses);

            console.log('index addresses');
            console.log(indexAddress);

            console.log(checkout.user.addresses[indexAddress].firstName);*/


            axios.post("{{url('/')}}"+"/api/icommerce/v3/orders", {
              attributes:{
                user_id:user_id,
                cart_id:checkout.cart.id,
                address_payment_id:checkout.selectedBillingAddress,
                payment_first_name:checkout.user.addresses[indexAddress].firstName,
                payment_last_name:checkout.user.addresses[indexAddress].lastName,
                payment_address_1:checkout.user.addresses[indexAddress].address1,
                payment_city:checkout.user.addresses[indexAddress].city,
                payment_zip_code:checkout.user.addresses[indexAddress].zipCode,
                payment_country:checkout.user.addresses[indexAddress].country,


                payment_id:checkout.paymentSelected,
                payment_method_id:checkout.paymentSelected,
                address_shipping_id:checkout.selectedBillingAddress,
                shipping_first_name:checkout.user.addresses[indexAddress].firstName,
                shipping_last_name:checkout.user.addresses[indexAddress].lastName,
                shipping_address_1:checkout.user.addresses[indexAddress].address1,
                shipping_city:checkout.user.addresses[indexAddress].city,
                shipping_zip_code:checkout.user.addresses[indexAddress].zipCode,
                shipping_country:checkout.user.addresses[indexAddress].country,
                coupon_code:null,

                shipping_name:checkout.shipping_name,
                shipping_method:checkout.shipping_name,
                shipping_method_id:shippingMethodId,
                store_id:1,

                options:[]
              }
            },{
              headers:{
                'Authorization':token
              }
            })
            .then(function (response) {
              toastr.success("Tu pedido se ha realizado con éxito, por favor verifica tu correo electrónico.");
              localStorage.clear()
              if(response.data.data.paymentData.redirectRoute){
                window.open(response.data.data.paymentData.redirectRoute)
              }else{
                window.setTimeout(function(){location.reload()},4000)
              }
            })
            .catch(function (error) {
              // console.log(error);
              // alert("Se ha producido un error en el servidor.");
            });
            checkout.placeOrderButton = false;
          }//else
        }//else

      },
      getCart(){
        checkout.cart=vue_carting.cart;
        if(checkout.cart){
          checkout.quantity=checkout.cart.quantity;
        }
      },
      addAddress(type="billing"){
        //Add address to profile
        var user_id=0;
        if(checkout.user)
          user_id=checkout.user.id;
        else
          user_id= {!! Auth::user() ? Auth::user()->id : 0 !!};
        if(user_id<=0)
          toastr.error('Debes estar autenticado');
        else if(checkout.billingData.firstname=="")
          toastr.error("Debe rellenar el campo nombre");
        else if(checkout.billingData.lastname=="")
          toastr.error("Debe rellenar el campo apellido");
        else if(checkout.billingData.company=="")
          toastr.error("Debe rellenar el campo compañia");
        else if(checkout.billingData.address_1=="")
          toastr.error("Debe rellenar el campo de dirección 1");
        else if(checkout.billingData.postcode=="")
          toastr.error("Debe rellenar el campo de código postal");
        else if(!checkout.billingData.countryIndex)
          toastr.error("Debe seleccionar un país");
        else if(!checkout.billingData.zoneIndex)
          toastr.error("Debe seleccionar una provincia");
        else if(!checkout.billingData.city)
          toastr.error("Debe rellenar el campo de ciudad");
        else{
          var token="";
          if(checkout.tokenUser)
            token=checkout.tokenUser;
          else
            token="Bearer "+"{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
          axios.post("{{url('/')}}"+"/api/profile/v1/addresses", {
            attributes:{
              user_id:user_id,
              first_name:checkout.billingData.firstname,
              last_name:checkout.billingData.lastname,
              company:checkout.billingData.company,
              address_1:checkout.billingData.address_1,
              address_2:checkout.billingData.address_2,
              city:checkout.billingData.city,
              zip_code:checkout.billingData.postcode,
              country_id:checkout.countries[checkout.billingData.countryIndex].id,
              country:checkout.billingData.country,
              state:checkout.billingData.zone,
              province_id:checkout.statesBilling[checkout.billingData.zoneIndex].id,
              type:type
            }
          },{
            headers:{
              'Authorization':token
            }
          })
          .then(response => {
            toastr.success("Dirección agregada correctamente.");
            this.billingData.firstname="";
            this.billingData.lastname="";
            this.billingData.company="";
            this.billingData.address_1="";
            this.billingData.address_2="";
            this.billingData.city="";
            this.billingData.postcode="";
            this.user.addresses.push(response.data.data);
            checkout.selectedBillingAddress=response.data.data.id;
            checkout.useExistingOrNewPaymentAddress=1;
          })
          .catch(function (error) {
            console.log(error);
          });
        }

      },
      getProvincesByCountry: function (component) {
        this.billingData.country=this.countries[this.billingData.countryIndex].iso_2;
        axios.get('{{url('/api/ilocations/allprovincesbycountry/iso2')}}' + '/' + this.countries[this.billingData.countryIndex].iso_2)
        .then(response => {
          //data is the JSON string
          if (component == 1) {
            checkout.statesBilling = response.data;
            checkout.statesBillingAlternative = !checkout.statesBilling.length;
          }
          else if (component == 2) {
            checkout.statesDelivery = response.data;
            checkout.statesShippingAlternative = !checkout.statesDelivery.length;
          }
        }).catch(error => {

        });
      },
      getCitiesByProvince(){
        this.billingData.zone=this.statesBilling[this.billingData.zoneIndex].name;
        axios.get('{{url('/api/ilocations/allcitiesbyprovince')}}' + '/' + this.statesBilling[this.billingData.zoneIndex].id)
        .then(response => {
          //data is the JSON string
          this.cities=response.data;
        }).catch(error => {

        });
      },
      deleteProductOfCart(item){
        this.updatingData = true;
        axios.delete("{{url('/')}}"+"/api/icommerce/v3/cart-products/"+item.id)
        .then(function (response) {
          checkout.updatingData = false;
          checkout.getCart();
          vue_carting.getCart();
          return true;
        })
        .catch(function (error) {
          console.log(error);
        });
        return false;
      },

      /** actualiza la cantidad del producto antes de enviarlo */
      update_quantity: function (item, sign) {
        sign === '+' ?
          item.quantity++ :
          item.quantity--;
        checkout.updateCart(item);
      },

      /** actualiza el item del carrito */
      updateCart: function (item) {
        this.updatingData = true;
        axios.put("{{url('/')}}"+"/api/icommerce/v3/cart-products/"+item.id, {
          attributes:{
            cart_id:checkout.cart.id,
            product_id:item.productId,
            product_name:item.name,
            price:item.price,
            quantity:item.quantity
          }
        })
        .then(function (response) {
          checkout.updatingData = false;
          vue_carting.getCart();
          return true;
        })
        .catch(function (error) {
          console.log(error);
        });
        return false;
      },

      /** genera los msjs de alerta success, warning y error*/
      alert: function (menssage, type) {
        toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": 300,
          "hideDuration": 1000,
          "timeOut": 5000,
          "extendedTimeOut": 1000,
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        };

        toastr[type](menssage);
      },
      sanitizeTitle: function(title) {
        var slug = "";
        // Change to lower case
        var titleLower = title.toLowerCase();
        // Letter "e"
        slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
        // Letter "a"
        slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
        // Letter "o"
        slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
        // Letter "u"
        slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
        // Letter "d"
        slug = slug.replace(/đ/gi, 'd');
        // Trim the last whitespace
        slug = slug.replace(/\s*$/g, '');
        // Change whitespace to "-"
        slug = slug.replace(/\s+/g, '-');

        return slug;
      }

    }
  });
  </script>

  @stop
