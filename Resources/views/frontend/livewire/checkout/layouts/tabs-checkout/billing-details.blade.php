<div class="card-ckeckout card-billing-details mb-3">

    <h4 class="ckeckout-subtitle my-1 font-weight-bold">
        {{ trans('icommerce::billing_details.title') }}
    </h4>

    <div class="showBilling" id="PaymentAddress">
        <hr class="my-2"/>
        
        @include("icommerce::frontend.livewire.checkout.partials.billing-details")
        
    </div>

</div>
