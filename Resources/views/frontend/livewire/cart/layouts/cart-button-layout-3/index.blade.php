<div class="cartLayout3" >

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


@section('scripts-owl')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            window.livewire.emit('refreshCart');
        });
    </script>

@stop