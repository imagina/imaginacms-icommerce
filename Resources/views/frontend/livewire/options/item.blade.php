<div class="ml-3">
  <div class="title-option mb-2">
    {{ $productOption->option->description }}
    @if($productOption->required ?? false)
      <label class="text-danger">({{setting("isite::cms.label.required")}})</label>
    @endif
  <!--Extra price-->
    @if($this->total)
            <label>
              (+ {{isset($currency) ? $currency->symbol_left : '$'}}{{ formatMoney($this->total) }})
            </label>
      @endif
  </div>
  
  @switch($type)
    
    @case("select")
    @include("icommerce::frontend.livewire.options.partials.select")
    @break
    
    @case('radio')
    @include("icommerce::frontend.livewire.options.partials.radio")
    @break
    
    @case("text")
    @include("icommerce::frontend.livewire.options.partials.text")
    @break
    
    @case("checkbox")
    @include("icommerce::frontend.livewire.options.partials.checkbox")
    @break
  
    @case("textarea")
    @include("icommerce::frontend.livewire.options.partials.textarea")
    @break
    
  @endswitch
  
  
  @if(!empty($selected))

      <!-- Esta parte es compleja porque se deben mostrar las opciones hijas si y solo si
            el valor de opcion padre selecionado tiene valores de opciones asignados en la opcion hija
            ejemplo: opcion padre Talla M con opcion hija Color Azul para Talla S y opcion hija color Azul para Talla M.
            en este ejemplo solo la opcion hija color Azul para Talla M es la que se debe mostrar, por eso se pasa a la vista
            interna solo los productOptionValues que se relacionan y no todos
    -->

      <!-- opciones hijas de la actual -->
    @php($options = $productOptions->where("parent_id",$productOption->id))
    
    @foreach($options as $index => $subProductOption)
        <!-- a la opcion hija se le sacan los valores de opcion para el producto que sean hijos de la(s) opcion(es) selecciona(das) -->
      @if(is_array($selected))
        @php($subProductOptionValues = $subProductOption->productOptionValues->whereIn("parent_prod_opt_val_id",$selected))
      @else
        @php($subProductOptionValues = $subProductOption->productOptionValues->where("parent_prod_opt_val_id",$selected))
      @endif

        <!-- el(los) valor(es) de opcion de producto resultante se le saca el objeto ProductOption que dé como resultado -->
      @php($validSubProductOption = $subProductOptionValues->pluck("productOption")->first())

        <!-- el pluck anterior podría regresar un resultado vacío por lo que se valida antes de renderizar-->
      @if(!empty($validSubProductOption))
        <div>
          <div class="content-option">
              <!-- Acá finalmente se renderiza de forma recursiva las subopciones-->
            @include("icommerce::frontend.livewire.options.partials.option-item",["productOption" => $validSubProductOption,"options" => $options])
          </div>
        </div>
      @endif
    @endforeach
  @endif
</div>


