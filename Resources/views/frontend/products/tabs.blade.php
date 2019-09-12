    <div>
        <h3>TAMAÑO:</h3>
    <p class="icommerce-option" v-if="product.weight"> {{trans('icommerce::products.table.weight')}}:@{{product.weight}}</p>
    <p class="icommerce-option" v-if="product.length"> {{trans('icommerce::products.table.length')}}:@{{product.length}}</p>
    <p class="icommerce-option" v-if="product.width"> {{trans('icommerce::products.table.width')}}:@{{product.width}}</p>
    <p class="icommerce-option" v-if="product.heigth"> {{trans('icommerce::products.table.heigth')}}:@{{product.heigth}}</p>

    </div>
                         
    <div v-if="product.productOptions.length>0 && product.optionValues.length>0" class="" v-for="(option,index) in product.productOptions">
        <h3 class="text-uppercase">@{{option.description}}:</h3>
        <div >  
            <p ><span v-for="(value,index) in product.optionValues" v-if="value.optionId==option.optionId && index<product.option.length">-@{{value.optionValue}} </span></p>
        </div>
    </div>
    
{{--
    <div class="col description" v-html="product.description">
       <h3>DESCRIPCION:</h3><p>@{{ product.description }}</p>
    </div>

    <div class="icommerce-options">               
        <p class="icommerce-option" v-if="product.manufacturer"><b>
            {{trans('icommerce::products.table.manufacturer')}}:</b> <span>@{{product.manufacturer}}</span>
        </p>
        <p class="icommerce-option" v-if="product.category"><b>
            {{trans('icommerce::products.table.category')}}:</b> <span>@{{product.category.title}}</span>
        </p>        
        <p class="icommerce-option" v-if="product.shipping=='NO'"><b>
                {{trans('icommerce::products.table.shipping')}}:</b> <span>@{{product.shipping}}</span>
            </p>
            <p class="icommerce-option" v-if="product.shipping!='NO'"><b>
                {{trans('icommerce::products.table.shipping')}}:</b> <span>{{trans('icommerce::coupons.table.yes')}}</span>
            </p>
         <p class="icommerce-option" v-if="product.pdf">
                
            <a  v-bind:href="product.pdf" target="_blank" class="d-block icommerce-pdf">
                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                <span>{{trans('icommerce::products.messages.product_brochure')}}</span>
            </a>
        </p>
    </div>
--}}