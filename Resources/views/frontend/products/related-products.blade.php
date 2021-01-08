<div v-if="relatedProducts.length">
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-12">
                
                <div class="title-arrow text-center mb-5">
                    <h2 class="px-5 bg-white"><strong>COMPLEMENTA</strong> TU COMPRA</h2>
                </div>
                
                <div id="relatedProducts" class="owl-carousel owl-theme py-4">
                    <div class="items" v-for="item in relatedProducts" v-bind:key="item.id">
                        <div class="product-layout card-product mb-4">
                            <div class="bg-img cursor-pointer ">
                                <a v-bind:href="item.url">
                                    <img v-bind:alt="item.name" v-bind:src="item.mediaFiles.mainimage.path">
                                </a>
                            </div>
                            <div class="mt-3 pb-3 text-center">
                                <div class="category">
                                
                                </div>
                                <div class="name mb-3">
                                    <a v-bind:href="item.url" class="name cursor-pointer">
                                        @{{ item.name }}
                                    </a>

                                </div>
                                
                                <div class="price mt-3">
                                    <i class="fa fa-shopping-cart icon"></i>
                                    @{{currencysymbolleft}}@{{ item.price }}
                                </div>
                                <a class="cart-no">&nbsp;</a>
                                <a v-if="item.price!=0.00" v-on:click="addCart(item)" v-show="item.price > 0"
                                   class="cart text-primary cursor-pointer">
                                    Añadir al carrito
                                </a>
                                <a href="{{ URL::to('/contacto') }}" v-else class="cart text-primary cursor-pointer">
                                    Contacta con nosotros
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

