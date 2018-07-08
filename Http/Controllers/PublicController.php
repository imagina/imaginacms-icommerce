<?php

namespace Modules\Icommerce\Http\Controllers;

use Mockery\CountValidator\Exception;

use Modules\Core\Http\Controllers\BasePublicController;
use Route;
use Log;
use Illuminate\Http\Request;
use Modules\User\Contracts\Authentication;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Icommerce\Repositories\ShippingRepository;
use Modules\Icommerce\Repositories\PaymentRepository;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Iprofile\Repositories\AddressRepository;
use Anam\Phpcart\Cart as Carting;
use Modules\Icommerce\Entities\Order;
use Modules\Icommerce\Entities\Order_History;
use Modules\Icommerce\Entities\Order_Product;
use Modules\Notification\Services\Notification;
use Modules\Icommerce\Transformers\ProductTransformer;
use Modules\Iprofile\Transformers\AddressesTransformer;
use Modules\Setting\Contracts\Setting;
use Modules\Iprofile\Repositories\ProfileRepository;

class PublicController extends BasePublicController
{
  private $cart;
  private $product;
  private $currency;
  private $setting;
  private $shipping;
  private $payments;
  private $category;
  protected $auth;
  private $notification;
  private $manufacturer;
  private $profile;
  private $address;
  
  public function __construct(
    ProductRepository $product,
    CurrencyRepository $currency,
    ShippingRepository $shipping,
    PaymentRepository $payments,
    CategoryRepository $category,
    Notification $notification,
    Setting $setting,
    ManufacturerRepository $manufacturer,
    ProfileRepository $profile,
    AddressRepository $address)
  {
    parent::__construct();
    $this->cart = new Carting();
    $this->product = $product;
    $this->currency = $currency;
    $this->shipping = $shipping;
    $this->payments = $payments;
    $this->category = $category;
    $this->auth = app(Authentication::class);
    $this->notification = $notification;
    $this->manufacturer = $manufacturer;
    $this->setting = $setting;
    $this->profile = $profile;
    $this->address = $address;
  }
  
  
  // view products by category
  public function index()
  {
    $uri = Route::current()->uri();
    $tpl = 'icommerce::frontend.index';
    $ttpl = 'icommerce.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    if (!empty($uri)) {
      $category = $this->category->findBySlug($uri);
      $products = $this->product->whereCategory($category->id);
      //$productsFeatured = json_decode(json_encode(ProductTransformer::collection($products)));
      $currency = $this->currency->getActive();
      $user = $this->auth->user();
      
      
      (isset($user) && !empty($user)) ? $user = $user->id : $user = 0;
      
      //Get Custom Template.
      $ctpl = "icommerce.category.{$category->id}.index";
      if (view()->exists($ctpl)) $tpl = $ctpl;
    }
    
    return view($tpl, compact('category', 'user', 'products', 'currency'));
    
  }
  
  // view products by freeshipping
  public function freeshipping()
  {
    
    $uri = Route::current()->uri();
    $tpl = 'icommerce::frontend.freeshipping.index';
    $ttpl = 'icommerce.freeshipping.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    
    if (!empty($uri)) {
      $products = $this->product->whereFreeshippingProducts(); //consulta
      
      $currency = $this->currency->getActive();
      
      $user = $this->auth->user();
      (isset($user) && !empty($user)) ? $user = $user->id : $user = 0;
      
      //Get Custom Template.
      //$ctpl = "icommerce.category.{$category->id}.index";
      //if(view()->exists($ctpl)) $tpl = $ctpl;
    }
    
    
    return view($tpl, compact('user', 'products', 'currency'));
    
  }
  
  // view result search
  public function search()
  {
    $criterion = isset($_GET['search']) ? $_GET['search'] : false;
    
    $tpl = 'icommerce::frontend.index';
    $ttpl = 'icommerce.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    $data = $this->product->whereFeaturedProducts(5);
    $productsFeatured = json_decode(json_encode(ProductTransformer::collection($data)));
    $category = false;
    $user = $this->auth->user();
    (isset($user) && !empty($user)) ? $user = $user->id : $user = false;
    
    return view($tpl, compact('productsFeatured', 'category', 'criterion', 'locale', 'user'));
  }
  
  // Informacion de Producto
  public function show()
  {
    $slug = Route::current()->uri();
    $tpl = 'icommerce::frontend.show';
    
    $ttpl = 'icommerce.show';
    if (view()->exists($ttpl)) $tpl = $ttpl;
    $product = $this->product->findBySlug($slug);
    
    $user = $this->auth->user();
    (isset($user) && !empty($user)) ? $user = $user->id : $user = 0;
    
    return view($tpl, compact('product', 'user'));
  }
  
  
  // categories
  public function categories()
  {
    $tpl = 'icommerce::frontend.categories';
    $ttpl = 'icommerce.categories';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    $categories = $this->category->all();
    
    return view($tpl, compact('categories'));
  }
  
  
  /* ==== check ==== */
  
  public function checkout()
  {
    
    $tpl = 'icommerce::frontend.checkout.index';
    $ttpl = 'icommerce.checkout.index';
    $payments = $this->payments->getPaymentsMethods();
    $currency = $this->currency->getActive();
    $user = $this->auth->user();
    $items = $this->getItems();
    $shipping = $this->shipping->getShippingsMethods($items,'US');
    $tax = $this->setting->get('icommerce::tax');
    $defaultCountry = $this->setting->get('icommerce::country-default');
    $countryFreeshipping = $this->setting->get('icommerce::country-freeshipping');
    $ttpl = 'icommerce.checkout';
    $addresses = '';
    $addressSelect = '';
    if (isset($user) && !empty($user)) {
      $profile = $this->profile->findByUserId($user->id);
      $addresses = $this->address->findByProfileId($profile->id);
 
      $addressSelect = json_encode(AddressesTransformer::collection($addresses));

    }
    
    $passwordRandom = substr(md5(microtime()), 1, 8);
    
    
    //if(view()->exists($ttpl)) $tpl = $ttpl;
    
    return view($tpl, compact('defaultCountry', 'countryFreeshipping', 'addresses', 'addressSelect', 'shipping', 'payments', 'currency', 'user', 'items', 'tax', 'passwordRandom'));
  }
  
  // Traer items del carrito
  public function getItems()
  {
    $items = $this->cart->getItems();
    $weight = 0;
    
    foreach ($items as $index => $item) {
      $item->weight ? $weight += $item->weight : false;
    }
    
    return [
      'items' => $items,
      'quantity' => $this->cart->totalQuantity(),
      'total' => number_format($this->cart->getTotal(), 2),
      'weight' => $weight
    ];
  }
  
  public function cart()
  {
    $tpl = 'icommerce::frontend.cart.cart';
    $currency = $this->currency->getActive();
    $ttpl = 'icommerce.cart.cart';
    if (view()->exists($ttpl)) $tpl = $ttpl;
    $items = $this->getItems();
    return view($tpl, compact('items', 'currency'));
  }
  
  public function wishlist()
  {
    $tpl = 'icommerce::frontend.wishlist.index';
    
    $ttpl = 'icommerce.wishlist.index';
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    $user = $this->auth->user();
    (isset($user) && !empty($user)) ? $user = $user->id : $user = 0;
    
    return view($tpl, compact('user'));
  }
  
  public function bulk_load()
  {
    $tpl = 'icommerce::frontend.bulk_load';
    $user = $this->auth->user();
    
    
    return view($tpl, compact('user'));
  }
}