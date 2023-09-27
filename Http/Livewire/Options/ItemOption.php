<?php

namespace Modules\Icommerce\Http\Livewire\Options;

use \Illuminate\Session\SessionManager;
use Livewire\Component;
use Illuminate\Http\Request;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Entities\Option;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Icommerce\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;
use Modules\Isite\Services\PdfService;

class ItemOption extends Component
{
  
  protected $productOption;
  protected $product;
  protected $optionValues;
  protected $productOptions;
  protected $productOptionValues;
  
  public $productId;
  public $type;
  public $productOptionId;
  public $selected;

  //Is a dynamic option - The data will be added by the buyer (Example: text)
  //No dynamic - The data comes via DB (Example: colors)
  public $dynamic;
  public $optionId;
  
  private $log = "Icommerce: Livewire|Options|ItemOption|";
  
  public function mount(Request $request, $type, $product, $productOption)
  {
    
    \Log::info($this->log."Mount");

    $this->type = $type;
    $this->productId = $product->id;
    $this->productOptionId = $productOption->id;
    $this->dynamic = $productOption->option->dynamic;
    $this->optionId = $productOption->option_id;
    
    $this->loadProtectedAttributes();
    
    $this->view = "icommerce::frontend.livewire.options.item";
    
    if (in_array($type, ["checkbox"])) {
      $this->selected = [];
    } else {
      $this->selected = null;
    }
    
  }
  
  //|--------------------------------------------------------------------------
  //| Actions
  //|--------------------------------------------------------------------------
  /**
   *
   */
  public function setOption($ProductOptionValueId)
  { 

    \Log::info($this->log."setOption");

    $oldValue = $this->selected;
    
    //si el tipo es checkbox hay que tratar el $selected como un array
    if (in_array($this->type, ["checkbox"])) {
      //si el valor que llega ya se encuentra seleccionado entonces se retira del array porque se entiende que es un click para desseleccionarlo
      if (in_array($ProductOptionValueId, $this->selected)) {
        unset($this->selected[$ProductOptionValueId]);
      } else {
        array_push($this->selected, $ProductOptionValueId);
      }
    } else {
      //si el valor seleccionado está vacío se acepta el nuevo valor de lo contrario se resetea por que se asume que es para desseleccionarlo
      if (empty($this->selected)) {
        $this->selected = $ProductOptionValueId;
      } else {
        if ($this->selected == $ProductOptionValueId)
          $this->selected = null;
        else {
          $this->selected = $ProductOptionValueId;
        }
      }
    }
    
    $this->emit('updateOption', $oldValue, $this->selected,$this->dynamic,$this->optionId);
  }
  
  
  //|--------------------------------------------------------------------------
  //| Livewire Events
  //|--------------------------------------------------------------------------
  /**
   * Todas las propiedades que son objectos o colecciones se borran cuando se recarga el componente
   * por lo que se necesita rehidratarlas
   */
  public function hydrate()
  {
  
    $this->loadProtectedAttributes();
    
  }
  
  /**
   * Updating Selected Livewire Event
   *
   * @param $name
   * @param $value
   */
  public function updatingSelected($value)
  {
    
    \Log::info($this->log."updatingSelected");

    $this->emit('updateOption', $this->selected, $value, $this->dynamic ,$this->optionId);
    
  }
  
  /**
   * Carga de propiedades protegidas
   */
  private function loadProtectedAttributes(){
  
    //Product
    $this->product = Product::find($this->productId);
    
    //Product Options
    $this->productOptions = $this->product->optionsPivot->sortByDesc("sort_order");
  
    //Product Option
    $this->productOption = $this->productOptions->where("id", $this->productOptionId)->first();
  
    //Option Values
    $this->optionValues = $this->product->optionValues;
    
    //Product Option Values
    $this->productOptionValues = $this->productOption->productOptionValues ?? [];
  
  }
  
  //|--------------------------------------------------------------------------
  //| Properties
  //|--------------------------------------------------------------------------
  public function getTotalProperty()
  {
    
    $selected = !is_array($this->selected) ? [$this->selected] : $this->selected;
    
    $total = 0;
    
    foreach ($selected as $value) {
      
      $productOptionValue = $this->productOptionValues->where("id", $value)->first();
      
      if (isset($productOptionValue->id))
        switch ($productOptionValue->price_prefix) {
          case "+":
            $total += $productOptionValue->price;
            break;
          case "-":
            $total -= $productOptionValue->price;
            break;
        }
    }
    return $total;
  }
  
  //|--------------------------------------------------------------------------
  //| Render
  //|--------------------------------------------------------------------------
  public function render()
  {
    return view($this->view,
      [
        "productOption" => $this->productOption,
        "productOptions" => $this->productOptions,
        "product" => $this->product,
        "optionValues" => $this->optionValues,
        "productOptionValues" => $this->productOptionValues
      ]);
  }
  
}
