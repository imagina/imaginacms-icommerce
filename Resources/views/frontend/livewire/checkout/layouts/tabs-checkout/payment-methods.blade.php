<div class="card-ckeckout card-payment mb-3">

    <h4 class="ckeckout-subtitle my-1 font-weight-bold">
        {{ trans('icommerce::paymentmethods.title.paymentmethods') }}
    </h4>
    @if($errors->has('billingAddress'))
        <br/>
        <span class="alert alert-danger" role="alert">{{ $errors->first('billingAddress') }}</span>
    @endif
    @if($errors->has('paymentMethod'))
        <br/>
        <span class="alert alert-danger" role="alert">{{ $errors->first('paymentMethod') }}</span>
    @endif
    <div id="PaymentList">
        @include("icommerce::frontend.livewire.checkout.partials.payment-methods-list")
    </div>
</div>

