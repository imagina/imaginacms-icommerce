<div id="cartLayout2" class="dropdown {{!$showButton ? 'd-none' : ''}}">

  @include("icommerce::frontend.livewire.cart.layouts.$layout.button")

  @if(isset($cart->id))
    @include('icommerce::frontend.livewire.cart.dropdown')
  @endif
</div>

@include("icommerce::frontend.livewire.cart.quoteModal")

@section('scripts-owl')
@parent
  <script type="text/javascript" defer>
    $(document).ready(function () {
      window.livewire.emit('refreshCart');
    });
  </script>
<style>
  #cartLayout2 .cart .quantity:before {
    content: '(';
  }
  #cartLayout2 .cart .quantity:after {
    content: ')';
  }

</style>
@stop
