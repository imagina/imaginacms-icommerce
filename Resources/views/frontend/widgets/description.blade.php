<div class="tab-pane active " id="descripcion" role="tabpanel">
    <h3>TAMAÑO:</h3>
        <p>Alto: @{{product.height}}cm</p>
        <p>Ancho: @{{product.width}}cm</p>
        <p>Frente: 15 cm</p>
	    <div class="icommerce-options" v-if="product.productOptions.length!=0" v-for="item in product.productOptions">
	    	<h3>@{{item.description}}</h3>    	
	    	<p><span v-if="product.optionValues.length!=0 && item2.optionId==item.optionId" v-for="item2 in product.optionValues">- @{{item2.optionValue}}. </span></p>       
	    </div>
</div>