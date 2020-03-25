<!-- vista de productos -->
<div v-if="articles.length >= 1" class="row products-index">

    <div class="col-12 col-md-4 col-lg-3 product" v-if="articles.length>0" v-for="item in articles">
            <div v-show="preloaded">
                    <div class="card card-product mb-4 border-0">

                        <!-- image -->
                        <div class="bg-img border p-2">
                            <a :href="item.slug">
                                <img class="card-img-top" v-bind:alt="item.name"
                                     :src="item.mainImage.path">
                            </a>
                        </div>


                        <!-- dates product -->
                        <div class="card-body">
                            <!-- title -->
                            <h6 class="card-title text-center font-weight-bold">
                                <a :href="item.url">
                                    @{{item.name}}
                                </a>
                            </h6>

                            <!-- PRICE -->
                            <div class="price mb-2 text-center">
                                @{{currencySymbolLeft}} @{{ item.price }}
                            </div>

                        </div>
                    </div>
            </div>
        <!-- PRODUCT -->
        <div class="position-relative">
            <div class="img ">
              <img v-bind:src="item.mainImage.path" alt="">
            </div>
            <div class="btn-hover  w-100">
                <div class="contenido">
                  <div class="btn-left col-1">
                    <a class="d-block w-100 btn-wishList" v-on:click="addWishList(item)"><i class="fa fa-heart"></i></a>
                    <a href="" class="d-block w-100"><i class="fa fa-star"></i></a>
                    <a :href="item.slug" class="d-block w-100"><i class="fa fa-search"></i></a>
                  </div>
                   <div class="col-12 btn-comprar " >
                    <a v-if="item.price!=0.00"  class=" text-white" v-on:click="addCart(item)" v-show="item.price > 0"><i class="fa fa-shopping-cart"></i> Comprar</a>
                    <a href="{{ URL::to('/contacto') }}" v-else> Consultar </a>
                  </div>
                </div>
            </div>
        </div>
        <div class="btn-description">
            <div class="title text-center ">@{{item.name}}</div>
              <div class="description text-center d-inline-block "><p class="d-inline-block"><p v-if="item.category">Categoria:<span > @{{item.category.title}}</span><span v-if="item.categories" v-for="a in item.categories">/@{{a.title}}</span></p></p>
              <div class="d-flex justify-content-between price" >
                    <p v-if="item.price!=0.00">    @{{ currencySymbolLeft }} @{{ item.price }}</p>
                    <opciones-producto :optionvalues="item.optionValues" size="12px"></opciones-producto>


              </div>
            </div>
        </div>
    </div>



</div>




<!-- si no hay productos -->
<div v-else="articles.length >= 1">
    No hay productos en esta categoría ...
</div>

<hr class="border-light">

<!-- PAGINATE -->
<div class="col-12 text-right">
    <nav aria-label="Page navigation example" v-if="pages > 1" class="float-right">
        <ul class="pagination">
            <!-- btn go to the first page -->
            <li class="page-item" v-if="p_currence!=1">
                <a class="page-link" @click="changePage('first')" title="first page">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">{{trans('icommerce::common.pagination.previous')}}</span>
                </a>
            </li>

            <!-- btn back -->
            <li class="page-item" v-if="p_currence != 1">
                <a class="page-link" @click="changePage('back')"
                   title="back page">
                    <i class="fa fa-angle-left"></i>
                </a>
            </li>

            <!-- number pages  -->
            <li v-bind:class="[(num) == p_currence ? 'active' : false]" class="page-item"
                v-if="(num <= pages) && (num >= r_pages.first) && (num <= r_pages.latest)"
                v-for="num in r_pages.latest">
                <a  class="page-link"
                    v-on:click="[(num) == p_currence ? false : changePage('page',num)]">
                    @{{ num  }}
                </a>
            </li>

            <!-- btn next -->
            <li class="page-item" v-if="p_currence < pages">
                <a class="page-link" v-on:click="changePage('next')" title="next page">
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>

            <!-- btn go to the lastest page -->
            <li class="page-item" v-if="p_currence!=r_pages.latest">
                <a class="page-link" v-on:click="changePage('last')" title="last page">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">{{trans('icommerce::common.pagination.next')}}</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<!-- PAGINATE -->
