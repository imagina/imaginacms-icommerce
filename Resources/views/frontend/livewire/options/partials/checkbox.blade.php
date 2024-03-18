@foreach($productOptionValues as $selectOption)
  <div
    class="text-left {{$selectOption->optionValue->options->type != 1 ? 'd-inline-block' : 'radio-square'}}">
    
    <!--Color box-->
    @if($selectOption->optionValue->options->type == 3)
      <div title="{{!$selectOption->available ? '(Agotado)' : ''}}"
           class="box-color {{(in_array($selectOption->id,$selected)) ? 'box-color-active' : ''}}"
           wire:click="setOption({{$selectOption->id}})"
           style="background-color: {{$selectOption->optionValue->options->color}}; cursor: {{$selectOption->available ? 'pointer' : 'not-allowed'}}"></div>
      <!--Image box-->
    @elseif($selectOption->optionValue->options->type == 2)
      <div title="{{!$selectOption->available ? '(Agotado)' : ''}}"
           class="box-image {{(in_array($selectOption->id,$selected)) ? 'box-image-active' : ''}}"
           wire:click="setOption({{$selectOption->id}})"
           style="background-image : url({{$selectOption->optionValue->mediaFiles()->mainimage->path}}); cursor: {{$selectOption->available ? 'pointer' : 'not-allowed'}}"></div>
      <!--Input checkbox-->
    @else
      <div>
        <input type="checkbox"
               wire:model="selected"
               value="{{$selectOption->id}}" name="{{$productOption->option->description}}{{$productOption->id}}"
               {{!$selectOption->available ? "disabled" : ""}}
               title="{{!$selectOption->available ? '(Agotado)' : ''}}"
        />
        <label for="{{$productOption->option->description}}{{$productOption->id}}"/>

          <span>{{ $selectOption->optionValue->description }}</span>
      </div>
    @endif
  </div>
@endforeach