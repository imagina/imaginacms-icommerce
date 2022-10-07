<hr>
<div class="row">
  <div class="col pb-5">

    <div class="wizard-checkout">
      <div wire:ignore.self class="wizard-checkout-inner">
        <ul class="nav nav-tabs nav-justified @if (!$shopAsGuest) @guest guest @endguest @endif" role="tablist">
          <li role="presentation" class="uno nav-item {{$step == 1 ? 'active' : 'disabled'}}">
            <a class="nav-link" href="#step1" data-toggle="tab" aria-controls="step1" role="tab" wire:click="setStep(1)"
               aria-expanded="true">
              <span class="round-tab">1</span>
              @if($errors->has('userId'))
                <i class="fa fa-exclamation-triangle text-warning d-inline-block" aria-hidden="true"></i>
              @endif <span>{{trans("icommerce::checkout.tabs.firstTab")}}</span>
            </a>
          </li>
          <li role="presentation" class="dos nav-item {{$step == 2 ? 'active' : 'disabled'}}">
            <a class="nav-link" href="#step2" data-toggle="tab" aria-controls="step2" role="tab" wire:click="setStep(2)"
               aria-expanded="false">
              <span class="round-tab">2</span>
              @if($errors->has('billingAddress') || $errors->has('paymentMethod'))
                <i class="fa fa-exclamation-triangle text-warning d-inline-block" aria-hidden="true"></i>
              @endif <span>{{trans("icommerce::checkout.tabs.secondTab")}}</span>
            </a>
          </li>
          @if($requireShippingMethod)
            <li role="presentation" class="tres nav-item {{$step == 3 ? 'active' : 'disabled'}}">
              <a class="nav-link" href="#step3" data-toggle="tab" aria-controls="step3" role="tab"
                 wire:click="setStep(3)"
                 aria-expanded="false">
                <span class="round-tab">3</span>
                @if($errors->has('shippingAddress') || $errors->has('shippingMethod'))
                  <i class="fa fa-exclamation-triangle text-warning d-inline-block" aria-hidden="true"></i>
                @endif <span>{{trans("icommerce::checkout.tabs.thirdTab")}}</span>
              </a>
            </li>
          @endif
        </ul>
      </div>

      <div class="tab-content">
        <div class="tab-pane {{$step == 1 ? 'active' : ''}}" role="tabpanel" id="step1">
          <div class="tab-content-in py-3 mb-4">
            @include('icommerce::frontend.livewire.checkout.layouts.tabs-checkout.customer')
          </div>
          <div class="text-right">
            <a class="btn btn-outline-primary font-weight-bold mb-3"
               href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
            @if (!$shopAsGuest)
              @auth
              @endif
              <button type="button" class="btn btn-dark next-step mb-3" wire:click="setStep(2)">
                <i class="fa fa-share d-block d-md-none"></i> <span
                  class="d-none d-md-block">{{trans("icommerce::checkout.tabs.next")}}</span>
              </button>
              @if (!$shopAsGuest)
              @endauth
              @guest
              @endif
              <div
                class="btn btn-light border font-weight-bold mb-3 start-step">{{trans("icommerce::checkout.alerts.login_order")}}
              </div>
              @if (!$shopAsGuest)
              @endguest
            @endif
          </div>
        </div>

        <div class="tab-pane {{$step == 2 ? 'active' : ''}}" role="tabpanel" id="step2">
          <div class="tab-content-in py-3 mb-4">
            <div class="row">
              <div class="col-md-6">
                @include('icommerce::frontend.livewire.checkout.layouts.tabs-checkout.billing-details')
              </div>
              <div class="col-md-6">
                @include('icommerce::frontend.livewire.checkout.layouts.tabs-checkout.payment-methods')
              </div>
            </div>
          </div>


          <div class="text-right">
            <a class="btn btn-outline-primary font-weight-bold mb-3"
               href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
            @if (!$shopAsGuest)
              @auth
              @endif
              <button type="button" class="btn btn-dark prev-step mb-3">
                <i class="fa fa-reply d-block d-md-none"></i>
                <span class="d-none d-md-block"
                      wire:click="setStep(1)">{{trans("icommerce::checkout.tabs.previous")}}</span>
              </button>

              @if($requireShippingMethod)
                <button type="button" class="btn btn-dark next-step mb-3">
                  <i class="fa fa-share d-block d-md-none"></i>
                  <span class="d-none d-md-block"
                        wire:click="setStep(3)">{{trans("icommerce::checkout.tabs.next")}}</span>
                </button>
              @endif
              @if (!$shopAsGuest)
              @endauth
              @guest
              @endif
              <div class="btn btn-light border font-weight-bold mb-3 start-step">
                {{trans("icommerce::checkout.alerts.login_order")}}
              </div>
              @if (!$shopAsGuest)
              @endguest
            @endif
          </div>
        </div>

        <div class="tab-pane {{$step == 3 ? 'active' : ''}}" role="tabpanel" id="step3">
          <div class="tab-content-in py-3 mb-4">
            <div class="row">
              <div class="col-md-6">
                @include('icommerce::frontend.livewire.checkout.layouts.tabs-checkout.shipping-details')
              </div>
              <div class="col-md-6">
                @include('icommerce::frontend.livewire.checkout.layouts.tabs-checkout.shipping-methods')
              </div>
            </div>
          </div>

          <div class="text-right">
            <a class="btn btn-outline-primary font-weight-bold mb-3"
               href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
            @if (!$shopAsGuest)
              @auth
              @endif
              <button type="button" class="btn btn-dark prev-step mb-3">
                <i class="fa fa-reply d-block d-md-none"></i> <span class="d-none d-md-block"
                                                                    wire:click="setStep(2)">{{trans("icommerce::checkout.tabs.previous")}}</span>
              </button>
              @if (!$shopAsGuest)
              @endauth
              @guest
              @endif
              <div class="btn btn-light border font-weight-bold mb-3 start-step">
                {{trans("icommerce::checkout.alerts.login_order")}}
              </div>
              @if (!$shopAsGuest)
              @endguest
            @endif
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <div class="col-md-4 pb-5">
    @include('icommerce::frontend.livewire.checkout.partials.order-summary')
  </div>
</div>



