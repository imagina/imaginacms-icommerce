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

class Cart extends Component
{

  public $cart;
  public $view;
  public $layout;
  public $warehouse;
  public $warehouseEnabled;
  public $currentCurrency;
  public $currencySelected;
  public $productToQuote;
  public $showButton;
  public $icon;
  public $iconquote;
  public $classCart;
  public $styleCart;
  private $params;
  private $request;
  protected $currencies;
  protected $listeners = ['addToCart', 'addToCartWithOptions', 'download', 'deleteFromCart', 'updateCart', 'deleteCart', 'refreshCart', 'makeQuote', 'requestQuote', 'submitQuote'];

  public function mount(Request $request, $layout = 'cart-button-layout-1', $icon = 'fa fa-shopping-cart',
                                $iconquote = 'fas fa-file-alt', $showButton = true, $classCart = '', $styleCart = '')
  {


    $this->showButton = $showButton;
    $this->layout = $layout;
    $this->icon = $icon;
    $this->iconquote = $iconquote;
    $this->warehouse = session('warehouse');
    $this->warehouseEnabled = setting('icommerce::warehouseFunctionality',null,false);
    $this->view = "icommerce::frontend.livewire.cart.layouts.$this->layout.index";
    $this->classCart = $classCart;
    $this->styleCart = $styleCart;

    //$this->refreshCart();
    $this->load();
  }

  //|--------------------------------------------------------------------------
  //| Livewire Events
  //|--------------------------------------------------------------------------
  public function refreshCart()
  {

    $cart = request()->session()->get('cart');
	$cart= json_decode($cart);

    if (isset($cart->id)) {
      $this->cart = $this->cartRepository()->getItem($cart->id);
    }

    if (isset($this->cart->id) && $this->cart->status == 1) {

      $user = Auth::user();
      $data = [];
      if (isset($user->id) && empty($this->cart->user_id)) {
        $data["user_id"] = $user->id;
        $this->cart->user_id = $data["user_id"];
        $this->cart->save();
        $this->updateCart();
      }

    } else {
      $data = [];
      $data["ip"] = request()->ip();
      $data["session_id"] = session('_token');
      $data["status"] = 1;

      $user = Auth::user();

      if (isset($user->id))
        $data["user_id"] = $user->id;

      //Create item
      $this->cart = $this->cartRepository()->create($data);

    }
    if (isset($this->cart->products) && !is_null($this->cart->products)) {
      $updateCart = false;
      foreach ($this->cart->products as $cartProduct) {
        $productAvailable = $this->cartProductRepository()->productHasValidQuantity($cartProduct);
        if (!$productAvailable) {
          $this->cartProductRepository()->deleteBy($cartProduct->id);
          $updateCart = true;
        } else {
          $warehouseEnabled = setting('icommerce::warehouseFunctionality', null, false);
          $warehouse = Session('warehouse');
          if ($warehouseEnabled && $cartProduct->warehouse_id != $warehouse->id) {
            $data = [
              'product_id' => $cartProduct->product->id,
              'warehouse_id' => $warehouse->id,
              'cart_id' => $this->cart->id,
              'product_option_values' =>  $cartProduct->productOptionValues->pluck('id')->toArray()
            ];
            $this->cartProductRepository()->updateBy($cartProduct->id, $data);
          }
        }
      }
      if ($updateCart) {
        $this->updateCart();
        $warehouseEnabled = setting('icommerce::warehouseFunctionality', null, false);
        if ($warehouseEnabled) {
          $this->alert('warning', trans("icommerce::common.components.alerts.updateCartByDeleteProductWarehouse"), array_merge(config("asgard.isite.config.livewireAlerts"),["timer" => "8000"]));
        } else {
          $this->alert('warning', trans("icommerce::common.components.alerts.updateCartByDeleteProduct"), config("asgard.isite.config.livewireAlerts"));
        }
      }
    }
    request()->session()->put('cart', json_encode($this->cart));
  }


  public function addToCartWithOptions($data)
  {

    $this->addToCart($data["productId"], $data["quantity"], $data["productOptionValues"]);

  }

  public function addToCart($productId, $quantity = 1, $productOptionValues = [], $isCall = false)
  {

    try {

      if ($quantity > 0) {

        $product = $this->productRepository()->getItem($productId);

        if (isset($product->id)) {
          $data = [
            "cart_id" => $this->cart->id,
            "product_id" => $productId,
            "quantity" => $quantity,
            "product_option_values" => $productOptionValues,
            "is_call" => $isCall
          ];

          $this->cartProductRepository()->create($data);
          $this->updateCart();

          $this->alert('success', trans('icommerce::cart.message.add'), config("asgard.isite.config.livewireAlerts"));

        } else {
          $this->alert('warning', trans('icommerce::cart.message.add'), config("asgard.isite.config.livewireAlerts"));
        }

      }

    } catch (\Exception $e) {

      switch ($e->getMessage()) {
        case 'Invalid product':
          $this->alert('warning', trans('icommerce::cart.message.invalid_product'), config("asgard.isite.config.livewireAlerts"));
          break;

        case 'Missing required product options':
          $this->alert('warning', trans('icommerce::cart.message.product_with_required_options'), config("asgard.isite.config.livewireAlerts"));
          $this->redirect($product->url);
          break;

        case 'Product Quantity Unavailable':
          if($this->warehouseEnabled)
            $this->alert('warning', trans('icommerce::cart.message.warehouse_quantity_unavailable'), config("asgard.isite.config.livewireAlerts"));
          else
            $this->alert('warning', trans('icommerce::cart.message.quantity_unavailable', ["quantity" => $product->quantity ?? 0]), config("asgard.isite.config.livewireAlerts"));
          break;
      }

    }


  }

