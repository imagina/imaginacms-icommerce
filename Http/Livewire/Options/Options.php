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

  protected $listeners = ['updateOption', 'addToCartOptions'];

  private $log = "Icommerce: Livewire|Options|Options|";

  public function mount(Request $request, $product)
  {

    $this->options = $product->optionsPivot->sortByDesc("sort_order");
    $this->optionValues = $product->optionValues;

    $this->product = $product;
    $this->quantity = 1;
    $this->optionsSelected = [];
    $this->view = "icommerce::frontend.livewire.options.index";
    $this->optionsPrice = 0;
  }

  //|--------------------------------------------------------------------------
  //| Event's Action
  //|--------------------------------------------------------------------------
  /**
   * @param $oldValue
   * @param $newValue
   * @param $dynamic
   */
  public function updateOption($oldValue, $newValue, $dynamic, $optionId)
  {

    //\Log::info($this->log."updateOption");

    //Case Dynamics
    if (is_string($oldValue)) $oldValue = strip_tags($oldValue);
    if (is_string($newValue)) $newValue = strip_tags($newValue);

    $oldValue = !is_array($oldValue) ? [$oldValue] : $oldValue;

    //\Log::info($this->log."oldValue: ".json_encode($oldValue));
    //\Log::info($this->log."newValue: ".json_encode($newValue));

    foreach ($oldValue as $value) {
      foreach ($this->optionsSelected as $key => $optionSelected) {
        //Case Dynamic Option
        if ($dynamic && isset($optionSelected['value']) && $optionSelected['value'] == $value) {
          unset($this->optionsSelected[$key]);
        } else {
          //Case No Dynamic Option
          if ($optionSelected == $value)
            unset($this->optionsSelected[$key]);
        }

      }
    }

    if (!empty($newValue)) {
      $newValue = !is_array($newValue) ? [$newValue] : $newValue;

      if ($dynamic) {
        $news[] = ["option_id" => $optionId, "value" => $newValue[0]];
        $this->optionsSelected = array_merge($this->optionsSelected, $news);
      } else {
        $this->optionsSelected = array_merge($this->optionsSelected, $newValue);
      }

    }

    //\Log::info($this->log."OptionsSelected: ".json_encode($this->optionsSelected));

  }

  /**
   *
   */
  public function addToCartOptions($data)
  {

    $this->emit('addToCartWithOptions', ["productId" => $this->product->id, "quantity" => $data["quantity"], "productOptionValues" => $this->optionsSelected]);

  }


  //|--------------------------------------------------------------------------
  //| Livewire Properties
  //|--------------------------------------------------------------------------
  public function getPriceOptionsProperty()
  {
    $optionsPrice = 0;
    foreach ($this->optionValues as $optionValue) {
      if (in_array($optionValue->id, $this->optionsSelected)) {
        $optionsPrice += $optionValue->price_prefix == "+" ? $optionValue->price : $optionValue->price * -1;
      }
    }

    return $optionsPrice;
  }

  //|--------------------------------------------------------------------------
  //| Livewire Events
  //|--------------------------------------------------------------------------
  /**
   *
   */
  public function hydrate()
  {
    $this->optionsPrice = 0;
    $this->options = $this->product->optionsPivot->sortByDesc("sort_order");
    $this->optionValues = $this->product->optionValues;

  }


  //|--------------------------------------------------------------------------
  //| Render
  //|--------------------------------------------------------------------------
  public function render()
  {
    return view($this->view, ["options" => $this->options]);
  }

}
