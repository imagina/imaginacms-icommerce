<input wire:model.debounce.500ms="selected" type="text" class="form-control"
       name="{{$productOption->option->description}}"
  {{$productOption->required ? "required" : ""}} />