<?php

namespace Modules\Icommerce\Http\Livewire\Options;

use \Illuminate\Session\SessionManager;
use Livewire\Component;
use Illuminate\Http\Request;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Icommerce\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;
use Modules\Isite\Services\PdfService;

class Options extends Component
{
  
  protected $options;
  public $optionValues;
  public $product;
  public $selectedOptions;
  public $quantity;
  public $optionsSelected;
  
  protected $listeners = ['updateOption'];
  
  public function mount(Request $request, $product)
  {
    
    $this->options = $product->optionsPivot->sortByDesc("sort_order");
    $this->optionValues = $product->optionValues;
    
    $this->product = $product;
    $this->quantity = 1;
    $this->optionsSelected = [];
    $this->view = "icommerce::frontend.livewire.options.index";
    
  }
  
  //|--------------------------------------------------------------------------
  //| Event's Action
  //|--------------------------------------------------------------------------
  /**
   * @param $oldValue
   * @param $newValue
   */
  public function updateOption($oldValue, $newValue)
  {
  
    $oldValue = !is_array($oldValue) ? [$oldValue] : $oldValue;
  
    foreach ($oldValue as $value) {
      foreach ($this->optionsSelected as $key => $optionSelected) {
        if ($optionSelected == $value)
          unset($this->optionsSelected[$key]);
      }
    }
    
    if(!empty($newValue)){
      $newValue = !is_array($newValue) ? [$newValue] : $newValue;
      $this->optionsSelected = array_merge($this->optionsSelected, $newValue);
  
    }
  }
  
  /**
   *
   */
  public function addToCart()
  {

    $this->emit('addToCartWithOptions', ["productId" =>$this->product->id,"quantity" => $this->quantity,"productOptionValues" => $this->optionsSelected]);
    
  }
 
  
  //|--------------------------------------------------------------------------
  //| Livewire Events
  //|--------------------------------------------------------------------------
  /**
   *
   */
  public function hydrate()
  {
    
    $this->options = $this->product->optionsPivot->sortByDesc("sort_order");
    $this->optionValues = $this->product->optionValues;
    
  }
  
  //|--------------------------------------------------------------------------
  //| Actions
  //|--------------------------------------------------------------------------
  /**
   * @param $prefix
   */
  public function setQuantity($prefix)
  {
    
    switch ($prefix) {
      
      case '+':
        $this->quantity++;
        break;
      case '-':
        $this->quantity--;
        break;
      
    }
  }
  
  //|--------------------------------------------------------------------------
  //| Render
  //|--------------------------------------------------------------------------
  public function render()
  {
    return view($this->view, ["options" => $this->options]);
  }
  
}
