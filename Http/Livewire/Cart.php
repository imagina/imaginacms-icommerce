<?php

namespace Modules\Icommerce\Http\Livewire;

use \Illuminate\Session\SessionManager;
use Livewire\Component;
use Illuminate\Http\Request;
use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Icommerce\Repositories\CartRepository;

class Cart extends Component
{
  
  public $cart;
  public $view;
  public $defaultView;
  private $params;
  protected $listeners = ['addToCart', 'deleteFromCart', 'updateCart'];
  
  public function mount(Request $request)
  {
    
    $this->defaultView = 'icommerce::frontend.livewire.cart';
    $this->view = $params["view"] ?? $this->defaultView;
    
    $cart = request()->session()->get('cart');
    
    if (isset($cart->id)) {
      $this->cart = $this->cartRepository()->getItem($cart->id);
      request()->session()->put('cart', $this->cart);
    } else {
      $data = [];
      $data["ip"] = $request->ip();
      $data["session_id"] = session('_token');
      
      //Create item
      $this->cart = $this->cartRepository()->create($data);
      request()->session()->put('cart', $this->cart);
      
    }
  }
  
  public function addToCart($productId, $quantity = 1, $productOptionValues = [])
  {
    
    $product = $this->productRepository()->getItem($productId);
    
    if (!isset($product->id)) {
      $this->alert('warning', trans('icommerce::cart.message.invalid_product'), [
        'position' => 'bottom-end',
        'iconColor' => setting("isite::brandPrimary", "#fff")
      ]);
      
    } else {
      if ($product->present()->hasRequiredOptions && !$this->productHasAllOptionsRequiredOk($product->productOptions, $productOptionValues)) {
        $this->alert('warning', trans('icommerce::cart.message.product_with_required_options'), [
          'position' => 'bottom-end',
          'iconColor' => setting("isite::brandPrimary", "#fff")
        ]);
        
        $this->redirect($product->url);
        
      }else{
  
        $data = [
          "cart_id" => $this->cart->id,
          "product_id" => $productId,
          "quantity" => $quantity,
          "product_option_values" => $productOptionValues
        ];
        $this->cartProductRepository()->create($data);
        $this->updateCart();
  
        $this->alert('success', trans('icommerce::cart.message.add'), [
          'position' => 'bottom-end',
          'iconColor' => setting("isite::brandPrimary", "#fff")
        ]);
  
      }
    }
  }
  
  private function productHasAllOptionsRequiredOk($productOptions, $productOptionValues)
  {
    
    $allRequiredOptionsOk = true;
    foreach ($productOptions as $productOption) {
      $optionOk = true;
      if ($productOption->pivot->required) {
        $optionOk = false;
        foreach ($productOptionValues as $productOptionValue) {
          $productOption->id == $productOptionValue["optionId"] ? $optionOk = true : false;
        }
      }
      !$optionOk ? $allRequiredOptionsOk = false : false;
    }
    
    return $allRequiredOptionsOk;
  }
  
  public function deleteFromCart($cartProductId)
  {
    $params = json_decode(json_encode(["include" => []]));
    $result = $this->cartProductRepository()->deleteBy($cartProductId, $params);
    
    $this->updateCart();
    
    $this->alert('warning', trans('icommerce::cart.message.remove'), [
      'position' => 'bottom-end',
      'iconColor' => setting("isite::brandPrimary", "#fff")
    ]);
    
  }
  
  public function updateCart()
  {
    
    $params = json_decode(json_encode(["include" => []]));
    $this->cart = $this->cartRepository()->getItem($this->cart->id, $params);
    request()->session()->put('cart', $this->cart);
    
    
  }
  
  public function render()
  {
    $ttpl = 'icommerce.livewire.cart';
    $this->view = (view()->exists($this->view)) && $this->view != $this->defaultView ? $this->view : (view()->exists($ttpl)) ? $ttpl : $this->defaultView;
    
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
