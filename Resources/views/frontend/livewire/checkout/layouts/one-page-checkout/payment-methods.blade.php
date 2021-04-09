
<div class="card card-block p-3  mb-3">
    <div class="row">
        <div class="col">
            <div class="row m-0 pointer">
                <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-2">
                    {{$step}}
                </div>
                <h3 class="d-flex align-items-center h5">
                    {{ trans('icommerce::paymentmethods.title.paymentmethods') }}
                </h3>
    
                @if($errors->has('paymentMethod'))
                    <br/>
                    <span class="alert alert-danger" role="alert">{{ $errors->first('paymentMethod') }}</span>
                @endif
            </div>


            <div id="PaymentList">
                <hr class="my-2" />
                @include("icommerce::frontend.livewire.checkout.partials.payment-methods-list")
            </div>
        </div>

    </div>
</div>
