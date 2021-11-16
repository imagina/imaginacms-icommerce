<template>
  <div id="recursiveListOptionsComponent">
    <pre v-if="false">{{ options }}</pre>
    <div v-for="(option, index) in optionsList" v-if="optionsList.length" :key="index">
      <div class="content-option" v-if="option.productOptionValues &&  option.productOptionValues.length">
        <!--Title Option-->
        <div class="title-option mb-2">
          {{ option.description }}
          <!--Label required-->
          <label class="text-danger" v-if="option.required">(requerido)</label>
          <!--Extra price-->
          <label v-if="section[option.id].response.total">
            (+ ${{ new Intl.NumberFormat('en-US').format(section[option.id].response.total) }})
          </label>
        </div>
        <!-- If option type is select -->
        <div v-if="option.type == 'select'">
          <select class="form-control" v-model="section[option.id].singleOption"
                  @change="setOptions(option.id,[section[option.id].singleOption])">
            <option v-for="(selectOption,key) in getOptionsSelect(option.productOptionValues)" :key="key"
                    :disabled="!selectOption.available" :value="selectOption.id">{{ selectOption.label }}
                    {{ !selectOption.available ? '(Agotado)' : ''}}
            </option>
          </select>
        </div>
        <!-- If option type is radio -->
        <div v-if="option.type == 'radio'" class="ml-3">
          <div v-for="(value, key) in option.productOptionValues" :key="key"
               :class="`text-left ${([3,2].indexOf(value.optionValueEntity.options.type) != -1) ? 'd-inline-block' : 'radio-square'}`">
            <!--Color box-->
            <div v-if="value.optionValueEntity.options.type == 3" :title="!value.available ? '(Agotado)' : ''"
                 :class="`box-color ${section[option.id].singleOption == value.optionValueId ? 'box-color-active' : ''}`"
                 v-on:click="value.available ? setOption(option, value.optionValueId) : null"
                 :style="`background-color : ${value.optionValueEntity.options.color}; cursor: ${value.available ? 'pointer' : 'not-allowed'}`"></div>
            <!--Image box-->
            <div v-else-if="value.optionValueEntity.options.type == 2"  :title="!value.available ? '(Agotado)' : ''"
                 :class="`box-image ${section[option.id].singleOption == value.optionValueId ? 'box-image-active' : ''}`"
                 v-on:click="value.available ? setOption(option, value.optionValueId) : null"
                 :style="`background-image : url(${value.optionValueEntity.mainImage.path}); cursor: ${value.available ? 'pointer' : 'not-allowed'}`"></div>
            <!--Input radio-->
            <div v-else>
              <input type="radio" v-model="section[option.id].singleOption"
                     :value="value.optionValueId" :name="option.description"
                     :disabled="!value.available" :title="!value.available ? '(Agotado)' : ''"
                     @change="value.available ? setOption(option, value.optionValueId) : null"/>
              <label style="cursor:pointer;" v-on:click="value.available ? setOption(option, value.optionValueId) : null"
                     :title="!value.available ? '(Agotado)' : ''">
                <span>{{ getLabel(value) }}</span>
              </label>
            </div>
          </div>
        </div>
        <!-- If option type is checkbox -->
        <div v-if="option.type == 'checkbox'" class="ml-3">
          <div v-for="(value, key) in option.productOptionValues" :key="key"
               :class="`text-left ${value.optionValueEntity.options.type != 1 ? 'd-inline-block' : 'radio-square'}`">
            <!--Color box-->
            <div v-if="value.optionValueEntity.options.type == 3" :title="!value.available ? '(Agotado)' : ''"
                 :class="`box-color ${(section[option.id].multiOption.indexOf(value.optionValueId) != -1) ? 'box-color-active' : ''}`"
                 v-on:click="value.available ? setOption(option, value.optionValueId) : null"
                 :style="`background-color : ${value.optionValueEntity.options.color}; cursor: ${value.available ? 'pointer' : 'not-allowed'}`"></div>
            <!--Image box-->
            <div v-else-if="value.optionValueEntity.options.type == 2" :title="!value.available ? '(Agotado)' : ''"
                 :class="`box-image ${(section[option.id].multiOption.indexOf(value.optionValueId) != -1) ? 'box-image-active' : ''}`"
                 v-on:click="value.available ? setOption(option, value.optionValueId) : null"
                 :style="`background-image : url(${value.optionValueEntity.mainImage.path}); cursor: ${value.available ? 'pointer' : 'not-allowed'}`"></div>
            <!--Input checkbox-->
            <div v-else>
              <input type="checkbox" v-model="section[option.id].multiOption"
                     :value="value.optionValueId" :name="option.description"
                     :disabled="!value.available" :title="!value.available ? '(Agotado)' : ''"
                     @change="value.available ? setOption(option, value.optionValueId) : null"/>
              <label style="cursor:pointer;" v-on:click="value.available ? setOption(option, value.optionValueId) : null">
                {{ getLabel(value) }}
              </label>
            </div>
          </div>
        </div>
      </div>
      <!--Children options-->
      <div v-if="section[option.id].singleOption && (option.children && option.children.length)">
        <productOptionValues
            v-model="section[option.id].children"
            @input="vEmit()"
            :options="option.children"
            :additional-price="additionalPrice"
            :parentOptionValueId="section[option.id].singleOption"/>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript" defer>
import _cloneDeep from 'lodash.clonedeep'

