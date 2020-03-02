<?php

namespace Modules\Icommerce\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Iprofile\Repositories\UserApiRepository;
use Modules\User\Contracts\Authentication;
use Route;

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
    public function index($icommerceCategory)
    {
        try {
            $tpl = 'icommerce::frontend.index';
            $ttpl = 'icommerce.index';

            if (view()->exists($ttpl)) $tpl = $ttpl;

            $category = $this->category->getItem($icommerceCategory, json_decode(json_encode(['include' => ['children', 'products'], 'fields' => [], 'filter' => ['field' => 'slug', 'locale' => \App::getLocale()]])));
            $category = new \Modules\Icommerce\Transformers\CategoryTransformer($category);

            $currency = $this->currency->getActive();
            $user = $this->auth->user();
            (isset($user) && !empty($user)) ? $user = $user->id : $user = 0;

            $ctpl = "icommerce.category.{$category->id}.index";
            if (view()->exists($ctpl)) $tpl = $ctpl;


            return view($tpl, compact('category', 'user', 'currency'));

        } catch (\ModelNotFoundException $e) {

            return $this->show($icommerceCategory);

        }

    }

    // Informacion de Producto
    public function show($icommerceProduct)
    {
        try {
            $user = $this->auth->user();
            (isset($user) && !empty($user)) ? $user = $user->id : $user = 0;
            $tpl = 'icommerce::frontend.show';
            $ttpl = 'icommerce.show';
            if (view()->exists($ttpl)) $tpl = $ttpl;
            $product = $this->product->findBySlug('slug', $icommerceProduct);

            return view($tpl, compact('product', 'user'));
        } catch (\ModelNotFoundException $e) {
            $page = app(\Modules\Page\Http\Controllers\PublicController::class)->uri($icommerceProduct);
            return $page;
        }

    }

    public function checkout()
    {
      $tpl = 'icommerce::frontend.checkout.index';
      $ttpl = 'icommerce.checkout.index';
      $params=['filter'=>["status"=>1],'fields'=>[],'include'=>[],'take'=>4];
      $params=json_decode(json_encode($params));
      $payments = $this->payments->getItemsBy($params);
      $payments=\Modules\Icommerce\Transformers\PaymentMethodTransformer::collection($payments);
      $currency = $this->currency->getActive();
      $user = $this->auth->user();
      if($user){
        $user=$this->user->getItem($user->id,(object)['include'=>['addresses','fields'],'filter'=>[],'fields'=>[]]);
        $user=new \Modules\Iprofile\Transformers\UserTransformer($user);
      }
      $params=['filter'=>["status"=>1],'fields'=>[],'include'=>[],'take'=>4];
      $params=json_decode(json_encode($params));
      $shippings = $this->shippings->getItemsBy($params);
      $shippings=\Modules\Icommerce\Transformers\ShippingMethodTransformer::collection($shippings);


      if(view()->exists($ttpl)) $tpl = $ttpl;
      return view($tpl,[
        "payments"=>$payments,
        "shipping"=>$shippings,
        "user"=>$user,
        "currency"=>$currency
      ]);
    }//checkout()

}
