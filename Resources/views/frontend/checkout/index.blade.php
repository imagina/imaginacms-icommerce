@extends('layouts.master')
@include('icommerce::frontend.partials.carting')
@section('content')
  <!-- preloader -->
  <div id="content_preloader">
    <div id="preloader"></div>
  </div>
  
  <div id="checkout" class="checkout">
    
    <div class="container">
      <div class="row">
        <div class="col">
          
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-4 text-uppercase">
              <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
          </nav>
          
          <h2 class="text-center mt-0 mb-5">{{ trans('icommerce::checkout.title') }}</h2>
        
        </div>
      </div>
    
    </div>
    <!-- ======== @Region: #content ======== -->
    <div id="content" class="pb-5">
      <div class="container">
        <div v-if="quantity > 0">
          <div class="row text-right">
            <div class="col py-2">
              <a class="btn btn-success" href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
            </div>
          </div>
          <form id="checkoutForm" method="POST" url="{{url('/checkout')}}">
            <div class="currency">
              <input type="hidden" name="currency_id" value="{{$currency->id}}">
              <input type="hidden" name="currency_code" value="{{$currency->code}}">
              <input type="hidden" name="currency_value" value="{{$currency->value}}">
            </div>
            <div class="row">
              <div class="col-12 col-md-6 col-lg-4">
                @include('icommerce::frontend.checkout.customer')
              
              </div>
              <div class="col-12 col-md-6 col-lg-4">
                @include('icommerce::frontend.checkout.billing_details')
                @include('icommerce::frontend.checkout.delivery_details')
              </div>
              <div class="col-12 col-md-12 col-lg-4">
                @include('icommerce::frontend.checkout.shipping_methods')
                @include('icommerce::frontend.checkout.payment')
                @include('icommerce::frontend.checkout.order_summary')
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
        color: #a94442;
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
  {!!Theme::script('js/app.js?v='.config('app.version'))!!}
  <!--<script src="https://lifemedical.imaginacolombia.com/modules/icommerce/js/json/index.js"></script>-->
  <script type="text/javascript">
    
    $(document).ready(function () {
      $('#checkoutForm').change(function (e) {
        if ('localStorage' in window && window['localStorage'] !== null) {
          if ($(e.target).attr("type") == "checkbox") {
            var key = $(e.target).prop("id")
            var val = $(e.target).prop("checked");
            localStorage.setItem(key, val);
          }
          else {
            var type = $(e.target).attr("type");
            if (type != "radio" && type != "password") {
              var key = $(e.target).prop("id")
              var val = $(e.target).val();
              localStorage.setItem(key, val);
            }
          }
        }
      });
      $("#expandBillingDetails").hide();
      $("input[name=sameDeliveryBilling]:checked").change(function () {
        if (!$(this).prop('checked')) {
          $(".showBilling").hide();
          $("#expandBillingDetails").show();
        } else {
          $(".showBilling").show();
          $("#expandBillingDetails").hide();
        }
      })
      $("#expandBillingDetails").click(function (e) {
        e.preventDefault();
        $(".showBilling").show();
        $("#expandBillingDetails").hide();
      })
      
      
      $("#checkoutForm").validate({
        ignore: false,
        
        rules: {
          
          /* Campos para Nuevo Cliente*/
          first_name: {required: true},
          last_name: {required: true},
          email: {required: true, email: true},
          telephone: {required: true, minlength: 2, maxlength: 15},
          //password: {required: "#guestOrCustomer1:checked", minlength: 6},
          //password_confirmation: {required: "#guestOrCustomer1:checked", minlength: 6, equalTo: "#password"},
          
          /*Billing Details*/
          payment_address_1: {required: true},
          payment_city: {required: true},
          payment_country: {required: true},
          payment_postcode: {required: true},
          
          
          /*Delivery Details*/
          shipping_firstname: {required: billing_address},
          shipping_lastname: {required: billing_address},
          shipping_address_1: {required: billing_address},
          shipping_city: {required: billing_address},
          shipping_country: {required: billing_address},
          shipping_postcode: {required: billing_address},
          
          
          /*Shipping Methods*/
          shipping_method: {required: true},
          
          /*Payment Methods*/
          payment_method: {required: true},
        },
        errorPlacement: function (error, element) {
          if (element.is(":radio")) {
            if (element[0].name == "shipping_method")
              error.insertAfter($("#shipping_method"));
            else
              error.insertAfter(element.parent().parent().parent().parent());
          }
          else { // This is the default behavior of the script for all fields
            error.insertAfter(element);
          }
        },
        messages: {
          first_name: "{{ trans('icommerce::checkout.messages.first_name') }}",
          last_name: "{{ trans('icommerce::checkout.messages.last_name') }}",
          email: "{{ trans('icommerce::checkout.messages.email') }}",
          telephone: "{{ trans('icommerce::checkout.messages.telephone') }}",
          shipping_method: "{{ trans('icommerce::checkout.messages.shipping_method') }}",
          payment_method: "{{ trans('icommerce::checkout.messages.payment_method') }}",
        },
      });
      
      
      function billing_address() {
        return !$('#sameDeliveryBilling').prop("checked");
      }
      
      
    })
  
  
  </script>
  <script type="text/javascript">
    var checkout = new Vue({
      el: '#content',
      created: function () {
        this.$nextTick(function () {
          
          /*** UPDATE sub, realsub and total ***/
          this.updateTotal(this.items);
          
          /*** SET DEFAULT COUNTRY VALUE FROM SETTING ICOMMERCE MODULE ***/
          checkout.shippingData.country = checkout.defaultCountry;
          checkout.billingData.country = checkout.defaultCountry;
          
          /*** GET DATA FROM API COUNTRIES AND SET TO LOCALSTORAGE ***/
          if ('localStorage' in window && window['localStorage'] !== null) {
            if (localStorage.getItem("countries")) {
              
              checkout.countries = JSON.parse(localStorage.getItem("countries"));
              console.log("get countries of localstorage");
            } else {
              
              axios.get('https://ecommerce.imagina.com.co/api/ilocations/allmincountries')
                .then(function (response) {
                  if (response.status == 200) {
                    checkout.countries = response.data;
                    localStorage.setItem("countries", JSON.stringify(response.data));
                    console.log("created countries localstorage");
                  }
                });
            }
            
          } else {
            
            axios.get('https://ecommerce.imagina.com.co/api/ilocations/allmincountries')
              .then(function (response) {
                if (response.status == 200) {
                  checkout.countries = response.data;
                }
              });
            
          }
          
          /*** IF USER NOT LOGGUED CHECK LOCALSTORAGE, ELSE, CHECK ADDRESS ***/
          if (this.user == "") {
            if ('localStorage' in window && window['localStorage'] !== null) {
              if (localStorage.getItem("payment_country"))
                checkout.billingData.country = localStorage.getItem("payment_country");
              else
                checkout.billingData.country = checkout.defaultCountry;
              
              if (localStorage.getItem("shipping_country"))
                checkout.shippingData.country = localStorage.getItem("shipping_country");
              else
                checkout.shippingData.country = checkout.defaultCountry;
              
              
            }
          } else {
            checkout.checkAddressesIprofile();
          }
          
          checkout.getProvincesByCountry(checkout.billingData.country, 1);
          checkout.getProvincesByCountry(checkout.shippingData.country, 2);
          
          /*** IF ALL THE PRODUCTS HAVE FREESHIPPING, DOESNT SHOW SHIPPING METHODS ***/
          $.each(checkout.shippingMethods, function (i, val) {
            if (val.configName == 'notmethods')
              checkout.shipping_method = 'notmethods';
          })
          
          /*** IF guestOrCustomer RADIO BUTTON CHANGE, WE SET THE NECESSARY HTML ***/
          var formGuest = $(".guestUser").html();
          var formUser = $(".formUser").html();
          $(".formUser").html("");
          $("input[name=guestOrCustomer]").change(function () {
            if ($(this).val() == 2) {
              $(".guestUser").html(formGuest);
              $(".formUser").html("");
            } else {
              $(".formUser").html(formUser);
              $(".guestUser").html("");
            }
            checkout.checkLocalStore();
            
          })
          
          /*** IF newOldCustomer RADIO BUTTON CHANGE, WE SET THE NECESSARY HTML ***/
          var formLogin = $(".formLogin").html();
          $(".formLogin").html("");
          $("input[name=newOldCustomer]").change(function () {
            if ($(this).val() == 2) {
              $(".guestUser").html("");
              $(".formUser").html("");
              $(".formLogin").html(formLogin);
              $(".loginSubmit").click(function (e) {
                checkout.login(e);
              });
              checkout.topForm();
            } else {
              if ($("input[name=guestOrCustomer]:checked").val() == 2)
                $(".guestUser").html(formGuest);
              else
                $(".formUser").html(formUser);
              $(".formLogin").html("");
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
        items: {!!$items['items']!!},
        payments: {!! $payments ? $payments : "''" !!},
        shippingMethods: {!! $shipping ? $shipping : "''" !!},
        paymentSelected: "",
        defaultCountry: {!! "'".$defaultCountry."'" !!},
        countryFreeshipping: {!! "'".$countryFreeshipping."'" !!},
        user: {!! $user ? $user : "''" !!},
        addresses: {!! $user ? $addresses ? : $addresses : "''" !!},
        selectAddresses: {!! $user ? $addressSelect ? : $addressSelect : "''" !!},
        first_name:{!! $user ? "'".$user->first_name."'" : "''" !!},
        last_name: {!! $user ? "'".$user->last_name."'" : "''" !!},
        billingData: {
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
        quantity: {!!$items['quantity']!!},
        subTotal: 0,
        realSubTotal: 0,
        shipping: 0,
        discount: 0.0,
        orderTotal: 0,
        shipping_method: '',
        shipping_amount: 0,
        guestOrCustomer1: true,
        sameDeliveryBilling: true,
        weight: {!! $items['weight'] !!},
        countries: [],
        tax: false,
        taxValue:{{ $tax ? $tax : 0}},
        taxTotal: 0,
        statesBilling: [],
        statesDelivery: [],
        statesShippingAlternative: false,
        statesBillingAlternative: false,
        statesDeliveryAlternativeValue: '',
        placeOrderButton: false,
        passwordGuest:{!! "'".$passwordRandom."'" !!},
        deliveryData: {
          country: ''
        },
        updatingData: false,
        useExistingPaymentAddress: true,
        shippingMethodSelected: false,
        selectedBillingAddress: 0,
        selectedShippingAddress: 0,
      },
      filters: {
        capitalize: function (value) {
          if (!value) return ''
          if (value.toString() == 'ups' || value.toString() == 'usps')
            return value.toString().toUpperCase();
          value = value.toString()
          return value.charAt(0).toUpperCase() + value.slice(1)
        },
        twoDecimals: function (value) {
          return Number(Math.round(parseFloat(value) + 'e' + 2) + 'e-' + 2).toFixed(2);
        },
        numberFormat: function (value) {
          
          return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
          
        }
      },
      methods: {
        checkLocalStore: function () {
          if ('localStorage' in window && window['localStorage'] !== null) {
            for (var i = 0; i < localStorage.length; i++) {
              var element = $("#" + localStorage.key(i));
              var type = element.attr("type");
              var id = localStorage.key(i);
              var val = localStorage.getItem(id);
              if (id == "first_name_register" || id == "first_name_guest")
                checkout.billingData.firstname = checkout.shippingData.first_name = checkout.first_name = val;
              if (id == "last_name_register" || id == "last_name_guest")
                checkout.billingData.lastname = checkout.shippingData.last_name = checkout.last_name = val;
              
              element.val(val);
              var split = id.split("_", 2);
              var rest = id.substring(split[0].length + 1, id.length);
              if (split[0] == "payment") {
                if (split[1] != "country") {
                  checkout.billingData[rest] = val;
                  checkout.getProvincesByCountry(checkout.billingData.country, 1);
                }
              } else {
                if (split[0] == "shipping") {
                  if (split[1] != "country") {
                    checkout.shippingData[rest] = val;
                    checkout.getProvincesByCountry(checkout.shippingData.country, 2);
                  }
                }
              }
            }
          }
        },
        
        checkAddressesIprofile: function () {
          /*** IF THERE ARE ADDRESSES, CHECK IF ANY IS DEFAULT BILLING OR DEFAULT SHIPPING AND TURN ON FLAG ***/
          if (this.addresses) {
            var billing = false, shipping = false;
            this.addresses.forEach(function (address, index) {
              
              if (address.type == 'billing') {
                billing = true;
                checkout.selectedBillingAddress = index;
                for (var key in address) {
                  var val = address[key];
                  checkout.billingData[key] = val;
                }
              }
              if (address.type == 'shipping') {
                shipping = true;
                checkout.selectedShippingAddress = index;
                for (var key in address) {
                  var val = address[key];
                  checkout.shippingData[key] = val;
                }
              }
            });
            /*** IF THERE IS NO DEFAULT DELIVERY ADDRESS OR DEFAULT BILLING ADDRESS,
             *   ADD THE FIRST DEFAULT ADDRESS FOR TWO CASES ***/
            
            var address = this.addresses[0];
            for (var key in address) {
              var val = address[key];
              if (!billing)
                checkout.billingData[key] = val;
              if (!shipping)
                checkout.shippingData[key] = val;
            }
            
            /*** IF THERE ARE NO ADDRESSES, ADD PROVINCES OF THE COUNTRY SELECTED BEFORE ***/
          }
          
        },
        /* actualiza la cantidad del producto antes de enviarlo */
        update_quantity: function (item, sign) {
          sign === '+' ?
            item.quantity++ :
            item.quantity--;
          checkout.update_cart(item);
        },
        
        /* actualiza el item del carrito */
        update_cart: function (item) {
          this.updatingData = true;
          axios.post('{{ route("icommerce.api.update.item.cart") }}', item).then(function (response) {
            vue_carting.get_articles();
            checkout.updateTotal(checkout.items);
            checkout.getShippingMethods();
          });
        },
        isFreeshippingCountry: function () {
          if (($('#sameDeliveryBilling').prop("checked")))
            if (this.billingData.country == this.countryFreeshipping)
              return true;
            else
              return false;
          else if (this.shippingData.country == this.countryFreeshipping)
            return true;
          else
            return false;
        },
        getArticulos: function () {
          
          axios.get('{{ url("api/icommerce/items_cart") }}').then(response => {
            this.items = response.data.items;
            this.quantity = response.data.quantity;
            var sub = 0;
            $.each(this.items, function (i, val) {
              sub += val.price * val.quantity;
              
            })
            this.orderTotal = this.subTotal = sub.toFixed(2);
            
          })
          ;
        },
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
        registerOrder: function () {
          var data = $('#checkoutForm').serialize();
          axios.post('{{url("/checkout")}}', data).then(function (response) {
            if (response.data.status != "202") {
              this.placeOrderButton = false;
              checkout.alert(response.data.message, "warning");
            }
            else {
              checkout.alert(response.data.message, "success");
              window.location.replace(response.data.url);
            }
            
          }).catch(error => {
            this.placeOrderButton = false;
            checkout.alert("{{ trans('icommerce::checkout.alerts.error_order') }}", "warning");
          });
        },
        calculate: function (index, val, type, event) {
          this.shippingMethodSelected = this.shippingMethods[index];
          if (type == "freeshipping") {
            if (parseFloat(this.realSubTotal) >= val) {
              if (this.tax)
                this.orderTotal = parseFloat(this.subTotal) + parseFloat(this.taxTotal);
              else
                this.orderTotal = this.subTotal;
              
              this.shipping = 0;
              this.shipping_method = type;
              this.shipping_amount = 0;
              $("#shipping_value").val(val);
            } else {
              this.shipping_method = '';
              this.alert("{{ trans('icommerce::checkout.alerts.minimun_shipping') }}", 'warning');
              $('input[id=shipping_method]:checked').prop("checked", false);
              
            }
          } else {
            if (type == "flatrate") {
              this.orderTotal = parseFloat(this.subTotal) + parseFloat(val);
              this.shipping = val;
            } else if (type == "fixed_amount") {
              this.orderTotal = parseFloat(this.subTotal) + parseFloat(val);
              this.shipping = val;
            } else if (type == "percentage_cart") {
              var percentage_cart = (parseFloat(this.subTotal) * parseFloat(val) / 100);
              this.orderTotal = parseFloat(this.subTotal) + percentage_cart;
              this.shipping = percentage_cart;
            } else if (type == "ups" || type == "usps") {
              this.orderTotal = parseFloat(this.subTotal) + parseFloat(val);
              this.shipping = val;
            } else {
              var cant = 0;
              $.each(this.items, function (i, val) {
                cant += val.quantity;
              })
              this.shipping = cant * val;
              this.orderTotal = parseFloat(this.subTotal) + this.shipping;
            }
            
            if (this.tax)
              this.orderTotal = parseFloat(this.orderTotal) + parseFloat(this.taxTotal);
            this.shipping_amount = this.shipping;
            
            $("#shipping_value").val(val);
          }
          
        },
        guestOrCustomer: function (val) {
          return true;
        },
        topForm: function () {
          var posicion = $("#checkoutForm").offset().top;
          $("html, body").animate({
            scrollTop: posicion
          }, 1000);
        },
        updateTotal: function (items) {
          this.subTotal = 0;
          this.orderTotal = 0;
          this.realSubTotal = 0;
          for (var index in items) {
            this.subTotal += (items[index].price * items[index].quantity);
            if (items[index].freeshipping == "0")
              this.realSubTotal += (items[index].price * items[index].quantity);
          }
          
          this.subTotal = Math.round(this.subTotal * 100) / 100;
          this.realSubTotal = Math.round(this.realSubTotal * 100) / 100;
          this.calculate("", "");
          this.updatingData = false;
        },
        deleteItem: function (item) {
          this.updatingData = true;
          axios.post('{{ route('icommerce.api.delete.item.cart') }}?id=' + item.id, item)
            .then(response => {
              if (window.vue_carting) {
                vue_carting.update_dates(response.data);
              }
              checkout.items = response.data.items;
              checkout.quantity = response.data.quantity;
              checkout.weight = response.data.weight;
              checkout.updateTotal(response.data.items);
              checkout.getShippingMethods();
              checkout.alert("{{ trans('icommerce::checkout.alerts.remove_car') }}", "success");
              
            }).catch(error => {
            console.log(error);
          });
        },
        login: function (e) {
          e.preventDefault();
          var data = $('#checkoutForm').serialize();
          axios.post('{{url("checkout/login")}}', data)
            .then(response => {
              var user = response.data.user;
              var addresses = response.data.addresses;
              var addressSelect = response.data.addressSelect;
              checkout.user = user;
              checkout.addresses = addresses;
              checkout.selectAddresses = addressSelect;
              checkout.appendUser('#loginAlert');
              checkout.checkAddressesIprofile();
            });
        },
        appendUser: function (alert) { // este metodo funciona tanto para login como para register
          if (!this.user) {
            $(alert).html("{{ trans('icommerce::checkout.alerts.invalid_data') }}");
            $(alert).toggleClass('d-none');
            setTimeout(function () {
              $(alert).toggleClass('d-none');
            }, 3000);
          } else {
            $("#customerData").html("<div class='card mb-0 border-0'><div class='d-block'><strong>{{ trans('icommerce::checkout.logged.name') }} </strong>" + this.user.first_name + ", " + this.user.last_name + "</div><div class='d-block'><strong>{{ trans('icommerce::checkout.logged.email') }} </strong>" + this.user.email + "</div><hr><div class='d-block text-right'><i class='fa fa-id-card-o mr-2'></i><a href='{{url('/account')}}'>{{ trans('icommerce::checkout.logged.view_profile') }}</a></div><div class='d-block text-right'><i class='fa fa-pencil-square-o mr-2'></i><a href='{{url('/account/profile')}}'>{{ trans('icommerce::checkout.logged.edit_profile') }}</a></div></div><div class='d-block text-right'><a href='{{url('/checkout/logout')}}''>{{ trans('icommerce::checkout.logged.logout') }}</a></div>");
            var inputs = '<input type="hidden" id="first_name" name="first_name" value="' + this.user.first_name + '">';
            inputs += '<input type="hidden" id="last_name" name="last_name" value="' + this.user.last_name + '">';
            inputs += '<input type="hidden" id="user_id" name="user_id" value="' + this.user.id + '">';
            inputs += '<input type="hidden" id="email" name="email" value="' + this.user.email + '">';
            $("#customerData").append(inputs);
            
            checkout.first_name = this.user.first_name;
            checkout.last_name = this.user.last_name;
          }
        },
        getShippingMethods: function () {
          this.updatingData = true;
          this.shipping_method = null;
          this.shipping_amount = 0;
          this.shipping = 0;
          shippingMethodSelected = false;
          if (($('#sameDeliveryBilling').prop("checked"))) {
            var postCode = $('#payment_postcode').val();
            var countryISO = $('#payment_country option:selected').val();
            var country = $('#payment_country option:selected').text();
            
            axios.post('{{ url("api/icommerce/shipping_methods") }}', {postCode, countryISO, country})
              .then(response => {
                checkout.updatingData = false;
                checkout.shippingMethods = response.data;
                
                
                $.each(checkout.shippingMethods, function (i, val) {
                  
                  if (val.configName == 'notmethods') {
                    
                    checkout.shipping_method = 'notmethods';
                  }
                })
              });
          } else {
            var postCode = $('#shipping_postcode').val();
            var countryISO = $('#shipping_country option:selected').val();
            var country = $('#shipping_country option:selected').text();
            
            axios.post('{{ url("api/icommerce/shipping_methods") }}', {postCode, countryISO, country})
              .then(response => {
                checkout.updatingData = false;
                checkout.shippingMethods = response.data;
                
                
                $.each(checkout.shippingMethods, function (i, val) {
                  
                  if (val.configName == 'notmethods') {
                    
                    checkout.shipping_method = 'notmethods';
                  }
                })
              });
          }
        },
        taxFlorida: function (state, component) {
          if (($('#sameDeliveryBilling').prop("checked"))) {
            if (state == 'Florida') {
              this.tax = true;
              this.taxTotal = parseFloat(this.taxValue / 100 * this.subTotal).toFixed(2);
              this.orderTotal = (parseFloat(this.orderTotal) + parseFloat(this.taxTotal)).toFixed(2);
            } else {
              this.tax = false;
              this.orderTotal -= this.taxTotal;
              this.taxTotal = '';
            }
          } else {
            if (component == 2) {
              if (state == 'Florida') {
                this.tax = true;
                this.taxTotal = parseFloat(this.taxValue / 100 * this.subTotal).toFixed(2);
                this.orderTotal = (parseFloat(this.orderTotal) + parseFloat(this.taxTotal)).toFixed(2);
              } else {
                this.tax = false;
                this.orderTotal -= this.taxTotal;
                this.taxTotal = '';
              }
            }
          }
        },
        getProvincesByCountry: function (iso, component) {
          if (iso != null) {
            if (iso != 'US')
              this.taxFlorida('null', component);
            axios.get('https://ecommerce.imagina.com.co/api/ilocations/allprovincesbycountry/iso2/' + iso)
              .then(response => {
                //data is the JSON string
                if (component == 1) {
                  checkout.statesBilling = response.data;
                  checkout.statesBillingAlternative = !checkout.statesBilling.length;
                  if (iso == 'US' && checkout.billingData.zone == 'Florida')
                    this.taxFlorida('Florida', component);
                  this.getShippingMethods();
                }
                else if (component == 2) {
                  checkout.statesDelivery = response.data;
                  checkout.statesShippingAlternative = !checkout.statesDelivery.length;
                  if (iso == 'US' && checkout.deliveryData.zone == 'Florida')
                    this.taxFlorida('Florida', component);
                  this.getShippingMethods();
                }
              }).catch(error => {
              console.log(error);
            });
          }
        },
        deliveryBilling: function () {
          var login = $("input[name=newOldCustomer]:checked").val();
          if (login == 1) {
            this.billingData.firstname = $("input[name=first_name]").val();
            this.billingData.lastname = $("input[name=last_name]").val();
          } else {
            this.billingData.firstname = this.user.first_name;
            this.billingData.lastname = this.user.last_name;
          }
          
          if ($('#sameDeliveryBilling').prop("checked"))
            this.shippingData = this.billingData;
          
        },
        changeAddress: function (addressIndex, comp) {
          var address = this.addresses[addressIndex];
          for (var key in address) {
            var val = address[key];
            if (comp == 1)
              checkout.billingData[key] = val;
            else
              checkout.shippingData[key] = val;
          }
          this.getShippingMethods();
        },
        submitOrder: function (event) {
          if ($('#checkoutForm').valid()) {
            event.preventDefault();
            checkout.deliveryBilling();
            this.placeOrderButton = true;
            setTimeout(function () {
              var register = $("input[name=guestOrCustomer]:checked").val();
              var login = $("input[name=newOldCustomer]:checked").val();
              if (login == 2) {
                checkout.placeOrderButton = false;
                checkout.topForm();
                
                $("#loginAlert").html("{{ trans('icommerce::checkout.alerts.login_order') }}");
                $("#loginAlert").toggleClass('d-none');
                setTimeout(function () {
                  $("#loginAlert").toggleClass('d-none');
                }, 10000);
              } else {
                var data = $('#checkoutForm').serialize();
                var band = 0;
                if (login == 1 && register == 2) {
                  data = data + "&password=" + checkout.passwordGuest;
                  data = data + "&password_confirmation=" + checkout.passwordGuest;
                  
                  
                  // Si se va a registrar el usuario primero enviamos los data para crear el registro
                  axios.post      // si genera un error el registro de usuario se invalida el bandRegister para que no
                  (               // se envien los data de la orden, bandRegister siempre sera 1 para que en otros casos
                    '{{url("/checkout/register")}}',  // se envie la orden sin problemas
                    data,
                  ).then(response => {
                    var status = response.data.status;
                    if (status == "error") {
                      checkout.placeOrderButton = false;
                      checkout.topForm();
                      
                      $("#registerAlert").html(response.data.message);
                      $("#registerAlert").toggleClass('d-none');
                      setTimeout(function () {
                        $("#registerAlert").toggleClass('d-none');
                      }, 10000);
                    } else {
                      var user = response.data.user;
                      checkout.appendUser("#registerAlert", user);
                      setTimeout(function () {
                        checkout.registerOrder();
                      }, 1000);
                    }
                  }).catch(error => {
                    
                    checkout.placeOrderButton = false;
                    checkout.topForm();
                    
                    $("#registerAlert").html(error.response.data.errors.email[0]);
                    $("#registerAlert").toggleClass('d-none');
                    setTimeout(function () {
                      $("#registerAlert").toggleClass('d-none');
                    }, 10000);
                    checkout.alert(error.response.data.errors.email[0], "warning");
                  });
                } else {
                  checkout.registerOrder();
                }
              }
            }, 1000);
          } else {
            this.topForm();
            checkout.alert("Missing some fields, check again, fill and send again", "warning");
          }
        }
      }
    });
  </script>

@stop

