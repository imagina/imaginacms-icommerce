 <div class="container pt-5">
    <div class="row">

        {{-- SIDEBAR --}}
        <div class="col-lg-3 pb-5">

           
            @includeFirst(['icommerce.widgets.categories','icommerce::frontend.widgets.categories'])     
           
           
        </div>

        {{-- PRODUCTS --}}
        <div class="col-lg-9 pb-5">
            
          
            <div id="content">

                <div id="cont_products" class="mt-4">
                    @includeFirst(['icommerce.widgets.products','icommerce::frontend.widgets.products'])
                </div>

            </div>

        </div>

    </div>
</div>