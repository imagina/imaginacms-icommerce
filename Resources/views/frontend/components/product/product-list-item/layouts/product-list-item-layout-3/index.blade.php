<div class="product-layout product-layout-3 card-product position-relative"  style="padding: {{$externalPadding}}px;
        border-radius: {{$externalBorderRadius}}px; border: {{$externalBorder ? '1' : '0'}}px solid {{$externalBorderColor}};">
    <x-isite::edit-link
            link="{{$editLink}}{{$product->id}}"
            :tooltip="$tooltipEditLink"
    />
  @php($discount = $product->discount ?? null)
  @include('icommerce::frontend.components.product.meta')
  @if(isset($itemListLayout) && $itemListLayout=='one')
    <div class="row product-list-layout-one">

      <div class="col-6">
        <div class="position-relative">
          @include('icommerce::frontend.components.product.ribbon')
          <div
            class="bg-img bg-img-{{$imageAspect}} d-flex justify-content-center align-items-center overflow-hidden">
            <x-media::single-image
              :alt="$product->name" :title="$product->name" :url="$product->url" :isMedia="true"
              :mediaFiles="$product->mediaFiles()"
              :imgStyles="'padding: '.$imagePadding.'px; border: '.($imageBorder ? '1' : '0').'px solid '.$imageBorderColor.'; border-radius: '.$imageBorderRadius.'px;'"/>
          </div>
        </div>
      </div>
      <div class="col-6">
        @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-3.infor')
      </div>
    </div>
  @else
    @include('icommerce::frontend.components.product.ribbon')
    <div class="bg-img bg-img-{{$imageAspect}} d-flex justify-content-center align-items-center overflow-hidden">
      <x-media::single-image
        :alt="$product->name" :title="$product->name" :url="$product->url" :isMedia="true"
        :mediaFiles="$product->mediaFiles()"
        :imgStyles="'padding: '.$imagePadding.'px; border: '.($imageBorder ? '1' : '0').'px solid '.$imageBorderColor.'; border-radius: '.$imageBorderRadius.'px;'"/>
    </div>
    @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-3.infor')
  @endif

    @include('icommerce::frontend.components.product.global-inline-css')
</div>