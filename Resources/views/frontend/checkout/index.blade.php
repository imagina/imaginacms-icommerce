@extends('layouts.master')

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
                            <li class="breadcrumb-item"><a
                                        href="{{ URL::to('/') }}">{{ trans('icommerce::common.home.title') }}</a>
                            </li>
                            <li class="breadcrumb-item active"
                                aria-current="page">{{ trans('icommerce::checkout.title') }}</li>
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
                            <a class="btn btn-success"
                               href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
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
                            <a class="btn btn-success"
                               href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
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
                checkout.getShippingMethods();
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
                    payment_firstname: {required: true},
                    payment_lastname: {required: true},
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
                    this.updateTotalAndTax(this.items);

                    /*** SET DEFAULT COUNTRY VALUE FROM SETTING ICOMMERCE MODULE ***/
                    checkout.shippingData.country = checkout.defaultCountry;
                    checkout.billingData.country = checkout.defaultCountry;

                    /*** GET DATA FROM API COUNTRIES AND SET TO LOCALSTORAGE ***/
                    if ('localStorage' in window && window['localStorage'] !== null) {
                        if (localStorage.getItem("countries")) {

                            checkout.countries = JSON.parse(localStorage.getItem("countries"));

                        } else {

                            axios.get('{{url('/api/ilocations/allmincountries')}}')
                                .then(function (response) {
                                    if (response.status == 200) {
                                        checkout.countries = response.data;
                                        localStorage.setItem("countries", JSON.stringify(response.data));

                                    }
                                });
                        }

                    } else {

                        axios.get('{{url('/api/ilocations/allmincountries')}}')
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

                            checkout.checkLocalStorage();
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
                        checkout.checkLocalStorage();

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
                currencySymbolLeft: icommerce.currencySymbolLeft,
                currencySymbolRight: icommerce.currencySymbolRight,
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
                useExistingOrNewPaymentAddress: '1',
                useExistingOrNewShippingAddress: '1',
                shippingMethodSelected: false,
                selectedBillingAddress: 0,
                selectedShippingAddress: 0,

            },
            watch: {
                useExistingOrNewPaymentAddress(value) {
                    if (value == 1)
                        this.changeAddress(this.selectedBillingAddress, 1);
                },
                useExistingOrNewShippingAddress(value) {
                    if (value == 1)
                        this.changeAddress(this.selectedShippingAddress, 2);
                }
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
                    if (value != '')
                        return checkout.currencySymbolLeft + " " + (parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')) + " " + checkout.currencySymbolRight;
                    else
                        return value;
                }
            },
            methods: {
                /** chequea los datos cacheados en localStorage */
                checkLocalStorage: function () {

                    if ('localStorage' in window && window['localStorage'] !== null) {
                        for (var key in localStorage) {
                            if (key != "") {

                                var element = $("#" + key);
                                var type = element.attr("type");
                                var val = localStorage.getItem(key);
                                if (key == "first_name_register" || key == "first_name_guest")
                                    checkout.billingData.firstname = checkout.shippingData.first_name = checkout.first_name = val;
                                if (key == "last_name_register" || key == "last_name_guest")
                                    checkout.billingData.lastname = checkout.shippingData.last_name = checkout.last_name = val;

                                element.val(val);
                                var split = key.split("_", 2);
                                var rest = key.substring(split[0].length + 1, key.length);
                                if (split[0] == "payment") {
                                    if (split[1] != "country") {
                                        checkout.billingData[rest] = val;
                                    }
                                } else {
                                    if (split[0] == "shipping") {
                                        if (split[1] != "country") {
                                            checkout.shippingData[rest] = val;
                                        }
                                    }
                                }
                            }
                        }
                    }
                },

                /** chequea si hay direcciones guardadadas en el perfil del usuario */
                checkAddressesIprofile: function () {
                    /*** IF THERE ARE ADDRESSES, CHECK IF ANY IS DEFAULT BILLING OR DEFAULT SHIPPING AND TURN ON FLAG ***/
                    if (this.addresses.length) {
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
                    } else {
                        this.addresses = '';
                        this.useExistingOrNewPaymentAddress = '2';
                        this.useExistingOrNewShippingAddress = '2';
                    }

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
                    axios.post('{{ route("icommerce.api.update.item.cart") }}', item).then(function (response) {
                        vue_carting.get_articles();
                        checkout.updateTotalAndTax(checkout.items);
                        checkout.getShippingMethods();
                    });
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

                /** envia la data al controller OrderController */
                registerOrder: function () {
                    var data = $('#checkoutForm').serialize();

                    axios.post('{{url("/checkout")}}', data).then(function (response) {
                        if (response.data.status != "202") {
                            this.placeOrderButton = false;
                            checkout.alert(response.data.message, "warning");
                        }
                        else {
                            checkout.alert(response.data.message, "success");
                            if ('localStorage' in window && window['localStorage'] !== null) {
                                localStorage.clear();
                            }
                            window.location.replace(response.data.url);
                        }

                    }).catch(error => {
                        this.placeOrderButton = false;

                        checkout.alert("{{ trans('icommerce::checkout.alerts.error_order') }}", "warning");
                    });
                },

                /** recalcula order Total y shipping segun el metodo de envio seleccionado */
                calculate: function (index, val, type, event) {
                    this.shippingMethodSelected = this.shippingMethods[index];
                    this.orderTotal = parseFloat(this.subTotal) + parseFloat(val);
                    this.shipping = val;

                    if (this.tax)
                        this.orderTotal = parseFloat(this.orderTotal) + parseFloat(this.taxTotal);

                    this.shipping_amount = this.shipping;

                    $("#shipping_value").val(val);

                },

                /** reposiciona el scroll al top del formulario en caso de errores */
                topForm: function () {
                    var posicion = $("#checkoutForm").offset().top;
                    $("html, body").animate({
                        scrollTop: posicion
                    }, 1000);
                },

                /** actualiza subTotal, Total y Tax */
                updateTotalAndTax: function (items) {
                    this.updatingData = true;
                    this.subTotal = 0;
                    this.orderTotal = 0;

                    for (var index in items)
                        this.subTotal += (items[index].price * items[index].quantity);


                    this.subTotal = Math.round(this.subTotal * 100) / 100;
                    if (($('#sameDeliveryBilling').prop("checked"))) {
                        var state = this.billingData.zone;
                        var compoment = 1;
                    } else {
                        var state = this.shippingData.zone;
                        var compoment = 2;
                    }
                    this.taxFlorida(state, compoment);
                    this.calculate("", 0);
                    this.updatingData = false;
                },

                /** elimina un producto del carrito */
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
                            checkout.updateTotalAndTax(response.data.items);
                            checkout.getShippingMethods();
                            checkout.alert("{{ trans('icommerce::checkout.alerts.remove_car') }}", "success");

                        }).catch(error => {

                    });
                },

                /** envia los datos del logueo al controller AuthEcommerceController */
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

                /** inyecta el html cuando un usuario inicia session / esto aun esta para actualizar a VUE reactive */
                appendUser: function (alert, type) { // este metodo funciona tanto para login como para register
                    if (!this.user) {
                        $(alert).html("{{ trans('icommerce::checkout.alerts.invalid_data') }}");
                        $(alert).toggleClass('d-none');
                        setTimeout(function () {
                            $(alert).toggleClass('d-none');
                        }, 3000);
                    } else {
                        var inputs = '<input type="hidden" id="first_name" name="first_name" value="' + this.user.first_name + '">';
                        inputs += '<input type="hidden" id="last_name" name="last_name" value="' + this.user.last_name + '">';
                        inputs += '<input type="hidden" id="user_id" name="user_id" value="' + this.user.id + '">';
                        inputs += '<input type="hidden" id="email" name="email" value="' + this.user.email + '">';
                        if (type != "guest") {
                            $("#customerData").html("<div class='card mb-0 border-0'><div class='d-block'><strong>{{ trans('icommerce::checkout.logged.name') }} </strong>" + this.user.first_name + ", " + this.user.last_name + "</div><div class='d-block'><strong>{{ trans('icommerce::checkout.logged.email') }} </strong>" + this.user.email + "</div><hr><div class='d-block text-right'><i class='fa fa-id-card-o mr-2'></i><a href='{{url('/account')}}'>{{ trans('icommerce::checkout.logged.view_profile') }}</a></div><div class='d-block text-right'><i class='fa fa-pencil-square-o mr-2'></i><a href='{{url('/account/profile')}}'>{{ trans('icommerce::checkout.logged.edit_profile') }}</a></div></div><div class='d-block text-right'><a href='{{url('/checkout/logout')}}''>{{ trans('icommerce::checkout.logged.logout') }}</a></div>");
                        }
                        $("#customerData").append(inputs);
                        checkout.first_name = this.user.first_name;
                        checkout.last_name = this.user.last_name;
                    }
                },

                /** llama al api CartController y solicita los metodos de envio */
                getShippingMethods: function () {
                    this.updatingData = true;
                    this.shipping_method = null;
                    this.shipping_amount = 0;
                    this.shipping = 0;


                    shippingMethodSelected = false;
                    if (($('#sameDeliveryBilling').prop("checked"))) {
                        var postCode = this.billingData.postcode;
                        var countryISO = this.billingData.country;
                        var country = $('#payment_country option:selected').text();

                    } else {
                        var postCode = this.shippingData.postcode;
                        var countryISO = this.shippingData.country;
                        var country = $('#shipping_country option:selected').text();
                    }
                    var options = {
                        postCode: postCode,
                        countryCode: countryISO,
                        country: country
                    };
                    if (postCode != '' && countryISO != '' && country != '')
                        axios.post('{{ url("api/icommerce/shipping_methods") }}', options)
                            .then(response => {
                                checkout.updatingData = false;
                                checkout.shippingMethods = response.data;
                                checkout.updateTotalAndTax(checkout.items);
                                $.each(checkout.shippingMethods, function (i, val) {
                                    if (val.configName == 'notmethods') {
                                        checkout.shipping_method = 'notmethods';
                                    }
                                })
                            });
                    else
                        this.updatingData = false;
                },

                /** activa/desactiva y calcula el tax en caso de seleccionarse Florida */
                taxFlorida: function (state, component) {
                    if (($('#sameDeliveryBilling').prop("checked")) || component == 2) {
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
                },

                /** consulta las provincias por pais seleccionado al api en Ilocations */
                getProvincesByCountry: function (iso, component) {
                    if (iso != null) {
                        if (iso != 'US')
                            this.taxFlorida('null', component);
                        axios.get('{{url('/api/ilocations/allprovincesbycountry/iso2')}}' + '/' + iso)
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

                        });
                    }
                },

                /** se encarga de igualar las direcciones shipping y billing en caso de estar marcado en checkbox */
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

                /** actualiza shippingData o billingData cuando se cambia de direccion en los selects de direcciones del iprofile */
                changeAddress: function (addressIndex, comp) {
                    var address = this.addresses[addressIndex];
                    for (var key in address) {
                        var val = address[key];
                        if (comp == 1)
                            checkout.billingData[key] = val;
                        else
                            checkout.shippingData[key] = val;
                    }
                    if (comp == 2 || (comp == 1 && $('#sameDeliveryBilling').prop("checked")))
                        setTimeout(function () {
                            checkout.getShippingMethods();
                        }, 1000);

                },

                /** valida los errores del formulario y valida/registra el usuario para poder enviar la orden a registerOrder() */
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
                                if (login == 1) {
                                    if (register == 2) {
                                        data = data + "&password=" + checkout.passwordGuest;
                                        data = data + "&password_confirmation=" + checkout.passwordGuest;

                                    }
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

                                            checkout.user = response.data.user;

                                            if (login != 1 && register != 2)
                                                checkout.appendUser("#registerAlert");
                                            else
                                                checkout.appendUser("#registerAlert", "guest");

                                            setTimeout(function () {
                                                checkout.registerOrder();
                                            }, 1000);
                                        }
                                    }).catch(error => {
                                        checkout.placeOrderButton = false;
                                        checkout.topForm();

                                        var error;
                                        if (error.response.data.errors.email)
                                            error = error.response.data.errors.email[0];
                                        else
                                            error = error.response.data.errors.password[0];

                                        $("#registerAlert").html(error);
                                        $("#registerAlert").toggleClass('d-none');
                                        setTimeout(function () {
                                            $("#registerAlert").toggleClass('d-none');
                                        }, 10000);
                                        checkout.alert(error, "warning");
                                    });
                                } else {
                                    checkout.registerOrder();
                                }
                            }
                        }, 1000);
                    } else {
                        this.topForm();
                        checkout.alert('{{ trans('icommerce::checkout.alerts.missing_fields') }}', "warning");
                    }
                },

                /** se llama desde la vista Order_Summary y le indica si el producto lleva freeshipping segun el pais destino */
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
            }
        });
    </script>

@stop

