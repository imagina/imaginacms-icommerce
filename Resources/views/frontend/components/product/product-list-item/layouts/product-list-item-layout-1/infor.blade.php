<div class="infor">
  
  <a class="title" href="{{$product->url}}">{{$product->name}}</a>
  
  <div class="category">{{$product->category->title}}</div>
  
  @if(isset($productListLayout) && $productListLayout=='one')
    <div class="summary">
      {{$product->summary}}
    </div>
  @endif
  
  
  @if(isset($discount) && $discount)
    <div class="del-price">
      <del>{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
    </div>
  @endif
  
  
  <div class="row align-items-end">
    <div class="col col-price">
      <div class="price">
        {{isset($currency) ? $currency->symbol_left : '$'}}
        {{formatMoney($discount->price ?? $product->price)}}
      </div>
    </div>
    
    <div class="col-auto col-buttons">
      
      <div class="buttons">
        @if($product->price>0  && $product->stock_status && $product->quantity)
          <a class="add-cart" onClick="window.livewire.emit('addToCart',{{$product->id}})">
            <i class="fa fa-shopping-basket"></i>
          </a>
        @endif
        <a class="wishlist" href="#">
          <i class="fa fa-heart-o"></i>
        </a>
      </div>
    
    </div>
  
  </div>
  @if($addToCartWithQuantity)
    @if($product->price>0 && $product->stock_status && $product->quantity)
      <div class="row add-to-cart-with-quantity">
        <!-- BUTTON QUANTITY -->
        <div class="number-input input-group{{$product->id}} quantity-selector">
          <input type="button" value="-" class="button-minus button-minus-{{$product->id}}" data-field="quantity">
          <input type="number" step="1" max="" value="1" name="quantity" class="quantity-field"
                 id="quantityField{{$product->id}}">
          <input type="button" value="+" class="button-plus button-plus-{{$product->id}}" data-field="quantity">
        </div>
        
        <!-- BUTTON ADD -->
        <div class="add-to-cart-button">
          <a onClick="addToCart()" class="btn btn-primary">
            <i class="fa fa-shopping-cart"></i>Comprar
          </a>
        </div>
      
      </div>
    @endif
  @endif


</div>


@section('scripts')
  @parent
  <script>
    
    
    function addToCart() {
      let quantity = $('#quantityField' + productId).val();
      window.livewire.emit('addToCart', {{$product->id}}, quantity)
      $('#quantityField{{$product->id}}' ).val(1)
    }
    
    $('.input-group{{$product->id}}').on('click', '.button-plus-{{$product->id}}', function (e) {
      e.preventDefault();
      var currentVal = parseInt($('#quantityField{{$product->id}}').val(), 10);
  
      if (!isNaN(currentVal)) {
        $('#quantityField{{$product->id}}').val(currentVal + 1);
      } else {
        $('#quantityField{{$product->id}}').val(0);
      }
    });
    
    $('.input-group{{$product->id}}').on('click', '.button-minus-{{$product->id}}', function (e) {
      e.preventDefault();
      var currentVal = parseInt($('#quantityField{{$product->id}}').val(), 10);
  
      if (!isNaN(currentVal) && currentVal > 0) {
        $('#quantityField{{$product->id}}').val(currentVal - 1);
      } else {
        $('#quantityField{{$product->id}}').val(1);
      }
    });
  
  </script>

@stop