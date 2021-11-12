@section('scripts-owl')

  <script type="text/javascript" defer>
    jQuery(document).ready(function($) {
  
      window.addEventListener('productToQuoteModal', event => {
    
        // Bricklayer needed
        $("#modalQuoteProduct").modal("show")
      });
      
    });

  </script>

  @parent
@stop