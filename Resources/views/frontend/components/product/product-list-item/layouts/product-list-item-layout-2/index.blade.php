<div class="product-layout product-layout-2">
  
  @php($discount = $product->discount ?? null)
  @include('icommerce::frontend.components.product.meta')
  
  
  
  @if(isset($productListLayout) && $productListLayout=='one')
    <div class="row product-list-layout-one">
      
      <div class="col-12 col-sm-6">
        <div class="row justify-content-center position-relative m-0">
          @include('icommerce::frontend.components.product.ribbon')
          <div class="bg-img d-flex justify-content-center align-items-center overflow-hidden">
            <x-media-single-image :alt="$product->name" :title="$product->name" :url="$product->url" :isMedia="true"
                                  :mediaFiles="$product->mediaFiles()"/>
          </div>
        </div>
      
      </div>
      <div class="col-12 col-sm-6">
        @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-2.infor')
      
      
      </div>
    </div>
  @else
    
    @include('icommerce::frontend.components.product.ribbon')
    @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-2.infor')
  @endif

</div>