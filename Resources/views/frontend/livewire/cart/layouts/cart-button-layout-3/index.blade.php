<div wire:init="refreshCart" id="cartLayout3" class="cart-layout-3" >

    @include("icommerce::frontend.livewire.cart.requestquote")

    @include("icommerce::frontend.livewire.cart.layouts.$layout.button")


    <div  class="modal fade modal-cart"  role="dialog" id="modalCart" tabindex="-1" wire:ignore.self aria-hidden="true" >
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title text-dark font-weight-bold">
                        {{trans('icommerce::cart.articles.cart')}}
                        <span class="quantity text-muted">
                            @if(!isset($cart->quantity))
                                <i class="fa fa-spinner fa-pulse fa-fw"></i>
                            @else
                                ({{ $cart->quantity }})
                            @endif
                        </span>

                    </h5>
  
                  @if($this->currencies->count())
                    <div class="form-group">
                      <select wire:model="currencySelected" id="currencySelector" class="form-control currency-selector">
                        @foreach($this->currencies as $currency)
                          <option {{$currency->id == $currentCurrency->id ? "selected" : ""}} value="{{$currency->id}}">{{$currency->code}}</option>
                        @endforeach
                      </select>
    
                    </div>
  
                  @endif
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
                <div class="modal-body">

                    @if(isset($cart->id))
                        @include("icommerce::frontend.livewire.cart.layouts.$layout.items")
                    @endif

                </div>
                <div class="modal-footer p-0 m-0 border-0">

                    @if(isset($cart->id))
                        @include("icommerce::frontend.livewire.cart.layouts.$layout.total",["containIsCall" => $this->containIsCall,"notContainIsCall" => $this->notContainIsCall])
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<style>
  #cartLayout3 .modal-cart .modal-dialog {
    position: fixed;
    margin: auto;
    width: 320px;
    height: 100%;
    right: -320px;
    -webkit-transform: translate3d(0%, 0, 0);
    -ms-transform: translate3d(0%, 0, 0);
    -o-transform: translate3d(0%, 0, 0);
    transform: translate3d(0%, 0, 0) !important;
    -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
    -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
    -o-transition: opacity 0.3s linear, right 0.3s ease-out;
    transition: opacity 0.3s linear, right 0.3s ease-out !important;
  }
  #cartLayout3 .modal-cart .modal-content {
    height: 100%;
    overflow-y: auto;
    border-radius: 0 !important;
  }
  #cartLayout3 .modal-cart .modal-header {
    padding: 1rem;
    text-align: center;
  }
  #cartLayout3 .modal-cart .modal-header img {
    height: 100px;
    object-fit: contain;
    width: auto;
  }
  #cartLayout3 .modal-cart .modal-header .close {
    font-size: 23px;
  }
  #cartLayout3 .modal-cart .modal-header .h5, #cartLayout3 .modal-cart .modal-header h5 {
    font-size: 1rem;
  }
  #cartLayout3 .modal-cart .modal-body {
    padding: 0 1rem;
  }
  #cartLayout3 .modal-cart .modal-footer {
    display: block;
    background-color: #e9ecef;
    padding: 0;
  }
  #cartLayout3 .modal-cart .modal-footer > * {
    margin: 0;
  }
  #cartLayout3 .modal-cart .modal-dialog-scrollable {
    max-height: calc(100%) !important;
  }
  #cartLayout3 .modal-cart .modal-dialog-scrollable .modal-content {
    max-height: calc(100vh) !important;
  }
  #cartLayout3 .modal-cart.show .modal-dialog {
    right: 0;
  }
  #cartLayout3 .cart-remove {
    font-size: 14px;
  }
  @if(!empty($styleCart))
  #cartLayout3 .cart-link {
  {!!$styleCart!!}
  }
  @endif
</style>
@include("icommerce::frontend.livewire.cart.quoteModal")

@section('scripts-owl')
    @parent
    <script>
        window.addEventListener('refresh-page', event => {
            setTimeout(()=>{
                window.location.reload(true);
            },1000)
            
        })
    </script>
@stop
