<div class="product-layout product-layout-3">
  
  @include('icommerce::frontend.components.product.meta')
  
 
  
  @if(isset($this->mainLayout) && $this->mainLayout=='one')
    <div class="row">
      
      <div class="col-12 col-sm-6">
        @include('icommerce::frontend.components.product.ribbon')
        @include('icommerce::frontend.components.product.product-list-item.layouts.list-product-layout-3.image')
      </div>
      <div class="col-12 col-sm-6">
        @include('icommerce::frontend.components.product.product-list-item.layouts.list-product-layout-3.infor')
      </div>
    </div>
  @else
    @include('icommerce::frontend.components.product.ribbon')
    @include('icommerce::frontend.product.product-list-item.layouts.list-product-layout-3.image')
    @include('icommerce::frontend.product.product-list-item.layouts.list-product-layout-3.infor')
  @endif

</div>