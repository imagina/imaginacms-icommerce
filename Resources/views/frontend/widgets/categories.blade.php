<div class="filters-categories pb-4" v-if="categoriesmain && categoriesmain.length>0">

    <h4>Categorias</h4>

    <div class="filter-order  " v-for="(category,index) in categoriesmain" v-if="category.slug!='autores' && category.slug!='categorias' ">

        <a class="item mb-3" data-toggle="collapse" v-if="category.childrens && category.childrens.length>0 "
           v-bind:href="'#category-'+category.id" role="button" aria-expanded="false"
           v-bind:aria-controls="'category-'+category.id">
            <h5 class="p-3 d-block font-weight-bold cursor-pointer mb-0 border-top border-bottom" style="">
                <i class="fa angle float-right" aria-hidden="true"></i>
                @{{category.title}}
            </h5>

        </a>

        <a @click="loadCategory(category)" class="item item-single px-3 py-0 d-block cursor-pointer" v-else>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" :id="'check'+ category.title" >
                <label class="custom-control-label" :for="'check'+ category.title">@{{category.title}}</label>
            </div>

        </a>

        <div class="collapse multi-collapse mb-2" v-bind:id="'category-'+category.id">
            <ul class="list-group list-group-flush">
                <li class="list-group-item" v-for='(i,key) in category.childrens' :class="key==0 ? 'pb-0' : 'py-0' "
                    style="margin-left: -4px; border:0;">
                    <a class="d-block w-100 cursor-pointer" @click="loadCategory(i)">

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" :id="'checkk'+ i.title">
                            <label class="custom-control-label" :for="'checkk'+ i.title">@{{i.title}}</label>
                        </div>

                    </a>
                </li>
            </ul>
        </div>

    </div>

</div>
