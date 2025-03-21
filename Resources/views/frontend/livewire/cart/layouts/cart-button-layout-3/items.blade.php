<!-- articulos en el carrito -->
<div class="cart-items h-100">
  @if($cart->products->count())
    @foreach($cart->products as $cartProduct)
      <div class="item_carting border-bottom pt-4">
        <div class="row item_carting">
          <div class="col-3 pr-0 pb-2">
            <div class="img-product-cart">
              <x-media::single-image
                :alt="$cartProduct->product->name"
                :title="$cartProduct->product->name"
                :url="$cartProduct->product->url"
                :isMedia="true"
                :mediaFiles="$cartProduct->product->mediaFiles()"/>
            </div>
          </div>
          <div class="col pr-0">
            <!-- titulo -->
            <h6 class="mb-1 __title">
              <a data-toggle="tooltip" data-placement="left" title="{{ $cartProduct->product->name }}" href="{{$cartProduct->product->url}}" class="name-product text-dark">
                {{ $cartProduct->product->name }}
                @include("icommerce::frontend.livewire.cart.productOptions")
              </a>
            </h6>
            <!-- valor y cantidad -->
            <p class="price-text mb-0 text-muted py-1 pb-2">
              {{trans('icommerce::cart.table.quantity')}}: {{ $cartProduct->quantity }} <br>
              {{trans('icommerce::cart.table.price_per_unit')}}: {{isset($currency) ? $currency->symbol_left : '$'}}
              {{formatMoney($cartProduct->product->discount->price ?? $cartProduct->product->price)}} {{isset($currency) ? $currency->symbol_right : ''}}
            </p>
            <div class="input-group quantity-selector py-2">
              <button type="button" class="button-minus" onclick="decreaseQuantity(this)" aria-label="minus">
                <i class="fa fa-minus" aria-hidden="true"></i>
              </button>

              <input aria-label="quantity" type="number" step="1" min="1" max="{{$cartProduct->product->quantity}}"
                     class="quantity-field form-control" value="{{$cartProduct->quantity}}"
                     wire:change.debounce.500ms="updateQuantityCartProduct({{ $cartProduct->id }}, $event.target.value, {{$cartProduct->product->quantity}})"
                     oninput="if(this.value == '') this.value = 1"
              />

              <button type="button" class="button-plus" onclick="increaseQuantity(this)" aria-label="plus">
                <i class="fa fa-plus" aria-hidden="true"></i>
              </button>
            </div>
          </div>

          <div class="col-auto d-flex align-items-start">
            @if(isset($cartProduct->details) && !empty($cartProduct->details))
              <div class="product-details mx-2" data-toggle="tooltip" data-placement="left"
                   title="{{ $cartProduct->details }}">
                <i class="fa-solid fa-circle-info text-primary"></i>
              </div>
            @endif
            <a class="cart-remove text-danger" wire:click="deleteFromCart({{$cartProduct->id}})"
               title="quitar producto">
              <i class="fa fa-times"></i>
            </a>
          </div>

        </div>
      </div>

    @endforeach
  @else
    <h6 class="h-100 text-muted d-flex align-items-center justify-content-center">
      {{trans('icommerce::cart.articles.empty_cart')}}
    </h6>
  @endif
</div>

<script>
  window.decreaseQuantity = function(button) {
    let input = button.closest('.quantity-selector').querySelector('.quantity-field');
    let min = parseInt(input.min);
    let value = parseInt(input.value);
    if (value > min) {
      input.value = value - 1;
      input.dispatchEvent(new Event('change'));
    }
  };

  window.increaseQuantity = function(button) {
    let input = button.closest('.quantity-selector').querySelector('.quantity-field');
    let max = parseInt(input.max);
    let value = parseInt(input.value);
    if (value < max) {
      input.value = value + 1;
      input.dispatchEvent(new Event('change'));
    }
  };
</script>

