@section('scripts-owl')

  <script>
    var vue_carting = new Vue({

      el: '#content_carting',
      mounted: function () {
        this.$nextTick(function () {
          this.getCart();
        });
      },
      data: {
        articles: [],
        total: 0,
        cart: null,
        quantity: 0,
        currencySymbolLeft: icommerce.currencySymbolLeft,
        currencySymbolRight: icommerce.currencySymbolRight,
      },
      filters: {
        numberFormat: function (value) {
          return new Intl.NumberFormat('de-DE').format(value);
          // return parseFloat(value).toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        }
      },
      methods: {
        getCart() {
          var cart_id = localStorage.getItem("cart_id");
          if (cart_id) {
            axios.get("{{url('/')}}" + "/api/icommerce/v3/carts/" + cart_id)
              .then(function (response) {
                vue_carting.cart = response.data.data;
                vue_carting.articles = vue_carting.cart.products;
                vue_carting.quantity = vue_carting.cart.quantity;
                vue_carting.total = vue_carting.cart.total;
                if (!vue_carting.quantity)
                  vue_carting.quantity = 0;
                if (!vue_carting.total)
                  vue_carting.total = 0;


              })
              .catch(function (error) {
                localStorage.clear();
              });
          } else {
            this.createCart();
          }
        },
        createCart() {
          var id = 0;
          axios.post("{{url('/')}}" + "/api/icommerce/v3/carts", {
            attributes: {
              total: 0
            }
          }).then(response => {
            id = response.data.data.id;
   
            localStorage.setItem("cart_id", id);
            this.getCart();
          })
            .catch(function (error) {
              console.log(error);
            });
          return id;
        },
        clear_cart() {
          if (this.articles.length > 0) {
            for (var i = 0; i < this.articles.length; i++) {
              axios.delete("{{url('/')}}" + "/api/icommerce/v3/cart-products/" + this.articles[i].id)
                .then(response => {
                  console.log(response.data);
                }).catch(function (error) {
                console.log(error);
              });
            }//for articles
            this.getCart();
            toastr.success("Productos del carrito eliminados correctamente.");
          }//if articles length >0
        },
        addItemCart(productId, productName, price, quantity = 1, productOptValue = []) {
          var cart_id = localStorage.getItem("cart_id");
          if (!cart_id) {
            vue_carting.createCart();
            cart_id = localStorage.getItem("cart_id");
          }
          axios.post("{{url('/')}}" + "/api/icommerce/v3/cart-products", {
            attributes: {
              cart_id: cart_id,
              product_id: productId,
              product_name: productName,
              price: price,
              quantity: quantity,
              product_option_values: productOptValue
            }
          })
            .then(function (response) {
              toastr.success("Producto agregado al carrito exitosamente.");
              vue_carting.getCart();
              return true;
            })
            .catch(function (error) {
              console.log(error);
            });
          return false;
        },
        delete_item(item_id) {
          axios.delete("{{url('/')}}" + "/api/icommerce/v3/cart-products/" + item_id)
            .then(response => {
              this.getCart();
              return true;
            }).catch(function (error) {
            console.log(error);
          });
          return false;
        },


        location: function (url) {
          window.location = url;
        }
      }
    });
  </script>

  @parent
@stop