<div id="btn-continue-buying-up" class="row">
  <div class="col py-2">
    <a class="btn btn-primary-ecommerce waves-effect waves-light"
       href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
  </div>
</div>

@php
  $stepNumberCard = 1;
  $validateCards = [
      'shipping-methods' => $requireShippingMethod,
      'shipping-details' => $requireShippingMethod,
  ];
@endphp

<div class="row">
  @php($columns = config('asgard.icommerce.config.onePageCheckout.columns'))
  @foreach($columns as $colum)
    <div class="{{$colum['class']}}">
      @foreach($colum['cards'] as $card)
        @if($card == 'order-summary')
          @include('icommerce::frontend.livewire.checkout.partials.order-summary')
        @elseif($validateCards[$card] ?? true)
          @include('icommerce::frontend.livewire.checkout.layouts.one-page-checkout.' . $card, [
              'StepNumberCard' => $stepNumberCard,
          ])
          @php($stepNumberCard++)
        @endif
      @endforeach
    </div>
  @endforeach
</div>

<div class="row">
  <div class="col py-2">
    <a class="btn btn-primary-ecommerce" href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
  </div>
</div>
