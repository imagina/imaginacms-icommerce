@section('scripts-owl')

  <script>
    jQuery(document).ready(function($) {
  
      window.addEventListener('productToQuoteModal', event => {
    
        // Bricklayer needed
        $("#modalQuoteProduct").modal("show")
      });
      
    });

  </script>

  @parent
@stop