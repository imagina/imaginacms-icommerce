<?php

namespace Modules\Icommerce\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Entities\Currency;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Transformers\CategoryTransformer;
use Modules\Icurrency\Repositories\CurrencyRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Iprofile\Repositories\UserApiRepository;
use Modules\Icommerce\Transformers\PaymentMethodTransformer;
use Modules\Icommerce\Transformers\ShippingMethodTransformer;
use Modules\Icommerce\Transformers\ProductTransformer;
use Route;

class OldPublicController extends BasePublicController
{
  protected $auth;
  private $product;
  private $category;
  private $currency;
  private $payments;
  private $shippings;
  
  public function __construct(
    ProductRepository $product,
    CategoryRepository $category,
    CurrencyRepository $currency,
    PaymentMethodRepository $payments,
    ShippingMethodRepository $shippings
  )
  {
    parent::__construct();
    $this->product = $product;
    $this->category = $category;
    $this->currency = $currency;
    $this->payments = $payments;
    $this->shippings = $shippings;
  }
  
  // view products by category
  public function index(Request $request)
  {
    $slug = \Request::path();

    $tpl = 'icommerce::frontend.index';
    $ttpl = 'icommerce.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;

    $category = $this->category->findBySlug($slug);
    
    $params = $this->_paramsRequest($request,$category->id);
    
    $products = $this->product->getItemsBy($params);
  
    $configFilters = config("asgard.icommerce.config.filters");
    $configFilters["categories"]["itemSelected"] = $category;
    
    $ptpl = "icommerce.category.{$category->parent_id}%.index";
    if ($category->parent_id != 0 && view()->exists($ptpl)) {
      $tpl = $ptpl;
    }
    
    $ctpl = "icommerce.category.{$category->id}.index";
    if (view()->exists($ctpl)) $tpl = $ctpl;
    
    $ctpl = "icommerce.category.{$category->id}%.index";
    if (view()->exists($ctpl)) $tpl = $ctpl;
    
    $paginate=(object)[
      "total" => $products->total(),
      "lastPage" => $products->lastPage(),
      "perPage" => $products->perPage(),
      "currentPage" => $products->currentPage()
    ];
    
    $products=ProductTransformer::collection($products);
  
    $categoryBreadcrumb = CategoryTransformer::collection(Category::ancestorsAndSelf($category->id));
    
    $gallery = $this->getGalleryCategory($category);
  
    config(["asgard.icommerce.config.filters" => $configFilters]);
  
    $title = (isset($category->id) ? ($category->h1_title ?? $category->title) : '');

    return view($tpl, compact('category','products','paginate','categoryBreadcrumb','gallery','title'));
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
 
      if($product->url != request()->url()) return redirect($product->url);
      
      $category= $product->category;
      $categoryBreadcrumb = CategoryTransformer::collection(Category::ancestorsAndSelf($category->id));
  
      return view($tpl, compact('product','category','categoryBreadcrumb'));
      
    }else{
      return response()->view('errors.404', [], 404);
    }
    
  }
  
  public function checkout()
  {
  
    $tpl = 'icommerce::frontend.checkout.index';
    $ttpl = 'icommerce.checkout.index';
    if (view()->exists($ttpl)) $tpl = $ttpl;
  
    $cart = request()->session()->get('cart');
    if(isset($cart->id)) {
      $cart = app('Modules\Icommerce\Repositories\CartRepository')->getItem($cart->id);
    }
    $currency = Currency::where("default_currency",1)->first();
    return view($tpl,compact('cart','currency'));
  }
  

  
  private function _paramsRequest($request,$category)
  {
    
    $maxPrice=$request->input('maxPrice')??100000000000000000000000000000;
    $minPrice=$request->input('minPrice')??0;
    $options=$request->input('options')??null;
    $manufacturer=$request->input('manufacturer')??null;
    $search=$request->input('search')??$request->input('q')??null;
    $currency=$request->input('currency')??null;
    $order=["field"=>$request->input('orderField')??"created_at","way"=>$request->input('orderWay')??"desc"];
    
    //Return params
    $params = (object)[
      "page" => is_numeric($request->input('page')) ? $request->input('page') : 1,
      "take" => is_numeric($request->input('take')) ? $request->input('take') :
        ($request->input('page') ? 12 : null),
      "include" =>[],
      "filter" => json_decode(json_encode(['categories'=>$category,'manufacturers'=>$manufacturer,'priceRange'=>['from'=>$minPrice,'to'=>$maxPrice],'search'=>$search,'order'=>$order,'status'=>1])),
    ];
    //Set locale to filter
    $params->filter->locale = \App::getLocale();
    return $params;//Response
  }

  /**
  * Get Images to gallery top Category
  *
  */
  protected function getGalleryCategory($category){

    $gallery = [];

    $typeGallery = setting('icommerce::carouselIndexCategory',null,'carousel-category-active');
    if(isset($category->id)){

      if($category->parent_id!=null && $typeGallery=="carousel-category-parent"){
        $category = Category::whereAncestorOf($category)->whereNull("parent_id")->first();
      }

      $mediaFiles = $category->mediaFiles();
      if(isset($mediaFiles->carouselindeximage)){
        $gallery = $mediaFiles->carouselindeximage;
      } 

    }

    return $gallery;

  }
  
}
