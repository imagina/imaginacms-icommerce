<div id="cardBillingDetails" class="card card-block p-3 mb-3">
  <div class="row m-0 pointer" data-toggle="collapse" href="#PaymentAddress" role="button" aria-expanded="false"
       aria-controls="PaymentAddress">
    <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-2">
      {{ config('asgard.icommerce.config.infoCardCheckout.billingDetails.numberPosition')}}
    </div>
    <h3 class="d-flex align-items-center my-1 h5">
      {{ trans('icommerce::billing_details.title') }}
    </h3>
  
    @if($errors->has('billingAddress'))
      <br/>
      <span class="alert alert-danger" role="alert">{{ $errors->first('billingAddress') }}</span>
    @endif
  </div>
  
  
  {{--
    <a href="#" id="expandBillingDetails">{{ trans('icommerce::billing_details.form.expand_form') }}</a>
    --}}
  
  <div class="showBilling collapse show" id="PaymentAddress" role="tablist" aria-multiselectable="true">
    <hr class="my-2"/>
  
    @include("icommerce::frontend.livewire.checkout.partials.billing-details")
  </div>

</div>
