@section('style')
<style >
  .cc-selector input {
  margin: 0;
  padding: 0;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
}


.cc-selector input:active +.drinkcard-cc {
  opacity: .9;
}

.cc-selector input:checked +.drinkcard-cc {
  -webkit-filter: none;
  -moz-filter: none;
  filter: none;
}

.drinkcard-cc {
  cursor: pointer;
  display: inline-block;
  border-radius:50%;  
}
.cc-selector{
    padding-bottom: 5px;
    display: inline-flex;
    margin: 2px;

  border-bottom:2px solid transparent;
}
.cc-selector:hover {
  border-bottom:2px solid #000;
}

 
</style>

@endsection

<div v-if="product.productOptions.length>0 && product.optionValues.length>0" class="mb-3 d-flex" v-for="(option,index) in product.productOptions">
        <h3 class=" mr-3 text-capitalize">@{{option.description}}:</h3>
         <!-- If option type-->
        <div v-for="(value,indexOptValue) in product.optionValues" v-if=" option.type=='radio'">  
           <!-- If Description is Color-->
          <div v-if="option.description=='colores'|| option.optionId==1 ">
            <div class="cc-selector" >
              <input :id="value.optionValueId" type="radio" :name="option.description" :value="indexOptValue" v-model="index_product_option_value_selected" @change="update_product(index, indexOptValue)" :id="value.id"/>
               <label class="drinkcard-cc" :for="value.optionValueId" 
              :style="'background-image: url('+value.mainImage.path+'); width:25px;height:25px;'"></label>
            </div>
          </div>
          <!--End Description Color-->
           <div v-else>
             <div class="custom-control custom-radio mb-2 ml-4">

                <input type="radio" :name="option.description" :value="indexOptValue" v-model="index_product_option_value_selected" @change="update_product(index, indexOptValue)" :id="value.id" class="custom-control-input">

                <label class="custom-control-label" :for="value.id">
                            
                  <span v-if="value.mainImage.path== url+'/modules/iblog/img/post/default.jpg'">
                    @{{value.description}}
                  </span>
                  <span v-else :style="{ backgroundColor: value.option.background, backgroundImage: 'url(' + value.mainImage.path + ')' }">
                    &nbsp;
                  </span>
                </label> 
              </div>
           </div>

        </div>




         <!-- end option type-->
</div>