  public function deleteFromCart($cartProductId)
  {
    $params = json_decode(json_encode(["include" => []]));
    $result = $this->cartProductRepository()->deleteBy($cartProductId, $params);

    $this->updateCart();

    $this->alert('warning', trans('icommerce::cart.message.remove'), config("asgard.isite.config.livewireAlerts"));

  }

  public function deleteCart()
  {
    $params = json_decode(json_encode(["include" => []]));
    $result = $this->cartRepository()->deleteBy($this->cart->id, $params);
    $this->cart = null;
    request()->session()->put('cart', null);

    $this->refreshCart();
  }

  public function updateCart()
  {

    $params = json_decode(json_encode(["include" => []]));
    $this->cart = $this->cartRepository()->getItem($this->cart->id, $params);

    request()->session()->put('cart', json_encode($this->cart));

    $this->emit("cartUpdated", $this->cart);

  }

  /**
   * @param $name
   * @param $value
   */
  public function updated($name, $value)
  {

    switch ($name) {
      case 'currencySelected':
        if ($value) {
          $currency = $this->currencyRepository()->getItem($value);
          request()->session()->put('custom_currency_' . (tenant()->id ?? ""), $currency);

          $this->dispatchBrowserEvent('refresh-page');
        }
        break;

    }

  }

  public function download()
  {

    $content = [
      'data' => [
        'cart' => $this->cart,
      ],
      'filename' => trans("icommerce::pdf.settings.pdf.file_name"),
      'view' => 'icommerce::pdf.viewCart'
    ];

    $archivo = $this->PdfService()->create($content);
    return $archivo;
  }

  public function requestQuote()
  {
    $this->dispatchBrowserEvent('QuoteModal', []);
  }

  public function submitQuote($data)
  {
    $order = [
      "first_name" => $data["first_name"] ?? "",
      "last_name" => $data["last_name"] ?? "",
      "email" => $data["email"] ?? "",
      "telephone" => $data["telephone"] ?? "",
      "type" => "quote"
    ];

    if (isset($data["first_name"])) unset($data["first_name"]);
    if (isset($data["last_name"])) unset($data["last_name"]);
    if (isset($data["email"])) unset($data["email"]);
    if (isset($data["telephone"])) unset($data["telephone"]);
    if (isset($data["form_id"])) unset($data["form_id"]);
    if (isset($data["_token"])) unset($data["_token"]);

    $order["options"] = ["quoteForm" => $data];

    $order["cart"] = $this->cart;

    $order = $this->orderService()->create($order);

    $content = [
      'data' => ['order' => $order["order"]],
      'filename' => trans('icommerce::pdf.settings.pdf.file_name'),
      'view' => 'icommerce::pdf.viewOrder',
    ];

    $archivo = $this->PdfService()->create($content);
    return $archivo;

  }

  public function makeQuote($productId)
  {

    $productToQuote = $this->productRepository()->getItem($productId);

    $this->dispatchBrowserEvent('productToQuoteModal', ["productName" => $productToQuote->name]);

  }

  //|--------------------------------------------------------------------------
  //| Repositories
  //|--------------------------------------------------------------------------
  /**
   * @return cartRepository
   */
  private function cartRepository()
  {
    return app('Modules\Icommerce\Repositories\CartRepository');
  }

  /**
   * @return cartProductRepository
   */
  private function cartProductRepository()
  {
    return app('Modules\Icommerce\Repositories\CartProductRepository');
  }

  /**
   * @return productRepository
   */
  private function productRepository()
  {
    return app('Modules\Icommerce\Repositories\ProductRepository');
  }

  /**
   * @return currencyRepository
   */
  private function currencyRepository()
  {
    return app('Modules\Icommerce\Repositories\CurrencyRepository');
  }
  //|--------------------------------------------------------------------------
  //| Services
  //|--------------------------------------------------------------------------
  /**
   * @return orderService
   */
  private function orderService()
  {
    return app('Modules\Icommerce\Services\OrderService');
  }

  /**
   * @return PdfService
   */
  public function PdfService()
  {
    return app('Modules\Isite\Services\PdfService');
  }
  //|--------------------------------------------------------------------------
  //| Render
  //|--------------------------------------------------------------------------
  public function render()
  {
    return view($this->view);
  }

  public function hydrate()
  {
    $this->load();
  }

  protected function load()
  {
    $this->currentCurrency = currentCurrency();
    $this->currencies = $this->currencyRepository()->getItemsBy(json_decode(json_encode([])));
    $this->currencySelected = $this->currentCurrency->id;
  }


  //|--------------------------------------------------------------------------
  //| Properties
  //|--------------------------------------------------------------------------
  public function getContainIsCallProperty(): bool
  {
    $isCall = false;

    foreach ($this->cart->products as $cartProduct) {

      if ($cartProduct->is_call) $isCall = true;
      if ($cartProduct->product->is_call) $isCall = true;

    }

    return $isCall;
  }

  /**
   * @return
   */
  public function getNotContainIsCallProperty()
  {
    $notIsCall = false;

    foreach ($this->cart->products as $cartProduct) {

      if (!$cartProduct->is_call && !$cartProduct->product->is_call) $notIsCall = true;

    }

    return $notIsCall;
  }
}
