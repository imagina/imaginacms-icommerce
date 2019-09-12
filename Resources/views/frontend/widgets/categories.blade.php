
<div class="container" id=category>
    <div class="row" >
        <div class="filter-order col-md-3 col-6" v-for="(category,index) in categories" v-if="categories && categories.length>0" >
            
        <a data-toggle="collapse" v-if="category.childrens && category.childrens.length>0 " v-bind:href="'#category-'+category.id" role="button" aria-expanded="false" v-bind:aria-controls="'category-'+category.id"><h3>@{{category.title}}</h3></a>
 
            <a  @click="loadCategory(category)"  v-else>
         
              <h3>@{{category.title}}</h3>
            </a>

            <div class="collapse multi-collapse" v-for='i in category.childrens' v-bind:id="'category-'+category.id">
 
                   <a class="d-block w-100" @click="loadCategory(i)" >@{{i.title}}.</a>
                   
            </div>
            

        </div>

        
        <div v-else class="list-group-item px-0">
          No posee categorías
        </div>

    </div>
    
        </div>