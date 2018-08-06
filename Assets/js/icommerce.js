/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('vuecarousel', require('./components/Carousel.vue'));
Vue.component('productrecent', require('./components/Recent.vue'));


const app = new Vue({
    el: '#app',
    data:{
        preloader: true,
        quantity: 1,
    },
    methods: {
        addCart: function (data) {
            if (data) {
                data['quantity_cart'] = this.quantity;
                data = [data];
            } else {
                data = this.productsChildrenCart;
            }
            app.sending_data = true;

        .then(response => {
                this.articles = response.data;
            })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => this.loading = false
                )
            axios
                .post('{{ url("api/icommerce/add_cart") }}', data)
                .then(function (response) {


                if (response.data.status==200) {
                    app.alert("{{trans('icommerce::products.alerts.add_cart')}}", "success");
                    app.quantity = 1;
                    app.get_articles();
                } else {
                    app.alert(
                        "{{trans('icommerce::products.alerts.no_add_cart')}}",
                        "error");
                }
                app.sending_data = false;
            });
        },
        addWishList: function (item) {
            if (this.user) {
                if (!this.check_wisht_list(item.id)) {
                    var data = {
                        user_id: this.user,
                        product_id: item.id
                    };

                    axios.post('{{ route("icommerce.api.wishlist.add") }}', data).then(function (response) {
                        vue_products_detals.get_wishlist();
                        vue_products_detals.alerta("{{trans('icommerce::wishlists.alerts.add')}}", "success");
                    })
                } else {
                    this.alerta("{{trans('icommerce::wishlists.alerts.product_in_wishlist')}}", "warning");
                }
            }
            else {
                this.alerta("{{trans('icommerce::wishlists.alerts.must_login')}}", "warning");
            }
        },
        alert: function (menssage, type) {
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

window.axios.interceptors.response.use(null, (error) => {
    if (error.response === undefined) {
        console.log(error);
        return;
    }
    if (error.response.status === 403) {
        app.$notify.error({
            title: app.$t('core.unauthorized'),
            message: app.$t('core.unauthorized-access'),
        });
        window.location = route('dashboard.index');
    }
    if (error.response.status === 401) {
        app.$notify.error({
            title: app.$t('core.unauthenticated'),
            message: app.$t('core.unauthenticated-message'),
        });
        window.location = route('login');
    }
    return Promise.reject(error);
});
