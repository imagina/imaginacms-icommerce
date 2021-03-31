<?php

namespace Modules\Icommerce\Http\Livewire;

use \Illuminate\Session\SessionManager;
use Livewire\Component;
use Illuminate\Http\Request;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Icommerce\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
  
  public $cart;
  public $view;
  public $layout;
  public $showButton;
  public $icon;
  private $params;
  private $request;
  protected $listeners = ['addToCart', 'deleteFromCart', 'updateCart', 'deleteCart', 'refreshCart'];
  
  public function mount(Request $request, $layout = 'cart-button-layout-1', $icon = 'fa fa-shopping-cart', $showButton = true)
  {
    

    $this->showButton = $showButton;
    $this->layout = $layout;
    $this->icon = $icon;
    $this->view = "icommerce::frontend.livewire.cart.layouts.$this->layout.index";
    
    //$this->refreshCart();
  }
  
  public function refreshCart()
  {
    
    $cart = request()->session()->get('cart');

    if (isset($cart->id) && $cart->status == 1) {
      $this->cart = $this->cartRepository()->getItem($cart->id);
    }
    
    if (isset($this->cart->id)) {
      
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
      
      $user = Auth::user();
      
      if (isset($user->id))
        $data["user_id"] = $user->id;
    
      //Create item
      $this->cart = $this->cartRepository()->create($data);

    }
    request()->session()->put('cart', $this->cart);
    
  }
  
  public function addToCart($productId, $quantity = 1, $productOptionValues = [])
  {
    
    try {
      $product = $this->productRepository()->getItem($productId);
          $data = [
            "cart_id" => $this->cart->id,
            "product_id" => $productId,
            "quantity" => $quantity,
            "product_option_values" => $productOptionValues
          ];
          
          $this->cartProductRepository()->create($data);
          $this->updateCart();
          
          $this->alert('success', trans('icommerce::cart.message.add'), config("asgard.isite.config.livewireAlerts"));
    
      
    } catch (\Exception $e) {
      
      switch($e->getMessage()){
        case 'Invalid product':
          $this->alert('warning', trans('icommerce::cart.message.invalid_product'), config("asgard.isite.config.livewireAlerts"));
          break;
  
        case 'Missing required product options':
          $this->alert('warning', trans('icommerce::cart.message.product_with_required_options'), config("asgard.isite.config.livewireAlerts"));
          $this->redirect($product->url);
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
    
    request()->session()->put('cart', $this->cart);
    
    $this->emit("cartUpdated", $this->cart);
    
  }
  
  public function render()
  {
    return view($this->view);
  }
  
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
  
  
}
