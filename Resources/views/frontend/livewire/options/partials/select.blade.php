@if(!empty($productOptionValues))
  <select class="form-control" {{$productOption->required ? "required" : ""}} wire:model="selected">
    <option value="NULL">selecciona una opción</option>
    @foreach($productOptionValues as $selectOption)
      <option {{!$selectOption->available ? "disabled" : ""}} value="{{$selectOption->id}}">
        {{ $selectOption->optionValue->description }}
        {{ !$selectOption->available ? '(Agotado)' : ''}}
      </option>
    @endforeach
  </select>
@endif
