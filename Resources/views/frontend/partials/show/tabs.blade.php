
<!--TODO falta verificar qué hacer con este codigo comentado hecho en vue
<div>
    <h6 class="options" v-if="product.weight || product.length || product.width || product.heigth">TAMAÑO:</h6>
    <p class="icommerce-option" v-if="product.weight"> {{trans('icommerce::products.table.weight')}}
        :@{{product.weight}}</p>
    <p class="icommerce-option" v-if="product.length"> {{trans('icommerce::products.table.length')}}
        :@{{product.length}}</p>
    <p class="icommerce-option" v-if="product.width"> {{trans('icommerce::products.table.width')}}
        :@{{product.width}}</p>
    <p class="icommerce-option" v-if="product.heigth"> {{trans('icommerce::products.table.heigth')}}
        :@{{product.heigth}}</p>

</div>


<div v-if="product.productOptions.length && product.optionValues.length"
     v-for="(option,index) in product.productOptions">
    <h6 class="options">@{{option.description}}:</h6>
    <div>
        <p><span v-for="(value,index) in product.optionValues"
                 v-if="value.optionId==option.optionId">- @{{value.optionValue}} </span>
        </p>
    </div>
</div>
-->

<div class="description">
    <h3>DESCRIPCION:</h3><p>{!! $product->description !!}</p>
</div>

<div class="icommerce-options ">
    
    @isset($product->manufacturer->id)
    <p class="icommerce-option"><b>
            {{trans('icommerce::products.table.manufacturer')}}:</b> <span>{{$product->manufacturer->name}}</span>
    </p>
    
    @endisset
    
    @isset($product->pdf)
    <p class="icommerce-option" >
        
        <a href="{{$product->pdf}}" target="_blank" class="d-block icommerce-pdf">
            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
            <span>{{trans('icommerce::products.messages.product_brochure')}}</span>
        </a>
    </p>
        @endisset
</div>

