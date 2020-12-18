<div class="infor">
  
  <div class="card-product">
    <div class="cursor-pointer position-relative">
      @if(!isset($productListLayout) || $productListLayout!='one')

        <div class="bg-img d-flex justify-content-center align-items-center overflow-hidden">
           <x-media-single-image :alt="$product->name" :title="$product->name" :url="$product->url" :isMedia="true"
                                  :mediaFiles="$product->mediaFiles()"/>
        </div>

      @endif
      <div class="card-overlay text-center">
        
        <div class="top">
          <a href="{{ $product->url }}"
             class="btn btn-warning btn-circle text-white mx-2 rounded-circle cursor-pointer">
            <i class="fa fa-search"></i>
          </a>
          <a onClick="window.livewire.emit('addToWishList',{{$product->id}})"
             class="btn btn-warning btn-circle text-white mx-2 rounded-circle cursor-pointer">
            <i class="fa fa-heart-o"></i>
          
          </a>
        </div>
        
        <div class="bottom">
          @if($product->price>0  && $product->stock_status && $product->quantity)
            <a  onClick="window.livewire.emit('addToCart',{{$product->id}})" class="btn btn-warning px-4 text-white cursor-pointer">
              <i class="fa fa-shopping-basket"></i>
              COMPRAR
            </a>
          @else
            <a href="/contacto" class="btn btn-warning px-4 text-white cursor-pointer">
              <i class="fa fa-envelope"></i> CONTACTANOS
            </a>
          @endif
        </div>
      
      </div>
    
    </div>
    
    <div class="mt-3 pb-3">
      
      <a href="{{$product->url}}" class="name cursor-pointer d-block text-uppercase text-center">
        {{$product->name}}
      </a>
      
      <div class="category text-center">{{$product->category->title}}</div>
      
      @if(isset($productListLayout) && $productListLayout=='one')
        <div class="summary">
          {{$product->summary}}
        </div>
      @endif
      
      <div class="price text-center">
        
        {{isset($currency) ? $currency->symbol_left : '$'}}
        {{formatMoney($discount->price ?? $product->price)}}
        
        @if(isset($discount) && $discount)
          <del>{{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($product->price) }}</del>
        
        @endif
      
      </div>
    
    </div>
    @if($addToCartWithQuantity)
      @if($product->price>0 && $product->stock_status && $product->quantity)
        <div class="row add-to-cart-with-quantity">
          <!-- BUTTON QUANTITY -->
          <div class="number-input input-group quantity-selector">
            <input type="button" value="-" class="button-minus" data-field="quantity">
            <input type="number" step="1" max="" value="1" name="quantity" class="quantity-field"
                   id="quantityField{{$product->id}}">
            <input type="button" value="+" class="button-plus" data-field="quantity">
          </div>
        
          <!-- BUTTON ADD -->
          <div class="add-to-cart-button">
            <a onClick="addToCart({{$product->id}})" class="btn btn-primary">
              <i class="fa fa-shopping-cart"></i>Comprar
            </a>
          </div>
      
        </div>
      @endif
    @endif
  </div>
</div>


@section('scripts')
  @parent
  <script>
    
    function incrementValue(e) {
      e.preventDefault();
      var fieldName = $(e.target).data('field');
      var parent = $(e.target).closest('div');
      var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
      
      if (!isNaN(currentVal)) {
        parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
      } else {
        parent.find('input[name=' + fieldName + ']').val(0);
      }
    }
    
    function decrementValue(e) {
      e.preventDefault();
      var fieldName = $(e.target).data('field');
      var parent = $(e.target).closest('div');
      var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
      
      if (!isNaN(currentVal) && currentVal > 0) {
        parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
      } else {
        parent.find('input[name=' + fieldName + ']').val(1);
      }
    }
    
    function addToCart(productId) {
      let quantity = $('#quantityField' + productId).val();
      window.livewire.emit('addToCart', productId, quantity)
      $('#quantityField' + productId).val(1)
    }
    
    $('.input-group').on('click', '.button-plus', function (e) {
      incrementValue(e);
    });
    
    $('.input-group').on('click', '.button-minus', function (e) {
      decrementValue(e);
    });
  
  </script>

@stop