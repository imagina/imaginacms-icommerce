@php($discount = $product->discount ?? null)
<div class="product-layout product-layout-2 position-relative @if(isset($discount) && $discount) with-discount @endif
        @if($product->is_sold_out) sold-out @endif
@if($product->is_new) is-new @endif"
     style="padding: {{$externalPadding}}px;
        border-radius: {{$externalBorderRadius}}px; border: {{$externalBorder ? '1' : '0'}}px solid {{$externalBorderColor}};">
  <x-isite::edit-link
    link="{{$editLink}}{{$product->id}}"
    :tooltip="$tooltipEditLink"
  />
  @include('icommerce::frontend.components.product.meta')
  @if(isset($itemListLayout) && $itemListLayout=='one')
    <div class="row product-list-layout-one">
      <div class="col-6">
        <div class="row justify-content-center position-relative m-0">
          @include('icommerce::frontend.components.product.ribbon')
          <div
            class="bg-img d-inline-block position-relative overflow-hidden"
            style="padding: {{$imageSpacing}}px;">
            <livewire:media::dynamic-image
              :alt="$product->name"
              :title="$product->name"
              :url="$product->url"
              :isMedia="true"
              :mediaFiles="$product->mediaFiles()"
              imgClasses="product-img image-static"
              :imgStyles="'padding: '.$imagePadding.'px; border: '.($imageBorder ? '1' : '0').'px solid '.$imageBorderColor.'; border-radius: '.$imageBorderRadius.'px;'"
              itemId="{{$product->id}}"
              wire:key="product-image-{{$product->id}}"
            />
            @if($secondaryImageHover && $issetSecondaryImage)
              <livewire:media::dynamic-image
                :alt="$product->name"
                :title="$product->name"
                :url="$product->url"
                :isMedia="true"
                zone="secondaryimage"
                :mediaFiles="$product->mediaFiles()"
                imgClasses="product-img image-transition"
                :imgStyles="'padding: '.$imagePadding.'px; border: '.($imageBorder ? '1' : '0').'px solid '.$imageBorderColor.'; border-radius: '.$imageBorderRadius.'px;'"
                itemId="{{$product->id}}"
                wire:key="product-image-{{$product->id}}"
              />
            @endif
          </div>
        </div>
      </div>
      <div class="col-6">
        @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-2.infor')
      </div>
    </div>
  @else
    @include('icommerce::frontend.components.product.ribbon')
    @include('icommerce::frontend.components.product.product-list-item.layouts.product-list-item-layout-2.infor')
  @endif
  @include('icommerce::frontend.components.product.global-inline-css')
</div>