export default {
  name: 'productOptionValues',
  components: {},
  props: {
    options: {default: () => []},
    parentOptionValueId: {default: 0,},
    additionalPrice: {default: true}
  },
  watch: {
    options() {
      this.init()
    },
    parentOptionValueId() {
      this.init()
    }
  },
  created() {
    this.init()
  },
  data() {
    return {
      section: {},
      section: {},
      optionsList: []
    }
  },
  computed: {
    initData() {
      return {
        optionId: null,
        singleOption: null,
        multiOption: [],
        selectedOptions: [],
        required: false,
        children: {},
        response: {
          options: [],
          total: 0,
          required: false
        }
      }
    },
  },
  methods: {
    //init component
    init() {
      this.orderOptions()//Order Options
      this.addValuesOption()//add mirror for any section
      this.vEmit()//Emmit
    },
    //Order options acording to parent option value
    orderOptions() {
      this.optionsList = []//Init options list
      let options = _cloneDeep(this.options)
      let parentValue = _cloneDeep(parseInt(this.parentOptionValueId))

      //Get just options that match with parent option value
      if (parentValue) {
        options.forEach((opt, i) => {
          let optionValues = []
          opt.productOptionValues.forEach((optValue, j) => {
            if (parseInt(optValue.parentOptionValueId) == parentValue)
              optionValues.push(options[i].productOptionValues[j])
          })
          options[i].productOptionValues = optionValues
        })
        this.optionsList = _cloneDeep(options)
      } else {//Same options
        this.optionsList = _cloneDeep(this.options)
      }
    },
    //Add values to option
    addValuesOption() {
      this.section = {}//init section
      this.optionsList.forEach(item => {
        let optionData = _cloneDeep(this.initData)
        optionData.required = item.required ? true : false
        optionData.optionId = item.id
        this.$set(this.section, item.id, optionData)
      })
    },
    //Set value option
    setOption(option, value) {
      //Set option check box
      if (option.type == 'checkbox') {
        //Search if exist
        let existIndex = this.section[option.id].multiOption.indexOf(value)
        //Add to response
        if (existIndex != -1) this.section[option.id].multiOption.splice(existIndex, 1)
        //Remove from response
        else this.section[option.id].multiOption.push(value)
        //Set options
        this.setOptions(option.id, this.section[option.id].multiOption)
      } else {//Set others options
        this.section[option.id].singleOption = _cloneDeep(value)
        //Set options
        this.setOptions(option.id, [this.section[option.id].singleOption])
      }
    },
    //Set option
    setOptions(optionId, valuesId) {
      //Reset local values
      let options = _cloneDeep(this.section[optionId].response.options = [])
      let total = _cloneDeep(this.section[optionId].response.total = 0)

      //Add option selected and total
      if (valuesId.length) {
        let option = _cloneDeep(this.optionsList.find(item => item.id == optionId))
        valuesId.forEach(valueId => {
          if (valueId) {
            let value = option.productOptionValues.find(item => item.optionValueId == valueId)
            options.push(value)//add option
            //Sum or less to total
            total += parseInt(value.pricePrefix + value.price)
          }
        })
      }
      //Set new values to response
      this.section[optionId].response.options = _cloneDeep(options)
      this.section[optionId].response.total = _cloneDeep(total)
      this.vEmit()//Emmit result
    },
    //Conver options to format select
    getOptionsSelect(options) {
      if (options && options.length) {
        let response = options.map(item => {
          return {label: item.optionValue, id: item.optionValueId, available: item.available}
        })
        //Add price to label
        /*response.forEach((item, index) => {
          let valueOption = options.find(opt => opt.optionValueId == item.id)
          if (valueOption && this.additionalPrice) {
            response[index].label +=
              ('  (' + valueOption.pricePrefix + '$' + valueOption.price + ')')
          }
        })*/
        return response
      } else return []
    },
    //Return label with price
    getLabel(data) {
      return data.optionValue
      /*if (this.additionalPrice) return `${data.optionValue} (${data.pricePrefix}$${data.price})`
      else return data.optionValue*/
    },
    //Emit options selected and total
    vEmit() {
      var sections = _cloneDeep(this.section)
      var options = []
      var total = 0
      var required = false

      //Order options selected
      Object.values(sections).forEach(section => {
        let isSelected = (section.singleOption || section.multiOption.length) ? true : false
        options = options.concat(section.response.options)//add all options
        total += parseInt(section.response.total)//Sum total
        let option = this.optionsList.find(item => item.id == section.optionId)
        if (!isSelected && section.required && option.productOptionValues && option.productOptionValues.length)
          required = true//Set required

        //Merge with response of children
        if (isSelected && section.children.options)
          options = options.concat(section.children.options)
        if (isSelected && section.children.total)
          total += parseInt(section.children.total)
        if (isSelected && section.children.required) required = true
      })

      //Emmit response
      this.$emit('input', {options: options, total: total, required: required})
    },
  },
}
</script>

<style>
#recursiveListOptionsComponent .content-option {
  padding: 10px 0px;
}

#recursiveListOptionsComponent .title-option {
  text-transform: capitalize;
  font-size: 14px;
  text-align: left;
}

#recursiveListOptionsComponent .box-color {
  height: 30px;
  width: 30px;
  border-radius: 50%;
  display: inline-block;
  cursor: pointer;
  margin: 5px 15px 5px 0;
}

#recursiveListOptionsComponent .box-color-active:before {
  display: inline-block;
  content: '';
  height: 40px;
  width: 40px;
  border: 2px solid #3a8051;
  border-radius: 50%;
  margin-left: -5px;
  margin-top: -5px;
}

#recursiveListOptionsComponent .box-image {
  height: 50px;
  width: 50px;
  display: inline-block;
  cursor: pointer;
  margin: 5px 15px 5px 0;
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
}

#recursiveListOptionsComponent .box-image-active:before {
  display: inline-block;
  content: '';
  height: 60px;
  width: 60px;
  border: 2px solid #3a8051;
  margin-left: -5px;
  margin-top: -5px;
}
</style>
