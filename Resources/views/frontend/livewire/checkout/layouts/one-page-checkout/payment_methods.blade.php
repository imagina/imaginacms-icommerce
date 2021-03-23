
<div class="card card-block p-3  mb-3">
    <div class="row">
        <div class="col">
            <div class="row m-0 pointer" data-toggle="collapse" href="#PaymentList" role="button" aria-expanded="false" aria-controls="PaymentList">
                <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-2">
                    {{$step}}
                </div>
                <h3 class="d-flex align-items-center h5">
                    {{ trans('icommerce::paymentmethods.title.paymentmethods') }}
                </h3>
            </div>


            <div id="PaymentList" class="collapse show"  role="tablist" aria-multiselectable="true">
                <hr class="my-2" />
                @foreach($paymentMethods as $key => $paymentMethod)
                <div class="card mb-0 border-0">
                    <div class="card-header bg-white" role="tab" id="headingOne">
                        <label class="mb-0">
                            <input type="radio" class="form-check-input" name="payment_method"
                                   value="{{$paymentMethod->id}}"
                                   wire:model="paymentMethodSelected">

                            {{$paymentMethod->title}}
                        </label>
                        @php($mediaFiles = $paymentMethod->mediaFiles())
                        @if(isset($mediaFiles->mainimage->relativeMediumThumb) && !strpos($mediaFiles->mainimage->relativeMediumThumb,"default.jpg"))
                        <img src="{{$mediaFiles->mainimage->relativeMediumThumb}}" class="img-responsive float-right" style="max-height: 100px; width: auto; max-width: 60%;">
                            @endif
                    </div>

                        <div class="card-block">
                            {!! $paymentMethod->description !!}
                        </div>

                </div>
                @endforeach
                <input type="hidden" name="payment_code" :value="paymentSelected">
            </div>
        </div>

    </div>
</div>
