<!-- vista de productos -->
<div v-show="preloaded" class="text-center">
    <div class="spinner-border text-primary  position-absolute mx-auto" style="margin-top: -40px;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<div v-if="articles.length >= 1" class="row products-index">

    <div class="col-12 col-md-4 col-lg-3 product" v-if="articles.length>0" v-for="item in articles">
            
        <!-- PRODUCT -->
        <div class="card-product mb-4">

            <div class="bg-img cursor-pointer">
                <a v-bind:href="item.url">
                    <img v-bind:alt="item.name" v-bind:src="item.mainImage.path">
                </a>
            </div>

            <div class="infor mt-3 pb-3">

                <a class="title cursor-pointer" v-bind:href="item.url">
                   <h4>@{{ item.name }}</h4> 
                </a>

                <div class="product-category">
                    @{{ item.category.title }}
                </div>

                <div class="price">
                    @{{currencySymbolLeft}}@{{ item.formattedPrice }}
                </div>

                <div class="buttons-card">
                    
                    <a v-on:click="addCart(item)" v-show="item.price > 0" class="text-primary cursor-pointer">
                        <i class="fa fa-shopping-basket"></i>
                    </a>

                    <a v-on:click="addWishList(item)" class="text-primary cursor-pointer">
                        <i class="fa fa-heart-o mx-2"></i>
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- NOT PRODUCTS MSG --}}
<div v-if="articles.length==0 && !preloaded">
    No existen productos disponibles ...
</div>


<!-- PAGINATE -->
<div class="col-12 text-right" v-if="pages > 1">
    @includeFirst(['icommerce.widgets.pagination','icommerce::frontend.widgets.pagination'])
</div>