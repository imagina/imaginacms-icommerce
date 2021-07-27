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
  public $productToQuote;
  public $showButton;
  public $icon;
  public $iconquote;
  private $params;
  private $request;
  protected $listeners = ['addToCart', 'download', 'deleteFromCart', 'updateCart', 'deleteCart', 'refreshCart', 'makeQuote','requestQuote','submitQuote'];
  
  public function mount(Request $request, $layout = 'cart-button-layout-1', $icon = 'fa fa-shopping-cart',$iconquote = 'fas fa-file-alt', $showButton = true)
  {
    

    $this->showButton = $showButton;
    $this->layout = $layout;
    $this->icon = $icon;
    $this->iconquote = $iconquote;
    $this->view = "icommerce::frontend.livewire.cart.layouts.$this->layout.index";
    
    //$this->refreshCart();
  }
  
  //|--------------------------------------------------------------------------
  //| Livewire Events
  //|--------------------------------------------------------------------------
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
  
  public function addToCart($productId, $quantity = 1, $productOptionValues = [], $isCall = false)
  {
    
    try {
      $product = $this->productRepository()->getItem($productId);
      
      if(isset($product->id)){
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
  
      }else{
        $this->alert('warning', trans('icommerce::cart.message.add'), config("asgard.isite.config.livewireAlerts"));
      }
      
      
    } catch (\Exception $e) {

      switch($e->getMessage()){
        case 'Invalid product':
          $this->alert('warning', trans('icommerce::cart.message.invalid_product'), config("asgard.isite.config.livewireAlerts"));
          break;
  
        case 'Missing required product options':
          $this->alert('warning', trans('icommerce::cart.message.product_with_required_options'), config("asgard.isite.config.livewireAlerts"));
          $this->redirect($product->url);
          break;
          
        case 'Product Quantity Unavailable':
          $this->alert('warning', trans('icommerce::cart.message.quantity_unavailable',["quantity" => $product->quantity ?? 0]), config("asgard.isite.config.livewireAlerts"));
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

  public function download()
  {
    $Viewdownload = 'icommerce::frontend.livewire.cart.pdf.pdf';


    $contain = [
      'cart' => $this->cart,
    ];

    //Esa variable contain. Si está seguro de que le llega a la vista? por que el pdf
    //no le está generando nada de lo que tiene que ver con esa variable "cart"

    $pdf = \PDF::loadView($Viewdownload, [      'cart' => $this->cart    ])->save(storage_path('app/exports/') . 'cotización.pdf');

    return \Storage::disk('exports')->download('cotización.pdf');
  }

  public function requestQuote()
  {
    $this->dispatchBrowserEvent('QuoteModal',[]);
  }

  public function submitQuote($data)
  {
    $order =[
      "first_name" => $data["first_name"] ?? "",
      "last_name" => $data["last_name"] ?? "",
      "email" => $data["email"] ?? "",
      "telephone" => $data["telephone"] ?? "",
      "type" => "quote"
    ];

    if(isset($data["first_name"])) unset($data["first_name"]);
    if(isset($data["last_name"])) unset($data["last_name"]);
    if(isset($data["email"])) unset($data["email"]);
    if(isset($data["telephone"])) unset($data["telephone"]);
    if(isset($data["form_id"])) unset($data["form_id"]);
    if(isset($data["_token"])) unset($data["_token"]);

    $order["options"] = ["quoteForm" => $data];

    $order["cart"] = $this->cart;

    $order = $this->orderService()->create($order);

    $Viewdownload = 'icommerce::frontend.livewire.cart.pdf.pdf';

    $contain = [
      'data' => ['order' => $order["order"]],
      'content' => "icommerce::emails.order"
    ];

    $pdf = \PDF::loadView($Viewdownload, $contain)->save(storage_path('app/exports/') . 'cotización.pdf');;

    return \Storage::disk('exports')->download('cotización.pdf');
  }

  public function makeQuote($productId)
  {

    $productToQuote = $this->productRepository()->getItem($productId);
    
    $this->dispatchBrowserEvent('productToQuoteModal',["productName" => $productToQuote->name]);

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

  }

  //|--------------------------------------------------------------------------
  //| Properties
  //|--------------------------------------------------------------------------
  public function getContainIsCallProperty(): bool
  {
    $isCall = false;

    foreach ($this->cart->products as $cartProduct){

      if($cartProduct->is_call) $isCall = true;
      if($cartProduct->product->is_call) $isCall = true;

    }

    return $isCall;
  }

  /**
   * @return
   */
  public function getNotContainIsCallProperty()
  {
    $notIsCall = false;

    foreach ($this->cart->products as $cartProduct){

      if(!$cartProduct->is_call && !$cartProduct->product->is_call) $notIsCall = true;

    }

    return $notIsCall;
  }

}
