
<div>
     <!-- TITLE -->   
        <div class="title">
            <h2>@{{product.name}}</h2>
            <span :title="'RATING: '+product.rating" v-if="product.rating > 0" class="vue-load" >
              <i class="fa fa-star " v-for='item in (product.rating-0)' ></i>
              <i class="fa fa-star-o" v-for='item in (5-product.rating)'></i>
            </span>
            <span v-else>
                <i class="fa fa-star-o" ></i>
            </span>  
        </div>
    <!-- END TITLE -->
    <!-- PRICE -->
        <div class="price" v-if="products_children === false && product.price >0.00">
                
                <div class="prices">
                    @{{currencysymbolleft}} @{{ product.price }} @{{currencysymbolright}}
                </div>
        </div>
    <!-- END PRICE --> 
    <!-- SUMMARY -->                                
        <div class="description"  v-html="product.summary">
            @{{product.summary}}
        </div>
    <!-- END SUMMARY -->
    <!-- OPCIONES DE PRODUCTO -->
        @include('icommerce.widgets.opciones-producto')
    <!-- CATEGORIES -->
        <div class="category" v-if="product.category">
            <p>Categoria:<span>@{{product.category.title}}</span><span v-if="product.categories.lenght" v-for="item in product.categories">/@{{item.title}}</span></p>
        </div>
    <!-- END CATEGORIES -->
        <div class=" align-items-center mt-2"v-if="product.pdf">
            <a v-bind:href="product.pdf"
               class="btn btn-outline-light text-dark">
                <i class=""> </i>
                {{trans('icommerce::products.messages.product_brochure')}}
            </a>
        </div>

    
        <div class="add-cart d-flex flex-wrap" v-if="product.quantity>0">
        <!-- BUTTON QUANTITY -->               
            <div class="number-input mr-3">
                    <div class="input-group-prepend">
                        <button class="text-center"
                                type="button"
                                field="quantity"
                                v-on:click="quantity >= 2 ? quantity-- : false">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="text"
                           class="form-control text-center"
                           name="quantity"
                           v-model="quantity"
                           aria-label=""
                           aria-describedby="basic-addon1">
                    <div class="input-group-append">
                        <button class="text-center"
                                type="button"
                                field="quantity"
                                v-on:click="quantity < product.quantity ? quantity++ : false">
                           <i class="fa fa-plus"></i>
                        </button>
                    </div>
            </div>
        <!-- BUTTON ADD -->
            <div class=" btn-comprar"  v-if="product.price!='0.00'">
                <a v-on:click="addCart(product)"  class=""><i class="fa fa-shopping-cart" v-if="!sending_data"></i> <i class="fa fa-spinner fa-pulse" v-else></i> Añadir</a>
            </div >
        <!-- BUTTON CONSULT -->
            <div class=" btn-comprar"  v-else>
                <a href="{{url('/contacto')}}"   class="">Consultar</a>
            </div >
        <!-- BUTTON RAITING -->
            <div class=" options" v-if="!products_children">
                <a v-on:click="addWishList(product)" class="btn-wishlist"><i class="fa fa-heart"></i></a>
                <a href="" class=""><i class="fa fa-star"></i></a>
            </div> 
        </div>       

        <div v-else class="category"><p>Existencia: <span>No Disponible</span></p></div>
</div>
                                 