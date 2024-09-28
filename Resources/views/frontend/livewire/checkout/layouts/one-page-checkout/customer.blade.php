<div id="cardCustomerData" class="card card-block p-3 mb-3">
  <div class="row m-0 pointer" data-toggle="collapse" href="#customerData" role="button" aria-expanded="false"
       aria-controls="customerData">
    <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-2">
      {{ config('asgard.icommerce.config.infoCardCheckout.customerData.numberPosition')}}
    </div>
    <h3 class="d-flex align-items-center my-1 h5">
      {{ trans('icommerce::customer.title') }}
    </h3>

    @if($errors->has('userId'))
      <br/>
      <span class="alert alert-danger" role="alert">{{ $errors->first('userId') }}</span>
    @endif
  </div>
  <div id="customerData" class="collapse show" role="tablist" aria-multiselectable="true">
    @if (!$guestShopOnly && setting('icommerce::enableGuestShopping', null, true))
      @guest
        <hr class="my-2"/>
        <button wire:click.prevent="shopAsGuest"
                class="btn btn-xs btn-primary" name="button">
          @if (!$shopAsGuest)
            {{trans('icommerce::customer.form.textButtonShopAsGuest')}}
          @else
            {{trans('icommerce::customer.form.textButtonShopAsUser')}}
          @endif
        </button>
      @endguest
    @endif
    @if ($shopAsGuest && setting('icommerce::enableGuestShopping', null, true))
      <hr class="py-2"/>
      <input id="userEmail" wire:model.defer="userEmail"
             placeholder="{{trans('icommerce::checkout.buttons.placeholderInputEmail')}}" class="form-control"
             type="text">
    @else
      @guest
        <div class="card mb-0 border-0">
          <div class="col py-2">
            @php $reedirectUrl = "/ipanel/#/auth/login/?redirectTo=".url(route($locale . '.icommerce.store.checkout')); @endphp
            <a class="btn btn-sm btn-outline-primary" onclick="location.href='{{$reedirectUrl}}'">
              <i class="fa-solid fa-user"></i>
              {{ trans('icommerce::customer.sub_titles.logging') }}
            </a>
          </div>
        </div>
      @endguest
      @include("icommerce::frontend.livewire.checkout.partials.customer-logged")
    @endif
  </div>
</div>
