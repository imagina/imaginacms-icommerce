  
<div class="card card-block p-3  mb-3">
  <div class="row">
      <div class="col">
          <div class="row m-0">
              <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-1">
                      5
              </div>
              <h3 class="d-flex align-items-center">
                  {{ trans('icommerce::payment.title') }}
              </h3>
          </div>

          <hr class="my-2" />

          <div id="PaymentList" role="tablist" aria-multiselectable="true">
            
            <div class="card mb-0 border-0" v-for="(payment,index) in payments" >
              <div class="card-header bg-white" role="tab" id="headingOne">
                <label class="mb-0">
                  <input type="radio" class="form-check-input" name="payment_method" id="" :value="payment.configName" data-parent="#PaymentList" data-toggle="collapse" :data-target="'#payment'+index" aria-expanded="true" :aria-controls="'payment'+index" v-model="paymentSelected">
                   @{{payment.configTitle}}
                </label>
                <img :src="payment.image" class="w-75 img-responsive float-right">
              </div>

              <div :id="'payment'+index" class="collapse" role="tabpanel" :aria-labelledby="'heading'+index">
                <div class="card-block">
                  @{{payment.description.en}}
                </div>
              </div>
            </div>
            
            <input type="hidden" name="payment_code" :value="paymentSelected">
          </div>
      </div>

  </div>
</div>