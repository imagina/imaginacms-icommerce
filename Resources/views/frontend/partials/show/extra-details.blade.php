
@if(setting('icommerce::enableProductDetails'))
  <div class="product-details py-2">
      <textarea
        name="productDetails"
        rows="2"
        cols="25"
        style="font-size: 12px"
        wire:model.defer="details"
        placeholder="{{trans("icommerce::products.form.productDetails")}}"
        maxlength="{{setting('icommerce::maximumNumberOfCharactersInputDetails')}}"
        class="form-control"></textarea>
    <div class="d-flex justify-content-end">
        <span class="text-muted small mt-1" style="font-size: 10px">
          {{trans("icommerce::products.form.maxCharactersProductDetails"). setting('icommerce::maximumNumberOfCharactersInputDetails')}}
         </span>
    </div>
  </div>
@endif