<div id="cartLayout1" class="dropdown">

  @include("icommerce::frontend.livewire.cart.layouts.$layout.button")
  
  @if(isset($cart->id))
    @include('icommerce::frontend.livewire.cart.dropdown')
  @endif
 
</div>

@section('scripts-owl')
  @parent
  <script type="text/javascript">
  
  $(document).ready(function () {
    window.livewire.emit('refreshCart');
  });
  </script>
@stop