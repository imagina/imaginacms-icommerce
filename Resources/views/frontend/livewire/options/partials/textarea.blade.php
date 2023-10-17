<textarea
    class="form-control" row="4"
    name="{{$productOption->option->description}}" {{$productOption->required ? "required" : ""}}
    value="{{$selected}}"
    placeholder="{{$productOption->value}}"
    wire:model.debounce.500ms="selected">
</textarea>