<?php

namespace Modules\Icommerce\Http\Controllers;

use Mockery\CountValidator\Exception;

use Modules\Core\Http\Controllers\BasePublicController;
use Route;
use Log;
use Illuminate\Http\Request;
use Modules\User\Contracts\Authentication;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Iprofile\Repositories\UserApiRepository;

class PublicController extends BasePublicController
{
  protected $auth;
  private $product;
  private $category;
  private $currency;
  private $payments;
  private $shippings;
  private $user;

  public function __construct(
    ProductRepository $product,
    CategoryRepository $category,
    CurrencyRepository $currency,
    PaymentMethodRepository $payments,
    UserApiRepository $user,
    ShippingMethodRepository $shippings
    )
    {
      parent::__construct();
      $this->auth = app(Authentication::class);
      $this->product = $product;
      $this->category = $category;
      $this->currency = $currency;
      $this->payments = $payments;
      $this->shippings = $shippings;
      $this->user = $user;

    }

    // view products by category
    public function index()
    {
        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        $uri=explode('/',Route::current()->uri());
        //dd($uri);
        // if($uri[0]===$locale){
        //     unset($uri[0]);
        //     $uri= implode('/', $uri);
        // }else {
        //     $uri =implode('/',$uri);
        // };
        //
      $tpl = 'icommerce::frontend.index';
      $ttpl = 'icommerce.index';
      if (view()->exists($ttpl)) $tpl = $ttpl;

      if (!empty($uri)) {
        $category = $this->category->getItem($uri,json_decode(json_encode(['include'=>['children','products'],'fields'=>[],'filter'=>['field'=>'slug','locale'=>\App::getLocale()]])));
        $category = new \Modules\Icommerce\Transformers\CategoryTransformer($category);
        //dd($category->products);
        $currency = $this->currency->getActive();
        $user = $this->auth->user();
        (isset($user) && !empty($user)) ? $user = $user->id : $user = 0;
        //Get Custom Template.
        $ctpl = "icommerce.category.{$category->id}.index";
        if (view()->exists($ctpl)) $tpl = $ctpl;
      }

      return view($tpl, compact('category', 'user', 'currency'));

    }

    // Informacion de Producto
    public function show()
    {
      $user = $this->auth->user();
      (isset($user) && !empty($user)) ? $user = $user->id : $user = 0;
      $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
      $uri=explode('/',Route::current()->uri());
      // dd($uri);
      // if($uri[0]===$locale){
      //   unset($uri[0]);
      //   $uri= implode('/', $uri);
      // }else {
      //   $uri =implode('/',$uri);
      // };
      $tpl = 'icommerce::frontend.show';
      $ttpl = 'icommerce.show';
      if (view()->exists($ttpl)) $tpl = $ttpl;
      $product=\Modules\Icommerce\Entities\ProductTranslation::where('slug', $uri[0])->first();
      $product=$this->product->find($product->product_id);
      $product=new \Modules\Icommerce\Transformers\ProductTransformer($product);
      return view($tpl, compact('product','user'));
    }//show()

    public function checkout()
    {
      $tpl = 'icommerce::frontend.checkout.index';
      $ttpl = 'icommerce.checkout.index';
      $payments = $this->payments->getItemsBy((object)['filter'=>[],'fields'=>[],'include'=>[],'take'=>4]);
      $payments=\Modules\Icommerce\Transformers\PaymentMethodTransformer::collection($payments);
      //dd($payments);
      $currency = $this->currency->getActive();
      $user = $this->auth->user();
      if($user){
        $user=$this->user->getItem($user->id,(object)['include'=>['addresses','fields'],'filter'=>[],'fields'=>[]]);
        $user=new \Modules\Iprofile\Transformers\UserTransformer($user);
      }
      // dd($user);
      // $items = $this->getItems();
      // $shipping = [];
      $shippings = $this->shippings->getItemsBy((object)['filter'=>[],'fields'=>[],'include'=>[],'take'=>4]);
      $shippings=\Modules\Icommerce\Transformers\ShippingMethodTransformer::collection($shippings);
      // dd($shippings);
      // $tax = $this->setting->get('icommerce::tax');
      // $defaultCountry = $this->setting->get('icommerce::country-default');
      // $countryFreeshipping = $this->setting->get('icommerce::country-freeshipping');

      if(view()->exists($ttpl)) $tpl = $ttpl;
      return view($tpl,[
        "payments"=>$payments,
        "shipping"=>$shippings,
        "user"=>$user,
        "currency"=>$currency
      ]);
      // return view($tpl, compact('defaultCountry', 'countryFreeshipping', 'addresses', 'addressSelect', 'shipping', 'payments', 'profile','currency', 'user', 'items', 'tax', 'passwordRandom'));
    }

  }
