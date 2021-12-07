@foreach($productOptionValues as $selectOption)
  <div
    class="text-left {{in_array($selectOption->optionValue->options->type ?? 0,[3,2]) ? 'd-inline-block' : 'radio-square'}}">
    
    <!--Color box-->
    @if($selectOption->optionValue->options->type ?? 0 == 3)
      <div class="box-color {{$selected == $selectOption->id ? 'box-color-active' : ''}}"
           title="{{(!$selectOption->available) ? '(Agotado)' : ''}}"
           wire:click="setOption({{$selectOption->id}})"
           style="background-color : {{$selectOption->optionValue->options->color}}; cursor: {{$selectOption->available ? 'pointer' : 'not-allowed'}}"></div>
    
    @elseif($selectOption->optionValue->options->type ?? 0 == 2)
    <!--Image box-->
      <div title="{{!$selectOption->available ? '(Agotado)' : ''}}"
           class="box-image {{$selected == $selectOption->id ? 'box-image-active' : ''}}"
           wire:click="setOption({{$selectOption->id}})"
           style="background-image : url({{$selectOption->optionValue->mediaFiles()->mainimage->path}}); cursor: {{$selectOption->available ? 'pointer' : 'not-allowed'}}"></div>
    
    @else
      <div>
        <input type="radio"
               value="{{$selectOption->id}}" name="{{$productOption->option->description}}"
               wire:model="selected"
               {{!$selectOption->available ? "disabled" : ""}}
               title="{{!$selectOption->available ? '(Agotado)' : ''}}"/>
        <label style="cursor:pointer;" for="{{$option->description}}"
               title="{{!$selectOption->available ? '(Agotado)' : ''}}">
          <span>{{ $selectOption->optionValue->description }}</span>
        </label>
      </div>
    @endif
  </div>
@endforeach