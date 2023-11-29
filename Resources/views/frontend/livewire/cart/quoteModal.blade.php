  <div class="modal fade" id="modalQuoteProduct"  tabindex="-1" role="dialog" aria-labelledby="modalQuoteProduct" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalQuoteProductTitle">{{trans("icommerce::quote.form.title.product")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @php
            $quoteFormId = setting('icommerce::icommerceQuoteForm',null,null);
          @endphp
          @if($quoteFormId)
            <x-iforms::form :id="$quoteFormId" :fieldsParams="['productName' => ['readonly' => 'readonly']]" />
          @endif
        </div>
      </div>
    </div>
  </div>

@section('scripts-owl')
  @parent
  <script type="text/javascript" defer>
    document.addEventListener("DOMContentLoaded", function () {

      window.addEventListener('productToQuoteModal', event => {
        // Bricklayer needed

        $("#inputproductName").val(event.detail.productName);

        $("#modalQuoteProduct").modal("show")
      });

    });

  </script>
@stop
