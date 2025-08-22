@if(!empty($productOptionValues))
  <select class="form-control" {{ $productOption->required ? "required" : "" }} wire:model="selected">
    <option value="Null">{{trans("icommerce::billing_details.form.select_option")}}</option>
    @foreach($productOptionValues as $selectOption)
      @php
          $showPrice = $selectOption->price != 0 && (setting('Icommerce::showExtraPriceInOptions', null, true));
          $showQuantity = $selectOption->quantity != 0  && (setting('Icommerce::showQuantityInOptions', null,  true));
      @endphp
      <option
        {{ !$selectOption->available ? 'disabled' : '' }}
        value="{{ $selectOption->id }}"
      >
        {{$selectOption->optionValue->description ?? ''}}
        {!! $showQuantity ? '- ('.$selectOption->quantity.') ' : '' !!}
        {!! $showPrice ? '- '.formatMoney($selectOption->price) : '' !!}
        {!! $selectOption->available != 1 ? '- ('. trans("icommerce::products.options.souldout").')' : '' !!}
      </option>
    @endforeach
  </select>
@endif
