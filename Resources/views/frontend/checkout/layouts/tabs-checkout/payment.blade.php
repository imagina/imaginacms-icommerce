<div class="card-ckeckout card-payment mb-3">

    <h4 class="ckeckout-subtitle my-1 font-weight-bold">
        {{ trans('icommerce::paymentmethods.title.paymentmethods') }}
    </h4>

    <div id="PaymentList" >
        <hr class="my-2"/>
        <div class="card mb-0 border-0" v-for="(payment,index) in payments">
            <div class="card-header bg-white px-0" role="tab" id="'payment-heading'+index">
                <div class="form-check" data-parent="#PaymentList" data-toggle="collapse" :data-target="'#payment'+index"
                     aria-expanded="true" :aria-controls="'payment'+index">
                    <input class="form-check-input" type="radio" name="payment_method" id="" :value="payment.id" v-model="paymentSelected">
                    <label class="form-check-label" >
                        @{{payment.title}}
                    </label>
                </div>
                <img :src="payment.image" class="img-fluid float-right" style="max-height: 50px; width: auto; object-fit: contain;">
            </div>

            <div :id="'payment'+index" class="collapse" role="tabpanel">
                <div class="card-block py-3">
                    @{{payment.description}}
                </div>
            </div>
        </div>

        <input type="hidden" name="payment_code" :value="paymentSelected">
    </div>
</div>

