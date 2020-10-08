 <div class="container pt-5">
    <div class="row">

        {{-- SIDEBAR --}}
        <div class="col-lg-3 pb-5">

                
            <div class="text-title">
                <h1 class="text-main text-uppercase mb-4 px-3">
                    @{{ categorybase.title }}
                </h1>
            </div>

                    
            {{-- 
            @includeFirst(['icommerce.widgets.categories','icommerce::frontend.widgets.categories'])
            @include('icommerce.widgets.categories-children')
            @include('icommerce.widgets.filter-option')
            @include('icommerce.widgets.range_price')
            --}}

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