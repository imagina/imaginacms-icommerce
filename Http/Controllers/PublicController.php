<?php

namespace Modules\Icommerce\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Entities\Currency;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Icommerce\Transformers\CartTransformer;
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
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class PublicController extends BaseApiController
{
  protected $auth;
  private $product;
  private $category;
  private $manufacturer;
  private $currency;
  private $payments;
  private $shippings;
  
  public function __construct(
    ProductRepository $product,
    CategoryRepository $category,
    ManufacturerRepository $manufacturer,
    CurrencyRepository $currency,
    PaymentMethodRepository $payments,
    ShippingMethodRepository $shippings
  )
  {
    parent::__construct();
    $this->product = $product;
    $this->category = $category;
    $this->manufacturer = $manufacturer;
    $this->currency = $currency;
    $this->payments = $payments;
    $this->shippings = $shippings;
  }

  // view products by category
  public function index(Request $request)
  {
    $argv = explode("/",$request->path());
    $slug = end($argv);

    $tpl = 'icommerce::frontend.index';
  
    $category = null;
  
    $categoryBreadcrumb = [];
    $carouselImages =[];

    $gallery = [];
    
    $configFilters = config("asgard.icommerce.config.filters");
    
    if($slug && $slug != trans('icommerce::routes.store.index.index')){
      
      $category = $this->category->findBySlug($slug);
    
      if(isset($category->id)){
        $categoryBreadcrumb = CategoryTransformer::collection(Category::ancestorsAndSelf($category->id));
       
        $ptpl = "icommerce.category.{$category->parent_id}%.index";
        if ($category->parent_id != 0 && view()->exists($ptpl)) {
          $tpl = $ptpl;
        }
  
        $ctpl = "icommerce.category.{$category->id}.index";
        if (view()->exists($ctpl)) $tpl = $ctpl;
  
        $ctpl = "icommerce.category.{$category->id}%.index";
        if (view()->exists($ctpl)) $tpl = $ctpl;

        // Carousel Top
        $carouselImages = $this->getImagesToCarousel($category);

        // Carousel Right over ProductList with settings to images categories
        $gallery = $this->getGalleryCategory($category);
        
        $configFilters["categories"]["itemSelected"] = $category;
        
      }else{
        return response()->view('errors.404', [], 404);
      }
      
      
    }else{
      //Default breadcrumb
      $configFilters["categories"]["breadcrumb"] = [];
    }
    
  
    config(["asgard.icommerce.config.filters" => $configFilters]);

    return view($tpl, compact('category','categoryBreadcrumb','carouselImages','gallery'));
  }

  // view products by category
  public function indexManufacturer(Request $request)
  {
    $argv = explode("/",$request->path());
    $slug = end($argv);
  
    $tpl = 'icommerce::frontend.index';
    $ttpl = 'icommerce.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;
  
    $manufacturer = null;
  
    $categoryBreadcrumb = [];
    $carouselImages =[];
    
    if($slug && $slug != trans('icommerce::routes.store.index')){
  
      $manufacturer = $this->manufacturer->findBySlug($slug);
    
      if(isset($manufacturer->id)){
  
        //Remove manufacturer filters of this index, its not necessary
        $configFilters = config("asgard.icommerce.config.filters");
        unset($configFilters["manufacturers"]);
  
        $configFilters["categories"]["params"] = ["filter" => ["manufacturers" => $manufacturer->id]];
        config(["asgard.icommerce.config.filters" => $configFilters]);
  
        $ctpl = "icommerce.manufacturer.{$manufacturer->id}.index";
        if (view()->exists($ctpl)) $tpl = $ctpl;
  
        $ctpl = "icommerce.manufacturer.{$manufacturer->id}%.index";
        if (view()->exists($ctpl)) $tpl = $ctpl;

        // Carousel Top
        $carouselImages = $this->getImagesToCarousel($manufacturer);
        
        
        
        
      }else{
        return response()->view('errors.404', [], 404);
      }
      
    }

    //$dataRequest = $request->all();

    return view($tpl, compact('manufacturer','categoryBreadcrumb','carouselImages'));
  }  // view products by category
  
  public function indexOffers(Request $request)
  {
    $argv = explode("/",$request->path());

  
    $tpl = 'icommerce::frontend.index';
    $ttpl = 'icommerce.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    $withDiscount = false;
    
    if($slug && $slug != trans('icommerce::routes.store.index')){
  
      $withDiscount = true;
      
    }

    return view($tpl, compact('withDiscount'));
  }

  // view products by category
  public function indexCategoryManufacturer(Request $request, $categorySlug, $manufacturerSlug)
  {
    $argv = explode("/",$request->path());
  
    $tpl = 'icommerce::frontend.index';
    $ttpl = 'icommerce.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;
  
    $manufacturer = null;
    $category = null;
  
    $categoryBreadcrumb = [];
    $carouselImages =[];
    
    if($categorySlug && $manufacturerSlug){
      
      $manufacturer = $this->manufacturer->findBySlug($manufacturerSlug);
      
      $category = $this->category->findBySlug($categorySlug);

     
      if(isset($category->id) && isset($manufacturer->id)){
      
        $categoryBreadcrumb = CategoryTransformer::collection(Category::ancestorsAndSelf($category->id));
        
        $ctpl = "icommerce.manufacturer.{$manufacturer->id}.index";
        if (view()->exists($ctpl)) $tpl = $ctpl;
  
        $ctpl = "icommerce.manufacturer.{$manufacturer->id}%.index";
        if (view()->exists($ctpl)) $tpl = $ctpl;

        // Carousel Top
        $carouselImages = $this->getImagesToCarousel($manufacturer);
  
  
        //Remove manufacturer filters of this index, its not necessary
        $configFilters = config("asgard.icommerce.config.filters");
        unset($configFilters["manufacturers"]);
  
        $configFilters["categories"]["params"] = ["filter" => ["manufacturers" => $manufacturer->id]];
        $configFilters["categories"]["itemSelected"] = $category;
        config(["asgard.icommerce.config.filters" => $configFilters]);
  
        
      }else{
        return response()->view('errors.404', [], 404);
      }
      
    }

    //$dataRequest = $request->all();

    return view($tpl, compact('category','manufacturer','categoryBreadcrumb','carouselImages'));
  }
  
  /**
   * Show product
   * @param Request $request
   * @return mixed
   */
  public function show(Request $request)
  {
    $argv = explode("/",$request->path());
    $slug = end($argv);
    
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
      $categoryBreadcrumb = CategoryTransformer::collection(Category::ancestorsAndSelf($category->id));
      
      return view($tpl, compact('product','category','categoryBreadcrumb'));
      
    }else{
      return response()->view('errors.404', [], 404);
    }
    
  }
  
  public function checkout()
  {
    $layout = setting("icommerce::checkoutLayout", null, "one-page-checkout");
    
    $tpl = "icommerce::frontend.checkout.index";
  
    $cart = request()->session()->get('cart');
    if(isset($cart->id)) {
      $cart = app('Modules\Icommerce\Repositories\CartRepository')->getItem($cart->id);
    }
    $currency = Currency::where("default_currency",1)->first();
    
    if(setting("icommerce::customCheckoutTitle")){
      $title = setting("icommerce::customCheckoutTitle");
    }else{
      $title =  trans('icommerce::checkout.title');
    }
    return view($tpl,["cart" => new CartTransformer($cart),"currency" => $currency, "title" => $title]);
  }

  
  private function _paramsRequest(&$params)
  {
    //$params->take = $params->take ?? setting("")
    //Return params
    $params = (object)[
      "page" => is_numeric($request->input('page')) ? $request->input('page') : 1,
      "take" => is_numeric($request->input('take')) ? $request->input('take') :
        ($request->input('page') ? 12 : null),
      "include" =>[],
      "filter" => json_decode(json_encode(['categories'=>$category,'manufacturers'=>$manufacturer,'priceRange'=>['from'=>$minPrice,'to'=>$maxPrice],'search'=>$search,'order'=>$order,'status'=>1])),
    ];

    return $params;//Response
  }


  /**
  * Get Images to carousel top index
  *
  */
  protected function getImagesToCarousel($entity){

    $carouselImages = [];

    $mediaFiles = $entity->mediaFiles();

    if(isset($mediaFiles->carouseltopindeximages) && count($mediaFiles->carouseltopindeximages)>0){
        $carouselImages = $mediaFiles->carouseltopindeximages;
    } 

    return $carouselImages;
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
