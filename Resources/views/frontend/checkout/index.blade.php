@extends('layouts.master')

@section('content')
  <!-- preloader -->
  
  
  
  <div id="checkout" class="page checkout">
    
    
    @component('icommerce::frontend.widgets.breadcrumb')
      <li class="breadcrumb-item active" aria-current="page">{{ trans('icommerce::checkout.title') }}</li>
    @endcomponent
    
    
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="text-title text-center mb-5">
            <h1 class="title">{{ trans('icommerce::checkout.title') }}</h1>
          </div>
        </div>
      </div>
    
    </div>
    
    <div v-if="loadingCart" id="content_preloader">
      <div id="preloader"></div>
    </div>
    <!-- ======== @Region: #content ======== -->
    <div id="content" class="pb-5">
      <div class="container">
        
        <div v-if="quantity > 0 && !loadingCart">
          <div class="row">
            <div class="col py-2">
              <a class="btn btn-success waves-effect waves-light"
                 href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
            </div>
          </div>
          
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
          
          <div class="row">
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
  </div>
@stop
@section('scripts')
  
  
  @parent
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script type="text/javascript"
          src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
  <!--<script src="https://lifemedical.imaginacolombia.com/modules/icommerce/js/json/index.js"></script>-->
  <script src="https://cdn.jsdelivr.net/npm/v-mask/dist/v-mask.min.js"></script>
  <script type="text/javascript">
    Vue.use(VueMask.VueMaskPlugin);
  </script>
  
  <script type="text/javascript">
    const {required, requiredIf,minLength} = window.validators
    var checkout = new Vue({
      el: '#checkout',
      created() {
        this.$nextTick(function () {
          this.getCurrency();
          this.getPaymentMethods();
          this.getShippingMethods();
          this.getAddressExtraFields()
          this.userId = 0;
          this.userId = {!! $currentUser ? $currentUser->id : 0 !!};
          if (this.userId != 0) {
            let token = "Bearer " + "{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
            axios.get("{{url('/')}}" + "/api/profile/v1/users/" + this.userId, {
              params: {
                filter: {},
                include: 'addresses'
              }, headers: {
                'Authorization': token
              }
            }).then(response => {
              this.user = response.data.data;
              this.addresses = response.data.data.addresses;
              
              this.form.selectedBillingAddress = this.getDefaultBillingAddress()
              this.form.selectedShippingAddress = this.getDefaultShippingAddress()
              
              
            }).catch(error => {
            });
            
          }
          
          setTimeout(() => {
            this.getCart();
          }, 3000);
          
          if (this.user) {
            if (this.user.addresses.length == 0) {
              this.useExistingOrNewPaymentAddress = 2;
            }
          }//if user auth
          if (this.shippingMethods.length > 0)
            this.shipping_name = this.shippingMethods[0].name;
          
          axios.get('{{url('/api/ilocations/allmincountries')}}', {
            params: {
              filter: {
                allTranslations: true
              }
            }
          })
            .then((response) => {
              if (response.status == 200) {
                this.countries = response.data;
                if (this.shippingData.countryIndex) {
                  this.getProvincesByCountry(this.shippingData.countryIndex,1)
                  this.getProvincesByCountry(this.shippingData.countryIndex,2)
                }
              }
            });
          
        });
        
      },
      validations: {
        form: {
          selectedBillingAddress: {
            required
          },
          selectedShippingAddress: {
            requiredIf: requiredIf(() => {
              return !checkout.sameDeliveryBilling
            })
          },
        },
        billingData: {
          firstname: {required},
          lastname: {required},
          address_1: {required},
          telephone: {required},
          city: {required},
          countryIndex: {required},
          zoneIndex: {required},
        },
        shippingData: {
          firstname: {required},
          lastname: {required},
          address_1: {required},
          telephone: {required},
          city: {required},
          countryIndex: {required},
          zoneIndex: {required},
        }
      },
      data: {
        //Vars
        cart: [],
        currency: "",
        payments: [],
        shippingMethods: [],
        user: null,
        customerLoginToggle: false,
        customerRegisterToggle: true,
        form: {
          selectedBillingAddress: null,
          selectedShippingAddress: null,
          
        },
        loadingCart: true,
        paymentSelected: "",
        billingData: {
          firstname: '',
          lastname: '',
          address_1: '',
          address_2: '',
          city: '',
          cityIndex: null,
          city_id: null,
          telephone: '',
          country: null,
          countryIndex: 'CO',
          zone: null,
          zoneIndex: null,
          nit: '',
          options: {},
          default: true
        },
        shippingData: {
          firstname: '',
          lastname: '',
          address_1: '',
          address_2: '',
          city: '',
          cityIndex: null,
          city_id: null,
          telephone: '',
          country: null,
          countryIndex: 'CO',
          zone: '',
          zoneIndex: null,
          options: {},
          default: true
        },
        addressesExtraFields: [],
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
          password_confirmation:'',
          confirmPolytics: false
        },
        email:'',
        password:'',
        customerType: {!! $currentUser ? 2 : 1 !!},
        customerRegisterToggle: true,
        customerLoginToggle: false,
        tokenUser:null,
        shipping_name:'',
        shipping_title:'',
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
        passwordGuest: 123456,
        deliveryData: {
          country: ''
        },
        updatingData: false,
        useExistingOrNewPaymentAddress: 1,
        useExistingOrNewShippingAddress: 1,
        shippingMethodSelected: false,
        selectedBillingAddress: 0,
        selectedShippingAddress: 0,
        registeringUser: false
      },
      computed: {
        calculate_total() {
          var value = 0;
          if (this.cart) {
            for (var i = 0; i < this.cart.products.length; i++) {
              value += this.cart.products[i].priceUnit * this.cart.products[i].quantity;
            }
          }
          this.orderTotal = value;
        },
        shippingTitle() {
          if (this.shipping_name && this.shippingMethods.length > 0) {
            this.shipping_title = this.shippingMethods.length.find(item => name == this.shipping_name)
          }
        },
        billingAddress(){
          return this.addresses.find(address => address.id == this.form.selectedBillingAddress)
        },
        shippingAddress(){
          return this.addresses.find(address => address.id == this.form.selectedShippingAddress)
        }
      },
      watch: {
        'form.shippingName' (value) {
          let name = this.shippingMethods.find(item => item.name == value)
          this.form.shippingTitle = name.title
          
        },
        user() {
          
          if (this.user && Array.isArray(this.user.addresses) && this.user.addresses.length == 0) {
            this.useExistingOrNewPaymentAddress = 2
            this.prefillAddress()
          }
        },
        customerRegisterToggle(newVal) {
          
          if (newVal) {
            this.customerLoginToggle = false
            $("#collapseOne").collapse('show');
            $("#collapseTwo").collapse('hide');
          } else {
            this.customerLoginToggle = true
            $("#collapseOne").collapse('hide');
            $("#collapseTwo").collapse('show');
          }
        },
        customerLoginToggle(newVal) {
          
          if (newVal) {
            this.customerRegisterToggle = false
            $("#collapseTwo").collapse('show');
            $("#collapseOne").collapse('hide');
          } else {
            this.customerRegisterToggle = true
            $("#collapseTwo").collapse('hide');
            $("#collapseOne").collapse('show');
          }
        }
      },
      filters: {
        capitalize (value) {
          if (!value) return ''
          if (value.toString() == 'ups' || value.toString() == 'usps')
            return value.toString().toUpperCase();
          value = value.toString()
          return value.charAt(0).toUpperCase() + value.slice(1)
        },
        numberFormat (value) {
          if (value != '') {
            //return this.currency.symbol_left+ " " + (parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')) + " " + this.currency.symbol_right;
            if (checkout.currency.symbol_left)
              value = checkout.currency.symbol_left + " " + (parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
            if (checkout.currency.symbol_right) {
              value += " " + this.currency.symbol_right
            }
            return value
          }
          else
            return value;
        }
      },
      methods: {
        
        getCurrency() {
          axios.get("{{url('/')}}" + "/api/icommerce/v3/currencies/1", {
            params: {
              filter: {
                field: "default_currency"
              }
            }
          })
            .then(response => {
              this.currency = response.data.data;
            })
            .catch((error) => {
            });
        },
        
        getPaymentMethods() {
          axios.get("{{url('/')}}" + '/api/icommerce/v3/payment-methods?&filter={"status":1}')
            .then(response => {
              this.payments = response.data.data;
              if (this.payments && Array.isArray(this.payments) && this.payments.length > 0) {
                this.paymentSelected = this.payments[0].id
              }
            })
            .catch((error) =>{
            });
        },
        
        getShippingMethods() {
          axios.get("{{url('/')}}" + '/api/icommerce/v3/shipping-methods?&filter={"status":1}')
            .then(response => {
              this.shippingMethods = response.data.data;
              
              if (this.shippingMethods && Array.isArray(this.shippingMethods) && this.shippingMethods.length > 0) {
                this.shipping_name = this.shippingMethods[0].name
              }
            })
            .catch((error) => {
            });
        },
        
        clearFieldsUser() {
          this.newUser.name = "";
          this.newUser.lastName = "";
          this.newUser.email = "";
          this.newUser.owner_cellphone = "";
          this.newUser.password = "";
          this.newUser.password_confirmation = "";
        },
        
        registerUser() {
          this.registeringUser = true;
          axios.post("{{url('/')}}" + "/api/profile/v1/users/register", {
            attributes: {
              first_name: this.newUser.name,
              last_name: this.newUser.lastName,
              email: this.newUser.email,
              password: this.newUser.password,
              password_confirmation: this.newUser.password_confirmation,
              fields: [
                {
                  name: "cellularPhone",
                  value: this.newUser.owner_cellphone,
                },
                {
                  name: "confirmPolytics",
                  value: this.newUser.confirmPolytics,
                }
              ],
              activated: 1,
              roles: ['User']
            }
            
          })
            .then( (response) => {
              toastr.success("Usuario creado exitosamente.");
              this.email = this.newUser.email;
              this.password = this.newUser.password;
              this.loginUser();
              this.clearFieldsUser();
              this.registeringUser = true;
            })
            .catch( (error) => {
              let errors = [];
              if ('errors' in error.response.data) {
                errors = JSON.parse(error.response.data.errors);
                
              }
              for (var i in errors) {
                // alert(errors[i]);
                toastr.error(errors[i]);
              }
              this.registeringUser = true;
            });
        },
        
        loginUser() {
          axios.post("{{url('/')}}" + "/api/profile/v1/auth/login", {
            username: this.email,
            password: this.password
          })
            .then( (response) => {
              this.user = response.data.data.userData;
              this.tokenUser = response.data.data.userToken;
            })
            .catch((error) => {
              
              if ('errors' in error.response.data) {
                toastr.error(error.response.data.errors);
              }
            });
        },
        
        submitOrder() {
          
          this.$v.form.$reset()
          this.$v.form.$touch()
          
          
          if(this.useExistingOrNewShippingAddress == '2'){
            toastr.error('Por favor agrega una dirección de envío para la orden');
            return;
          }
          if(this.useExistingOrNewPaymentAddress == '2'){
            toastr.error('Por favor agrega una dirección de facturación para la orden');
            return;
          }
          if (this.$v.form.$error) {
            toastr.error('Por favor completa los campos obligatorios');
            return;
          }
          
          //Validations:
          var user_id = 0;
          if (this.user)
            user_id = this.user.id;
          else
            user_id = {!! Auth::user() ? Auth::user()->id : 0 !!};
          
          if (!user_id) {
            toastr.error('Debes estar autenticado');
            return false;
          }
          if (!this.cart)
            toastr.error("Debe generar un carrito de compras.");
          else if (!this.paymentSelected)
            toastr.error("Debe seleccionar un método de pago.");
          else if (!this.paymentSelected)
            toastr.error("Debe seleccionar un método de pago.");
          else if (this.shipping_name == "")
            toastr.error("Debe seleccionar un método de envío.");
          else {
            this.placeOrderButton = true;
            var token = "";
            if (this.tokenUser)
              token = this.tokenUser;
            else
              token = "Bearer " + "{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
            
            var shippingMethodId = 0;
            for (var i = 0; i < this.shippingMethods.length; i++) {
              if (this.shippingMethods[i].name == this.shipping_name) {
                shippingMethodId = this.shippingMethods[i].id;
                break;
              }
            }
            
            let addressBilling =  this.user.addresses.find(address => address.id == this.form.selectedBillingAddress)
            let addressShipping =  this.user.addresses.find(address => address.id == this.form.selectedShippingAddress)
            
            if(this.sameDeliveryBilling)
              addressShipping = addressBilling
            
            
            axios.post("{{url('/')}}" + "/api/icommerce/v3/orders", {
              attributes: {
                customer_id: user_id,
                cart_id: this.cart.id,
                address_payment_id: this.selectedBillingAddress,
                payment_first_name: addressBilling.firstName,
                payment_last_name: addressBilling.lastName,
                payment_address_1: addressBilling.address1,
                payment_city: addressBilling.city,
                payment_zone: addressBilling.state,
                payment_country: addressBilling.country,
                payment_id: this.paymentSelected,
                payment_method_id: this.paymentSelected,
                address_shipping_id: this.selectedBillingAddress,
                shipping_first_name: addressShipping.firstName,
                shipping_last_name: addressShipping.lastName,
                shipping_address_1: addressShipping.address1,
                shipping_city: addressShipping.city,
                shipping_zone: addressShipping.state,
                shipping_country_code: addressShipping.country,
                coupon_code: null,
                telephone: addressShipping.telephone,
                shipping_name: this.shipping_name,
                shipping_method: this.shipping_name,
                shipping_method_id: shippingMethodId,
                store_id: 1,
                options: {
                  shippingAddress: addressBilling.options || null,
                  billingAddress: addressShipping.options || null,
                }
              }
            }, {
              headers: {
                'Authorization': token
              }
            })
              .then((response) => {
                
                var data = response.data.data
                toastr.success("Tu pedido se ha realizado con éxito, por favor verifica tu correo electrónico.");
                localStorage.clear()
                if (data.paymentData.redirectRoute) {
                  window.open(data.paymentData.redirectRoute)
                }
                window.setTimeout(() => {
                  window.location.replace("{{url('')}}" + '/orders/' + data.id)
                }, 5000)
                this.placeOrderButton = false;
              })
              .catch((error) => {
                // console.log(error);
                this.placeOrderButton = false;
                // alert("Se ha producido un error en el servidor.");
              });
            
            
          }//else
          
        },
        
        getCart() {
          
          var cart_id = localStorage.getItem("cart_id");
          
          if(!cart_id){
            var carts = JSON.parse(localStorage.getItem("carts"));
            if(carts && this.user){
              var cart = carts.find(cart => cart.userId == this.user.id)
              if(cart)
                cart_id = cart.cart_id
            }else
            if(carts && !this.user){
              var cart = carts.find(cart => cart.userId == 0)
              if(cart)
                cart_id = cart.cart_id
            }
          }
          
          if (cart_id) {
            axios.get("{{url('/')}}" + "/api/icommerce/v3/carts/" + cart_id)
              .then((response) => {
                this.cart = response.data.data;
                //vue_carting.articles = vue_carting.cart.products;
                this.quantity = this.cart.quantity;
                
                this.loadingCart = false
              })
              .catch(error => {
                this.loadingCart = false
              });
          } else {
            this.cart = []
            this.loadingCart = false
          }
          
          
        },
        
        prefillAddress() {
          this.billingData.firstname = this.shippingData.firstname = this.user.firstName
          this.billingData.lastname = this.shippingData.lastname = this.user.lastName
          this.billingData.lastname = this.shippingData.lastname = this.user.lastName
          if (this.user.fields) {
            let cellularPhone = this.user.fields.find(field => field.name = "cellularPhone")
            if (cellularPhone) {
              this.billingData.telephone = this.shippingData.telephone = cellularPhone.value
            }
          }
        },
        
        addAddress(type = "billing") {
          
          //Add address to profile
          if (type == "billing") {
            this.$v.billingData.$reset()
            this.$v.billingData.$touch()
            
            if (this.$v.billingData.$error) {
              toastr.error('Por favor completa los campos obligatorios');
              return;
            }
            
            var data = this.billingData;
          } else {
            this.$v.shippingData.$reset()
            this.$v.shippingData.$touch()
            
            if (this.$v.shippingData.$error) {
              toastr.error('Por favor completa los campos obligatorios');
              return;
            }
            var data = this.shippingData;
          }
          
          var user_id = 0;
          if (this.user)
            user_id = this.user.id;
          else
            user_id = {!! Auth::user() ? Auth::user()->id : 0 !!};
          
          if (user_id <= 0) {
            toastr.error('Debes estar autenticado');
            return;
          }
          
          
          var token = "";
          if (this.tokenUser)
            token = this.tokenUser;
          else
            token = "Bearer " + "{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
          
          
          axios.post("{{url('/')}}" + "/api/profile/v1/addresses", {
            attributes: {
              user_id: user_id,
              first_name: data.firstname,
              last_name: data.lastname,
              address_1: data.address_1,
              address_2: data.address_2,
              city: data.city,
              options: data.options,
              country: data.countryIndex,
              telephone: data.telephone,
              state: data.zoneIndex,
              default: data.default,
              type: type
            }
          }, {
            headers: {
              'Authorization': token
            }
          })
            .then(response => {
              toastr.success("Dirección agregada correctamente.");
              if (type == "billing") {
                this.billingData.firstname = "";
                this.billingData.lastname = "";
                this.billingData.address_1 = "";
                this.billingData.address_2 = "";
                this.billingData.telephone = "";
                this.billingData.city = "";
                this.form.selectedBillingAddress = response.data.data.id;
                this.useExistingOrNewPaymentAddress = 1;
              } else {
                this.shippingData.firstname = "";
                this.shippingData.lastname = "";
                this.shippingData.address_1 = "";
                this.shippingData.address_2 = "";
                this.shippingData.telephone = "";
                this.shippingData.city = "";
                this.form.selectedShippingAddress = response.data.data.id;
                this.useExistingOrNewShippingAddress = 1;
              }
              
              this.user.addresses.push(response.data.data);
              
              if(type == 'billing'){
                this.$v.billingData.$reset()
                this.getDefaultBillingAddress()
              }else{
                this.$v.shippingData.$reset()
                this.getDefaultShippingAddress()
              }
              
              
              
            })
            .catch((error) => {
              console.log(error);
            });
          
        },
        
        getAddressExtraFields() {
          
          this.loading = true
          let uriSettings = icommerce.url + '/api/isite/v1/settings/iprofile';
          
          axios.get(uriSettings, {params: {}}).then(response => {
            
            let data = response.data.data;
            this.addressesExtraFields = data.find(item => item.name == "iprofile::userAddressesExtraFields")
            
            if (this.addressesExtraFields && Array.isArray(this.addressesExtraFields.value) && this.addressesExtraFields.value.length) {
              this.addressesExtraFields.value.forEach(item => {
                this.billingData.options[item.field] = null
              })
              
            }
            
            this.loading = false
            
          })
            .catch(error => {
              this.loading = false
            })
        },
        
        getProvincesByCountry(countryCode,component) {
          
          axios.get('{{url('/api/ilocations/allprovincesbycountry/iso2')}}' + '/' +countryCode)
            .then(response => {
              //data is the JSON string
              if (component == 1) {
                this.statesBilling = response.data;
                this.statesBillingAlternative = !this.statesBilling.length;
              }
              else if (component == 2) {
                this.statesDelivery = response.data;
                this.statesShippingAlternative = !this.statesDelivery.length;
              }
            }).catch(error => {
            
          });
        },
        
        getCitiesByProvince() {
          this.billingData.zone = this.statesBilling[this.billingData.zoneIndex].name;
          axios.get('{{url('/api/ilocations/allcitiesbyprovince')}}' + '/' + this.statesBilling[this.billingData.zoneIndex].id)
            .then(response => {
              //data is the JSON string
              this.cities = response.data;
            }).catch(error => {
            
          });
          
        },
        
        deleteProductOfCart(item) {
          this.updatingData = true;
          axios.delete("{{url('/')}}" + "/api/icommerce/v3/cart-products/" + item.id)
            .then((response) => {
              this.updatingData = false;
              console.warn("PRODUCT DELETED", response)
              vue_carting.getCart();
              this.getCart();
              return true;
            })
            .catch((error) => {
              console.log(error);
            });
          return false;
        },
        
        /** actualiza la cantidad del producto antes de enviarlo */
        update_quantity(item, sign) {
          
          let quantityAux = item.quantity
          sign === '+' ?
            item.quantity++ :
            item.quantity--;
          
          if (item.quantity > 0)
            this.updateCart(item);
          else {
            
            toastr.error("la Cantidad no puede ser cero(0)");
            item.quantity = quantityAux
          }
        },
        
        /** actualiza el item del carrito */
        updateCart(item) {
          this.updatingData = true;
          axios.put("{{url('/')}}" + "/api/icommerce/v3/cart-products/" + item.id, {
            attributes: {
              cart_id: this.cart.id,
              product_id: item.productId,
              product_name: item.name,
              price: item.price,
              quantity: item.quantity
            }
          })
            .then( (response) =>{
              this.updatingData = false;
              vue_carting.getCart();
              return true;
            })
            .catch((error) => {
            
            });
          return false;
        },
        
        /** genera los msjs de alerta success, warning y error*/
        alert(menssage, type) {
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
        
        sanitizeTitle(title) {
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
        },
        
        status(validation) {
          return {
            error: validation.$error,
            dirty: validation.$dirty
          }
        },
        
        
        
        getDefaultBillingAddress(){
          
          let address = null
          if (this.user) {
            if (this.user.addresses && this.user.addresses.length > 0) {
              let defaultBillingAddress = this.user.addresses.find(address => address.default && address.type == "billing")
              
              if(defaultBillingAddress){
                address = defaultBillingAddress.id
              }else{
                address = this.user.addresses[0].id
              }
            }
          }//if user auth
          return address
        },
        
        getDefaultShippingAddress(){
          
          let address = null
          if (this.user) {
            if (this.user.addresses && this.user.addresses.length > 0) {
              let defaultShippingAddress = this.user.addresses.find(address => address.default && address.type == "shipping")
              if(defaultShippingAddress){
                address = defaultShippingAddress.id
              }else{
                address = this.user.addresses[0].id
              }
            }
          }//if user auth
          return address
        }
      }
    });
  </script>

@stop
