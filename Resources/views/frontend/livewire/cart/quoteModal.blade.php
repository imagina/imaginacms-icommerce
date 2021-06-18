  <div class="modal fade" id="modalQuoteProduct"  tabindex="-1" role="dialog" aria-labelledby="modalQuoteProduct" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalQuoteProductTitle">{{trans("icommerce::quote.productForm.title")}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <x-iforms::form :id="setting('icommerce::icommerceQuoteForm')" :fieldsParams="['productName' => ['disabled' => 'disabled']]" />
        </div>
      </div>
    </div>
  </div>

@section('scripts-owl')
  @parent
  <script>
    document.addEventListener("DOMContentLoaded", function () {

      window.addEventListener('productToQuoteModal', event => {
        
        // Bricklayer needed

        $("#inputproductName").val(event.detail.productName);

        $("#modalQuoteProduct").modal("show")
      });

    });

  </script>
@stop
