<div class="card card-block p-3 mb-3">
    <div class="row m-0 pointer card-number-text">
        <div class="number-check"> {{$step}} </div>
        <h3 class="d-flex align-items-center my-1 h5">
            {{ trans('icommerce::paymentmethods.title.paymentmethods') }}
        </h3>
        @if($errors->has('paymentMethod'))
            <br/>
            <span class="alert alert-danger" role="alert">{{ $errors->first('paymentMethod') }}</span>
        @endif
    </div>
    <div class="row">
        <div class="col">
            <div id="PaymentList">
                <hr class="my-2" />
                @include("icommerce::frontend.livewire.checkout.partials.payment-methods-list")
            </div>
        </div>
    </div>
</div>