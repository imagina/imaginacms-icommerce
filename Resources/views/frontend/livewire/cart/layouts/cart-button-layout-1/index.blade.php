<div wire:init="refreshCart" id="cartLayout1" class="dropdown {{!$showButton ? 'd-none' : ''}}">

  @include("icommerce::frontend.livewire.cart.layouts.$layout.button")

  @if(isset($cart->id))
    @include('icommerce::frontend.livewire.cart.dropdown')
  @endif
</div>

@include("icommerce::frontend.livewire.cart.quoteModal")

@section('scripts-owl')
  @parent
  <style>
    #cartLayout1 .cart {
      width: 22px;
    }
    #cartLayout1 .cart .quantity {
      width: 18px;
      height: 18px;
      position: absolute;
      border-radius: 50%;
      right: 7px;
      top: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.688rem;
      font-weight: bold;
      background: var(--primary);
    }

  </style>
@stop
