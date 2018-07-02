<?php

namespace Modules\Icommerce\Http\Controllers;

use Mockery\CountValidator\Exception;

use Modules\Core\Http\Controllers\BasePublicController;
use Route;
use Illuminate\Http\Request;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\CurrencyRepository;

class ManufacturerController extends BasePublicController
{
  
    private $manufacturer;
    private $product;
    private $currency;

    public function __construct(
        ManufacturerRepository $manufacturer,
        ProductRepository $product,
        CurrencyRepository $currency
        )
    {
        parent::__construct();
        $this->manufacturer = $manufacturer;
        $this->product = $product;
        $this->currency = $currency;
    }

   
    public function index()
    {

        $uri = Route::current()->uri();
        $tpl = 'icommerce::frontend.manufacturer.index';
        $ttpl='icommerce.manufacturer.index';

        if(view()->exists($ttpl)) $tpl = $ttpl;

        if(empty($uri)) {
            //Root
        } else {
            
            $manufacturers = $this->manufacturer->withFile();
           
        }

        return view($tpl, compact('manufacturers'));
       
    }

   
    public function show($id)
    {

        $uri = Route::current()->uri();
        $tpl = 'icommerce::frontend.manufacturer.show';
        $ttpl='icommerce.manufacturer.show';

        if(view()->exists($ttpl)) $tpl = $ttpl;

        if(!empty($uri)) {
            $manufacturer = $this->manufacturer->findByid($id);
            $products = $this->product->whereManufacturer($manufacturer->id);
            $currency = $this->currency->getActive();
            $user = $this->auth->user();


            (isset($user) && !empty($user)) ? $user = $user->id : $user = 0;

            //Get Custom Template.
            $ctpl = "icommerce.manufacturer.{$manufacturer->id}.index";
            if(view()->exists($ctpl)) $tpl = $ctpl;
        }

        return view($tpl, compact('manufacturer', 'user','products', 'currency'));

    }

  

}