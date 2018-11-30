<h3 class="mt-3 mb-2 text-uppercase"><span class="badge badge-secondary py-2 px-3">Filter</span></h3>

<div class="accordion accordion-filter mb-4" id="accordionfilter">
    <div class="card border-0" v-for="option in options" v-if="option.type=='select' || option.type=='radio' && option.parent_id==0">
        <div class="card-header bg-white p-0" id="headingColor">
            <h5 class="mb-1">
                <button class="btn btn-link py-0 collapsed" type="button" data-toggle="collapse"
                        :data-target="'#collapse'+option.description" aria-expanded="false" aria-controls="collapsColor">
                    @{{option.description}}
                </button>
            </h5>
        </div>

        <div :id="'collapse'+option.description" class="collapse" aria-labelledby="headingColor"
             data-parent="#accordionfilter">
            <div class="card-body p-0">
              <ul class="list-group list-group-flush">
                <li class="list-group-item px-4 py-2" v-for="optionvalue in option.option_value">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" :value="optionvalue.id" v-model="options_selected" @change="searchProducts()" class="custom-control-input" :id="optionvalue.id">
                    <label class="custom-control-label" :for="optionvalue.id">@{{optionvalue.description}}</label>
                  </div>
                </li>
              </ul>
        </div>
    </div>
    </div>
    <div class="card border-0">
        <div class="card-header bg-white p-0" id="headingClear">
            <h5 class="mb-1">
                <a class="btn btn-link clear py-0" @click="clearAll" href="#">
                    Clear All
                </a>
            </h5>
        </div>
    </div>
</div>
