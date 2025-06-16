@if(!empty($productOptionValues))
  <select class="form-control" {{ $productOption->required ? "required" : "" }} wire:model="selected">
    <option value="Null">Selecciona una opción</option>
    @foreach($productOptionValues as $selectOption)
      <option
        {{ !$selectOption->available ? 'disabled' : '' }}
        value="{{ $selectOption->id }}"
      >
        {{ $selectOption->optionValue->description }}
        {!! $selectOption->quantity == 0 ? '' : '- ('.$selectOption->quantity.') ' !!}
        {{ $selectOption->price != 0 ? ' - ' . formatMoney($selectOption->price) : '' }}
        {{ !$selectOption->available ? '(Agotado)' : '' }}
      </option>
    @endforeach
  </select>
@endif
