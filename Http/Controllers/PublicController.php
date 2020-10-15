<?php

namespace Modules\Icommerce\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icurrency\Repositories\CurrencyRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Iprofile\Repositories\UserApiRepository;
use Modules\Icommerce\Transformers\PaymentMethodTransformer;
use Modules\Icommerce\Transformers\ShippingMethodTransformer;
use Modules\Icommerce\Transformers\ProductTransformer;
use Route;

use Modules\Setting\Contracts\Setting;
use Modules\Icommerce\Entities\Product;

class PublicController extends BasePublicController
{
  protected $auth;
  private $product;
  private $category;
  private $currency;
  private $payments;
  private $shippings;
  private $setting;

  public function __construct(
    ProductRepository $product,
    CategoryRepository $category,
    CurrencyRepository $currency,
    PaymentMethodRepository $payments,
    ShippingMethodRepository $shippings,
    Setting $setting
  )
  {
    parent::__construct();
    $this->product = $product;
    $this->category = $category;
    $this->currency = $currency;
    $this->payments = $payments;
    $this->shippings = $shippings;
    $this->setting = $setting;
  }

  /**
  * Index - View products by category
  * @param  $request
  * @return view, category,categories, products, paginate
  */
  public function index(Request $request)
  {

    $slug = \Request::path();

    // Get Template Base
    $tpl = 'icommerce::frontend.index';
    $ttpl = 'icommerce.index';
    if (view()->exists($ttpl)) $tpl = $ttpl;

    $category = $this->category->findBySlug($slug);
    $categories = $this->category->all();
    $maxPriceP = (int)Product::get()->max('price');
    $maxPrice = $maxPriceP ? $maxPriceP : 9999999;

    // Get Params to filters
    $params=$this->_paramsRequest($request,$category->id,$maxPrice);
    $products = $this->product->getItemsBy($params);

    // Get Templates
    $ptpl = "icommerce.category.{$category->parent_id}%.index";
    if ($category->parent_id != 0 && view()->exists($ptpl)) {
      $tpl = $ptpl;
    }

    $ctpl = "icommerce.category.{$category->id}.index";
    if (view()->exists($ctpl)) $tpl = $ctpl;

    $ctpl = "icommerce.category.{$category->id}%.index";
    if (view()->exists($ctpl)) $tpl = $ctpl;

    // Separat pagination
    $paginate=(object)[
      "total" => $products->total(),
      "lastPage" => $products->lastPage(),
      "perPage" => $products->perPage(),
      "currentPage" => $products->currentPage()
    ];

    // Transforms Products
    $products= ProductTransformer::collection($products);

    return view($tpl, compact('category','categories','products','maxPrice','paginate'));

  }

  // Informacion de Producto
  public function show($slug)
  {

    $tpl = 'icommerce::frontend.show';
    $ttpl = 'icommerce.show';
    if (view()->exists($ttpl)) $tpl = $ttpl;
    $params = json_decode(json_encode(
      [
        "include" => explode(",","translations,category,categories,tags,addedBy"),
        "filter" => [
          "field" => "slug"
        ]
      ]
    ));

    $product = $this->product->getItem($slug,$params);

    if($product){
      $category= $product->category;
      return view($tpl, compact('product','category'));

    }else{
      return response()->view('errors.404', [], 404);
    }

  }

  public function checkout()
  {
    $tpl = 'icommerce::frontend.checkout.index';
    $ttpl = 'icommerce.checkout.index';
    if (view()->exists($ttpl)) $tpl = $ttpl;
    return view($tpl);
  }

  public function wishlist()
  {
    $tpl = 'icommerce::frontend.wishlist.index';
    $ttpl = 'icommerce.wishlist.index';

    if (view()->exists($ttpl)) $tpl = $ttpl;
    return view($tpl);
  }

  // view products by category
  public function search(Request $request)
  {

    $tpl = 'icommerce::frontend.search';
    $ttpl = 'icommerce.search';

    if (view()->exists($ttpl)) $tpl = $ttpl;
    $category=$request->input('category')??null;
    $params=$this->_paramsRequest($request,$category);

    $products = $this->product->getItemsBy($params);

    $products=ProductTransformer::collection($products);

    $paginate=(object)[
      "total" => $products->total(),
      "lastPage" => $products->lastPage(),
      "perPage" => $products->perPage(),
      "currentPage" => $products->currentPage()
    ];

    return view($tpl, compact('products','paginate', 'category'));


  }

  /**
  * Params Requests to Filters
  * @param  $request, $category
  * @return array params
  */
  private function _paramsRequest($request,$category,$maxPrice)
  {

    // Get Settings
    $productsPerPage = (int)$this->setting->get('icommerce::product-per-page');
    
    // Validate Default Settings
    $pPerPage = $productsPerPage ? $productsPerPage : 12;
    
    $maxPrice=$request->input('maxPrice')??$maxPrice;
    $minPrice=$request->input('minPrice')??0;
    $options=$request->input('options')??null;
    $manufacturer=$request->input('manufacturer')??null;
    $search=$request->input('search')??$request->input('q')??null;
    $order=["field"=>$request->input('orderField')??"created_at","way"=>$request->input('orderWay')??"desc"];

    //Return params
    $params = (object)[
      "page" => is_numeric($request->input('page')) ? $request->input('page') : 1,
      "take" => is_numeric($request->input('take')) ? $request->input('take') : $pPerPage,
      "include" =>[],
      "filter" => json_decode(json_encode(['categories'=>$category,'manufacturers'=>$manufacturer,'priceRange'=>['from'=>$minPrice,'to'=>$maxPrice],'search'=>$search,'order'=>$order,'status'=>1])),
    ];

    //Set locale to filter
    $params->filter->locale = \App::getLocale();

    return $params;//Response
  }

}
