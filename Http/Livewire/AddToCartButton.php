<?php

namespace Modules\Icommerce\Http\Livewire;

use \Illuminate\Session\SessionManager;
use Livewire\Component;
use Illuminate\Http\Request;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Entities\Currency;
use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Icommerce\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;
use Modules\Isite\Services\PdfService;

class AddToCartButton extends Component
{
  public $idButton;
  public $style;
  public $buttonClasses;
  public $onclick;
  public $withIcon;
  public $iconClass;
  public $iconPosition;
  public $iconColor;
  public $withLabel;
  public $label;
  public $href;
  public $color;
  public $target;
  public $sizeLabel;
  public $dataItemId;
  public $dataTarget;
  public $classesBlock;
  public $buttonConfig;
  public $sizePadding;
  public $styleBlock;
  public $styleBlockHover;
  public $disabled;
  public $view;
  public $warehouseEnabled;
  public $quantityCalculated;
  public $loading;
  public $product;
  public $loadingIcon;
  public $loadingLabel;

//  protected $listeners = ['quantityButtonIsReady'];

  public function mount($idButton = null, $style = "", $buttonClasses = "", $onclick = "", $withIcon = false,
                        $iconClass = "", $withLabel = false, $label = "", $href = "", $color = "primary", $target = "",
                        $iconPosition = "left", $iconColor = 'currentcolor', $sizeLabel = "16", $dataItemId = "",
                        $dataTarget = null, $product, $styleBlock = "", $styleBlockHover = "", $disabled = false,
                        $classesBlock = null, $sizePadding = "", $loadingIcon = "spinner-grow spinner-grow-sm",
                        $loading = false, $loadingLabel = null)
  {
    $this->idButton = $idButton ?? uniqid('button');
    $this->style = $style;
    $this->buttonClasses = $buttonClasses;
    $this->onclick = $onclick;
    $this->withIcon = $withIcon;
    $this->iconClass = $iconClass;
    $this->iconPosition = $iconPosition;
    $this->iconColor = $iconColor;
    $this->withLabel = $withLabel;
    $this->label = $label;
    $this->href = $href;
    $this->color = $color;
    $this->target = $target;
    $this->sizeLabel = $sizeLabel;
    $this->dataItemId = $dataItemId;
    $this->dataTarget = $dataTarget;
    if (isset($classesBlock)) {
      $this->style = $this->buttonClasses;
      $this->buttonClasses = $buttonClasses . ' ' . $sizePadding . ' ' . $classesBlock;
    }
    $this->styleBlock = $styleBlock;
    $this->styleBlockHover = $styleBlockHover;
    $this->disabled = $disabled;
    $this->view = "icommerce::frontend.livewire.addToCartButton";
    $this->warehouseEnabled = setting('icommerce::warehouseFunctionality', null, false);
    $this->quantityCalculated = false;
    $this->product = $product;
    $this->loading = $this->warehouseEnabled == true && $this->quantityCalculated == false;
    $this->loadingIcon = $loadingIcon;
    $this->loadingLabel = $loadingLabel ?? trans('icommerce::common.components.buttonLivewire.labelLoading');
  }

  //|--------------------------------------------------------------------------
  //| Livewire Events
  //|--------------------------------------------------------------------------
  public function quantityButtonIsReady()
  {
    if ($this->warehouseEnabled && $this->product->subtract) {
      $warehouse = Session('warehouse');
      if (!is_null($warehouse)) {
        $warehouseProductQuantity = \DB::table('icommerce__product_warehouse')
          ->where('warehouse_id', $warehouse->id)
          ->where('product_id', $this->product->id)
          ->first();
      }
      if (isset($warehouseProductQuantity) && $warehouseProductQuantity->quantity == 0 || is_null($warehouseProductQuantity)) {
        $this->label = trans('icommerce::common.components.buttonLivewire.labelDisable');
        $this->disabled = true;
        $this->iconClass = "fa-solid fa-circle-exclamation";
      }
    }
    $this->loading = false;
  }

  public function render()
  {
    return view($this->view);
  }
}
