<template>
  <carousel :scrollPerPage="true" :perPageCustom="[[0, 1], [480, 2], [768, 2]]" :autoplay="true">
    <slide v-for="item in articles" v-bind:key="item.id">
      <div class="card card-product rounded-0 mt-4">
        <div class="img-overlay">
          <!-- image -->
          <a v-bind:href="item.url">
            <div class="card-img-top rounded-0 background_image"
                 v-bind:style="{'background-image' : 'url(' +item.mainimage+ ')', 'background-repeat' : 'no-repeat' , 'background-position': 'center'}">
            </div>
          </a>

          <a v-bind:href="item.url">
            <div class="overlay">
              <div class="link">
                <button v-bind:href="item.url"
                        class="btn btn-outline-light">
                  DETAILS
                </button>
              </div>
            </div>
          </a>
        </div>


        <div class="card-body">
          <h6 class="card-title text-center">
            <a v-bind:href="item.url">
              {{ item.title }}
            </a>
          </h6>

          <div class="row justify-content-md-center">
            <div class="col-12 col-md-auto">
              <p class="text-center text-danger font-weight-bold mb-1">
                <del class="text-muted pr-2"
                     v-if="item.price_discount"
                     style="font-size: 14px">
                  {{ currencysymbolleft +' '+ item.price +' '+ currencysymbolright }}
                </del>
                <span class="text-danger font-weight-bold"
                      v-if="!item.price_discount">
                                {{ currencysymbolleft +' '+ item.price +' '+  currencysymbolright }}
                            </span>
                <span class="text-danger font-weight-bold"
                      v-if="item.price_discount">
                                {{currencysymbolleft +' '+ item.price_discount +' '+  currencysymbolright  }}
                            </span>
              </p>
              <hr class=" border-primary mb-4 mt-0 w-50 border-2">
            </div>
          </div>


          <div class="text-center">
            <a class="btn btn-outline-secondary"
               v-on:click="$emit('add-cart',item)">
              <i class="fa fa-shopping-cart"></i>
            </a>
            <a class="btn btn-outline-secondary"
               v-on:click="$emit('add-wishlist',item)">
              <i class="fa fa-heart"></i>
            </a>
            <a v-bind:href="item.url"
               class="btn btn-outline-secondary">
              <i class="fa fa-eye"></i>
            </a>
          </div>
        </div>
      </div>
    </slide>
  </carousel>
</template>
<script>
    export default {
        props:[
            'categories'
        ],
        data() {
            return {
                articles: [],
                currencysymbolleft: icommerce.currencySymbolLeft,
                currencysymbolright: icommerce.currencySymbolRight,
                loading: true,
            }
        },
        components: {
            'carousel': VueCarousel.Carousel,
            'slide': VueCarousel.Slide
        },
        mounted: function () {
            this.$nextTick(function () {
                this.getData();
            });
        },
        methods: {
            getData: function () {
                let uri = icommerce.url + '/api/icommerce/v2/products?filters={"categories":'+this.categories+'}';
                axios.get(uri)
                    .then(response => {
                        this.articles = response.data;
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false
                    )
            }
        },
    }
</script>