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
  protected $listeners = ['addToCart', 'deleteFromCart'];
  
  public function mount(Request $request)
  {
    
    $this->defaultView = 'icommerce::frontend.livewire.cart';
    $this->view = $params["view"] ?? $this->defaultView;
    
    $cart = request()->session()->get('cart');
    
    if(!empty($cart)){
      
      $this->cart = $cart;
      
    }else{
      $data =[];
      $data["ip"] = $request->ip();
      $data["session_id"] = session('_token');
  
      //Create item
      $this->cart = $this->cartRepository()->create($data);
      request()->session()->put('cart', $this->cart);
   
    }
   
  }
  
  public function addToCart($productId, $quantity = 1, $productOptionValues = [])
  {
    $data = [
      "cart_id" => $this->cart->id,
      "product_id" =>  $productId,
      "quantity" => $quantity,
      "product_option_values" => $productOptionValues
    ];
    
    $this->cartProductRepository()->create($data);
    $this->updateCart();
  }
  
  public function deleteFromCart($cartProductId)
  {
    $params = json_decode(json_encode(["include" => []]));
    $result = $this->cartProductRepository()->deleteBy($cartProductId,$params);

    $this->updateCart();
    $this->dispatchBrowserEvent(
      'alert', ['type' => 'success',  'message' => 'Saved']);
  }
  
  public function updateCart(){
  
    $params = json_decode(json_encode(["include" => []]));
    $this->cart = $this->cartRepository()->getItem($this->cart->id,$params);
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
  public function cartRepository()
  {
    return  app('Modules\Icommerce\Repositories\CartRepository');
  }
  /**
   * @return cartProductRepository
   */
  public function cartProductRepository()
  {
    return app('Modules\Icommerce\Repositories\CartProductRepository');
  }
}
