<div wire:ignore.self class="modal fade" id="modalQuote"  tabindex="-1" role="dialog" aria-labelledby="modalQuote" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalQuoteTitle">{{trans("icommerce::quote.form.title.cart")}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @php
          $quoteFormId = setting('icommerce::icommerceCartQuoteForm',null,null)
        @endphp
        @if($quoteFormId)
          <x-iforms::form :id="$quoteFormId" livewireSubmitEvent="submitQuote" formId="quoteForm"/>
        @endif
      </div>
    </div>
  </div>
</div>

@section('scripts-owl')
  @parent
  <script type="text/javascript" defer>
    document.addEventListener("DOMContentLoaded", function () {

      window.addEventListener('QuoteModal', event => {
        // Bricklayer needed

        $("#modalQuote").modal("show")
      });

    });

  </script>
@stop

