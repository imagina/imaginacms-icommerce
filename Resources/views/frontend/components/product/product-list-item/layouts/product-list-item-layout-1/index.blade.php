<div class="product-layout product-layout-1">
  @php($discount = $product->discount ?? null)
  @include('icommerce::frontend.components.product.meta')
  
 
  
  @if(isset($this->mainLayout) && $this->mainLayout=='one')
    <div class="row">
      
      <div class="col-12 col-sm-6">
        @include('icommerce::frontend.components.product.ribbon')
        @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-1.image')
      </div>
      <div class="col-12 col-sm-6">
        @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-1.infor')
      </div>
    </div>
  @else
    @include('icommerce::frontend.components.product.ribbon')
    @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-1.image')
    @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-1.infor')
  @endif

</div>