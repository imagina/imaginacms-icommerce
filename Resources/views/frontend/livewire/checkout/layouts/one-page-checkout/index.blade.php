<div id="btn-continue-buying-up" class="row">
  <div class="col py-2">
    <a class="btn btn-primary waves-effect waves-light"
       href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
  </div>
</div>

<div class="row">
  @php($columns = config('asgard.icommerce.config.onePageCheckout.columns'))
  @foreach($columns as $colum)
    <div class="{{$colum['class']}}">
      @foreach($colum['cards'] as $card)
        @if($card == 'order-summary')
          @include('icommerce::frontend.livewire.checkout.partials.order-summary')
        @else
          @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.' . $card)
        @endif
      @endforeach
    </div>
  @endforeach


</div>
<div class="row">
  <div class="col py-2">
    <a class="btn btn-primary" href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
  </div>
</div>


{{--<script>--}}
{{--  $(document).ready(function () {--}}
{{--    $colum1 = document.querySelector('.colum-1');--}}
{{--    $cardPaymentAddress = document.querySelector('#cardPaymentAddress');--}}
{{--    $colum1.appendChild($cardPaymentAddress)--}}

{{--    $colum2 = document.querySelector('.colum-2');--}}
{{--    $cardShippingMethods = document.querySelector('#cardShippingMethods');--}}
{{--    $colum2.appendChild($cardShippingMethods)--}}

{{--    $cardPaymentMethods = document.querySelector('#cardPaymentMethods');--}}
{{--    $colum2.appendChild($cardPaymentMethods)--}}
{{--  })--}}
{{--</script>--}}
