<div class="product-layout product-layout-1">
  <div class="relative-position">
    <x-isite::edit-link link="{{$editLink}}{{$product->id}}" tooltip="{{$tooltipEditLink}}"/>
  </div>
  @php($discount = $product->discount ?? null)
  @include('icommerce::frontend.components.product.meta')

  @if(isset($itemListLayout) && $itemListLayout=='one')
    <div class="row product-list-layout-one">

      <div class="col-6">
        <div class="row justify-content-center position-relative m-0">
          @include('icommerce::frontend.components.product.ribbon')
          <div
            class="bg-img bg-img-{{$productAspect}} d-flex justify-content-center align-items-center overflow-hidden">
            <x-media::single-image :alt="$product->name" :title="$product->name" :url="$product->url" :isMedia="true"
                                   :mediaFiles="$product->mediaFiles()"/>
          </div>
        </div>
      </div>
      <div class="col-6">
        @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-1.infor')
      </div>
    </div>
  @else
    @include('icommerce::frontend.components.product.ribbon')
    <div class="bg-img bg-img-{{$productAspect}} d-flex justify-content-center align-items-center overflow-hidden">
      <x-media::single-image :alt="$product->name" :title="$product->name" :url="$product->url" :isMedia="true"
                             :mediaFiles="$product->mediaFiles()"/>
    </div>
    @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-1.infor')
  @endif

</div>