<div v-if="options.length>0" class="card border-0 card-items mb-3">
  <div class="card-header text-uppercase bg-primary  py-2 px-3 text-white">
      OPTIONS
  </div>
  <div class="mb-1" v-if="option.option_value.length>0" v-for="option in options">
    <select class="custom-select form-control" @change="getValues">
      <option selected :value="0" disabled="">@{{option.description}}</option>
      <option :value="optionvalue.id" :data-optionDesc="option.description" v-for="optionvalue in option.option_value">@{{optionvalue.description}}</option >
    </select>
  </div>
  <div class="mb-2 text-right">
    <button type="button" @click="searchProducts" class="btn btn-secondary rounded-0 mr-2" name="button">SEARCH <i class="fa fa-search"></i></button>
    <button type="button" @click="clearAll" class="btn btn-secondary rounded-0" name="button">CLEAR</button>
  </div>

  <hr>

</div>
