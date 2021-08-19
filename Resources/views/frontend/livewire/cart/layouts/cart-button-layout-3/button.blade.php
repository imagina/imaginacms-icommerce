<a class="cart-link"  data-toggle="modal" data-target="#modalCart">
  
  <div class="cart">
   
    <span class="quantity">
       @if(!isset($cart->quantity))
        <i class="fa fa-spinner fa-pulse fa-fw"></i>
      @else
        {{  $cart->quantity  }}
      @endif
    </span>
    
    <i class="{{$icon,$iconquote}}"></i>
  </div>

</a>