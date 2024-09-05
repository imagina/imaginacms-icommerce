<div class="card-ckeckout card-customer mb-3">
  @if($errors->has('userId'))
    <br/>
    <span class="alert alert-danger" role="alert">{{ $errors->first('userId') }}</span>
  @endif
  @if (!$guestShopOnly && setting('icommerce::enableGuestShopping', null, true))
    @guest
      <hr class="my-2"/>
      <button wire:click.prevent="shopAsGuest"
              class="btn btn-sm btn-primary" name="button">
        @if (!$shopAsGuest){{trans('icommerce::customer.form.textButtonShopAsGuest')}}
        @else {{trans('icommerce::customer.form.textButtonShopAsUser')}}@endif
      </button>
    @endguest
  @endif
  @if ($shopAsGuest && setting('icommerce::enableGuestShopping', null, true))
    <hr class="py-2"/>
    <input id="userEmail" wire:model.defer="userEmail"
           placeholder="{{trans('icommerce::checkout.buttons.placeholderInputEmail')}}" class="form-control"
           type="text">
  @else
    <hr class="my-2"/>
    <div id="customerData" class="row">
      @if (!$shopAsGuest)
        @guest
        @endif
        <div class="col-md-6">
          <div class="card mb-0 border-0">
              <div class="col py-2">
                  @php $reedirectUrl = "/ipanel/#/auth/login/?redirectTo=".url(route($locale . '.icommerce.store.checkout')); @endphp
                  <a class="btn btn-sm btn-outline-primary" onclick="location.href='{{$reedirectUrl}}'">
                      <i class="fa-solid fa-user"></i>
                      {{ trans('icommerce::customer.sub_titles.logging') }}
                  </a>
              </div>
          </div>
        </div>
        @if (!$shopAsGuest)
        @endguest
      @endif
      @include("icommerce::frontend.livewire.checkout.partials.customer-logged")
    </div>
  @endif
</div>
