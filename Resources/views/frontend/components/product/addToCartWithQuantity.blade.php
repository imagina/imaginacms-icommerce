@if($product->price>0 && $product->stock_status && $product->quantity)
  <div class="row add-to-cart-with-quantity">
    <!-- BUTTON QUANTITY -->
    <div class="number-input input-group quantity-selector">
      <input wire:click="$emit('decrementValue',$event)" type="button" value="-" class="button-minus" data-field="quantity">
      <input type="number" step="1" value="1" name="quantity" class="quantity-field">
      <input wire:click="$emit('incrementValue',$event)" type="button" value="+" class="button-plus" data-field="quantity">
    </div>
    
    <!-- BUTTON ADD -->
    <div class="add-to-cart-button">
      <a wire:click="$emit('addCartWithQuantity',$event)" class="btn btn-primary add-to-cart-with-quantity-button" data-pid="{{$product->id}}">
        <i class="fa fa-shopping-cart"></i>Comprar
      </a>
    </div>
  
  </div>

  @once
@section('scripts-owl')
  @parent
  <script>
    
    function icommerce_incrementValue(e) {
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
    
    function icommerce_decrementValue(e) {
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
    
    function icommerce_addToCartWithQuantity(e) {
      e.preventDefault();
      let addBtn = $(e.target)
      let divParentAdd = addBtn.closest('div.add-to-cart-with-quantity')
      let quantitySelector = $(divParentAdd).children("div.number-input.input-group.quantity-selector")[0];
      let quantityInput = $(quantitySelector).children("input.quantity-field")[0];
      let productId = $(e.target).data('pid');
      window.livewire.emit('addToCart', productId, $(quantityInput).val())
      $(quantityInput).val(1)
    }

    @if(isset($productListLayout) && !empty($productListLayout))
      Livewire.on('incrementValue', (e) => {
        icommerce_incrementValue(e);
      })

      Livewire.on('decrementValue', (e) => {
        icommerce_decrementValue(e);
      })

      Livewire.on('addCartWithQuantity', (e) => {
        icommerce_addToCartWithQuantity(e);
      })
    @else
      $('.infor .input-group').on('click', '.button-plus', function (e) {
        icommerce_incrementValue(e);
      });
      $('.infor .input-group').on('click', '.button-minus', function (e) {
        icommerce_decrementValue(e);
      });
      $('.infor .add-to-cart-with-quantity-button').click(function (e) {
        icommerce_addToCartWithQuantity(e);
      });
    @endif
    
    
  </script>

@stop
@endonce

@endif