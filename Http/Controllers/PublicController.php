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
    public function index()
    {

        $slug = \Request::path();

        $tpl = 'icommerce::frontend.index';
        $ttpl = 'icommerce.index';

        if (view()->exists($ttpl)) $tpl = $ttpl;

        $category = $this->category->findBySlug($slug);

        $currency = $this->currency->getActive();
        $user = $this->auth->user();
        (isset($user) && !empty($user)) ? $user = $user->id : $user = 0;

        $ctpl = "icommerce.category.{$category->id}.index";
        if (view()->exists($ctpl)) $tpl = $ctpl;


        return view($tpl, compact('category', 'user', 'currency'));


    }

    // Informacion de Producto
    public function show($slug)
    {
        $tpl = 'icommerce::frontend.show';
        $ttpl = 'icommerce.show';
        if (view()->exists($ttpl)) $tpl = $ttpl;
        $product = $this->product->findBySlug($slug);

        return view($tpl, compact('product'));

    }

    public function checkout()
    {
        $tpl = 'icommerce::frontend.checkout.index';
        $ttpl = 'icommerce.checkout.index';
        $payments = $this->payments->getItemsBy((object)['filter' => [], 'fields' => [], 'include' => [], 'take' => 4]);
        $payments = \Modules\Icommerce\Transformers\PaymentMethodTransformer::collection($payments);
        //dd($payments);
        $currency = $this->currency->getActive();
        $user = $this->auth->user();
        if ($user) {
            $user = $this->user->getItem($user->id, (object)['include' => ['addresses', 'fields'], 'filter' => [], 'fields' => []]);
            $user = new \Modules\Iprofile\Transformers\UserTransformer($user);
        }
        $shippings = $this->shippings->getItemsBy((object)['filter' => [], 'fields' => [], 'include' => [], 'take' => 4]);
        $shippings = \Modules\Icommerce\Transformers\ShippingMethodTransformer::collection($shippings);

        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl, [
            "payments" => $payments,
            "shipping" => $shippings,
            "user" => $user,
            "currency" => $currency
        ]);
    }

}
