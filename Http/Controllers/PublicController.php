<?php

namespace Modules\Icommerce\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Entities\Currency;
use Modules\Icommerce\Entities\Order;
use Modules\Icommerce\Http\Livewire\Cart;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Icommerce\Repositories\OrderRepository;
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
use Modules\Isite\Entities\Organization;
use Route;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Page\Repositories\PageRepository;

//Services
use Modules\Icommerce\Services\ProductService;
use Modules\Page\Services\PageService;

class PublicController extends BaseApiController
{
  protected $auth;
  private $product;
  private $order;
  private $category;
  private $manufacturer;
  private $currency;
  private $payments;
  private $shippings;
  private $productService;
  private $pageService;
  private $pageRepository;
  
  public function __construct(
    ProductRepository $product,
    CategoryRepository $category,
    OrderRepository $order,
    ManufacturerRepository $manufacturer,
    CurrencyRepository $currency,
    PaymentMethodRepository $payments,
    ShippingMethodRepository $shippings,
    ProductService $productService,
    PageService $pageService,
    PageRepository $pageRepository
  )
  {
    parent::__construct();
    $this->product = $product;
    $this->order = $order;
    $this->category = $category;
    $this->manufacturer = $manufacturer;
    $this->currency = $currency;
    $this->payments = $payments;
    $this->shippings = $shippings;
    $this->productService = $productService;
    $this->pageService = $pageService;
    $this->pageRepository = $pageRepository;
  }
  
  // view products by category
  public function index(Request $request)
  {
    $argv = explode("/", $request->path());
    $slug = end($argv);
    
    $tpl = 'icommerce::frontend.index';
    
    $category = null;
    
    $categoryBreadcrumb = [];
    $carouselImages = [];
    
    $gallery = [];
    
    $configFilters = config("asgard.icommerce.config.filters");
    
    
    $organization = null;
    if (isset(tenant()->id)) {
      $organization = tenant();
      $configFilters["categories"]["params"] = ["filter" => ["organizations" => $organization->id]];
      config(["asgard.icommerce.config.filters" => $configFilters]);
    }
    
    if ($slug && $slug != trans('icommerce::routes.store.index.index')) {
      
      $category = $this->category->findBySlug($slug);
      
      if (isset($category->id)) {
        $categoryBreadcrumb = $this->getCategoryBreadcrumb($category);
        
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
        
      } else {
        return response()->view('errors.404', [], 404);
      }
      
      
    } else {
      //Default breadcrumb
      $configFilters["categories"]["breadcrumb"] = [];
    }
  
    $title = (isset($category->id) ? ($category->h1_title ?? $category->title) : '');
  
    config(["asgard.icommerce.config.filters" => $configFilters]);


    //Get the information of the layout by the 'system name' of the page and path to find
    $dataLayout = $this->pageService->getDataLayout('store','.icommerce.index');
    if(!is_null($dataLayout['tpl']))
      $tpl = $dataLayout['tpl'];
    $layoutSystemName = $dataLayout['layoutSystemName'];

    //Send page to detect in master layout
    $page = $this->pageRepository->where('system_name',"store")->first();
   
    return view($tpl, compact('category', 'categoryBreadcrumb', 'carouselImages', 'gallery', 'organization', 'title','layoutSystemName','page'));
  }
  
  // view products by manufacturer
  public function indexManufacturer(Request $request)
  {
    $argv = explode("/", $request->path());
    $slug = end($argv);
    
    $tpl = 'icommerce::frontend.index';
    $ttpl = 'icommerce.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    $manufacturer = null;
    
    $categoryBreadcrumb = [];
    $carouselImages = [];
    
    if ($slug && $slug != trans('icommerce::routes.store.index')) {
      
      $manufacturer = $this->manufacturer->findBySlug($slug);
      
      if (isset($manufacturer->id)) {
        
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
        
        
      } else {
        return response()->view('errors.404', [], 404);
      }
      
    }
    
    $title = (isset($manufacturer->id) ? $manufacturer->name : '');
    //$dataRequest = $request->all();
    
    return view($tpl, compact('manufacturer', 'categoryBreadcrumb', 'carouselImages', 'title'));
  }  // view products by manufacturer
  
  public function indexOffers(Request $request)
  {
    $argv = explode("/", $request->path());
    $slug = end($argv);
    
    $tpl = 'icommerce::frontend.offers.index';
    $ttpl = 'icommerce.offers.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    $withDiscount = false;
    
    if ($slug && $slug != trans('icommerce::routes.store.index')) {
      
      $withDiscount = true;
      
    }
    $title = trans('icommerce::common.offers.title');
    return view($tpl, compact('withDiscount','title'));
  }
  
  // view products by category
  public function indexCategoryManufacturer(Request $request, $categorySlug, $manufacturerSlug)
  {
    $argv = explode("/", $request->path());
    
    $tpl = 'icommerce::frontend.index';
    $ttpl = 'icommerce.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    $manufacturer = null;
    $category = null;
    
    $categoryBreadcrumb = [];
    $carouselImages = [];
    
    if ($categorySlug && $manufacturerSlug) {
      
      $manufacturer = $this->manufacturer->findBySlug($manufacturerSlug);
      
      $category = $this->category->findBySlug($categorySlug);
      
      
      if (isset($category->id) && isset($manufacturer->id)) {
        
        $categoryBreadcrumb = $this->getCategoryBreadcrumb($category);
        
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
        
        
      } else {
        return response()->view('errors.404', [], 404);
      }
      
    }
    
    $title = (isset($category->id) ? ($category->h1_title ?? $category->title) : '').(isset($manufacturer->id) ? (isset($category->id) ? ' / ' : '').$manufacturer->name : '');
  
  
    //$dataRequest = $request->all();
    
    return view($tpl, compact('category', 'manufacturer', 'categoryBreadcrumb', 'carouselImages', 'title'));
  }
  
  /**
   * Show product
   * @param Request $request
   * @return mixed
   */
  public function show(Request $request)
  {
    $argv = explode("/", $request->path());
    $slug = end($argv);
    
    $tpl = 'icommerce::frontend.show';
    $ttpl = 'icommerce.show';
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    $params = json_decode(json_encode(
      [
        "include" => explode(",", "translations,category,categories,tags,addedBy"),
        "filter" => [
          "field" => "slug"
        ]
      ]
    ));

    $product = $this->product->getItem($slug, $params);

    //dd($product,$slug,$params);
    
    $organization = null;
    if (isset(tenant()->id)) {
      $organization = tenant();
      $configFilters["categories"]["params"] = ["filter" => ["organizations" => $organization->id]];
      config(["asgard.icommerce.config.filters" => $configFilters]);
    }
    
    if ($product) {

      $currency = Currency::where("default_currency", 1)->first();
      $schemaScript = $this->productService->createSchemaScript($product,$currency);

      $category = $product->category;
      $categoryBreadcrumb = $this->getCategoryBreadcrumb($category);

      //Get the information of the layout by the 'system name' of the page and path to find
      $dataLayout = $this->pageService->getDataLayout('store-show','.icommerce.show');

      if(!is_null($dataLayout['tpl']))
        $tpl = $dataLayout['tpl'];
      $layoutSystemName = $dataLayout['layoutSystemName'];
      
       //Send page to detect in master layout
      $page = $this->pageRepository->where('system_name',"store-show")->first();

      return view($tpl, compact('product', 'category', 'categoryBreadcrumb', 'organization','schemaScript','layoutSystemName','page'));
      
    } else {
      return response()->view('errors.404', [], 404);
    }
    
  }
  
  public function checkout()
  {
    $layout = setting("icommerce::checkoutLayout", null, "one-page-checkout");
    
    $tpl = "icommerce::frontend.checkout.index";

    $cart = request()->session()->get('cart');
    if (isset($cart->id)) {
      $cart = app('Modules\Icommerce\Repositories\CartRepository')->getItem($cart->id);
    }else{
      $cart = app('Modules\Icommerce\Services\CartService')->create(["userId" => \Auth::id() ?? null]);
    }
  
    $organization = null;
    if (isset(tenant()->id)) {
      $organization = tenant();
    }
    
    $currency = Currency::where("default_currency", 1)->first();
    
    if (setting("icommerce::customCheckoutTitle")) {
      $title = setting("icommerce::customCheckoutTitle");
    } else {
      $title = trans('icommerce::checkout.title');
    }
    return view($tpl, ["cart" => new CartTransformer($cart), "currency" => $currency, "title" => $title, "organization" => $organization]);
  }
  
  public function checkoutUpdate($orderId)
  {
    $layout = setting("icommerce::checkoutLayout", null, "one-page-checkout");
    
    $tpl = "icommerce::frontend.checkout.index";
    
    $cart = request()->session()->get('cart');
    if (isset($cart->id)) {
      $cart = app('Modules\Icommerce\Repositories\CartRepository')->getItem($cart->id);
    }
    $currency = Currency::where("default_currency", 1)->first();
    
    $order = $this->order->getItem($orderId);
    
    if (setting("icommerce::customCheckoutTitle")) {
      $title = setting("icommerce::customCheckoutTitle");
    } else {
      $title = trans('icommerce::checkout.title');
    }
    return view($tpl, ["cart" => new CartTransformer($cart), "currency" => $currency, "title" => $title, "order" => $order]);
  }
  
  
  private function _paramsRequest(&$params)
  {
    //$params->take = $params->take ?? setting("")
    //Return params
    $params = (object)[
      "page" => is_numeric($request->input('page')) ? $request->input('page') : 1,
      "take" => is_numeric($request->input('take')) ? $request->input('take') :
        ($request->input('page') ? 12 : null),
      "include" => [],
      "filter" => json_decode(json_encode(['categories' => $category, 'manufacturers' => $manufacturer, 'priceRange' => ['from' => $minPrice, 'to' => $maxPrice], 'search' => $search, 'order' => $order, 'status' => 1])),
    ];
    
    return $params;//Response
  }
  
  
  /**
   * Get Images to carousel top index
   *
   */
  private function getImagesToCarousel($entity)
  {
    
    $carouselImages = [];
    
    $mediaFiles = $entity->mediaFiles();
    
    if (isset($mediaFiles->carouseltopindeximages) && count($mediaFiles->carouseltopindeximages) > 0) {
      $carouselImages = $mediaFiles->carouseltopindeximages;
    }
    
    return $carouselImages;
  }
  
  
  /**
   * Get Images to gallery top Category
   *
   */
  private function getGalleryCategory($category)
  {
    
    $gallery = [];
    
    $typeGallery = setting('icommerce::carouselIndexCategory', null, 'carousel-category-active');
    if (isset($category->id)) {
      
      if ($category->parent_id != null && $typeGallery == "carousel-category-parent") {
        $category = Category::whereAncestorOf($category)->whereNull("parent_id")->first();
      }
      
      $mediaFiles = $category->mediaFiles();
      if (isset($mediaFiles->carouselindeximage)) {
        $gallery = $mediaFiles->carouselindeximage;
      }
      
    }
    
    return $gallery;
    
  }
  
  private function getCategoryBreadcrumb($category)
  {
    if (config("asgard.icommerce.config.tenantWithCentralData.categories")) {
      $query = Category::whereAncestorOf($category->id,true);
    //  dd($query->toSql(),$query->getBindings());
      
      return CategoryTransformer::collection($query->get());
    } else {
      return CategoryTransformer::collection(Category::defaultOrder()->ancestorsAndSelf($category->id));
    }
    
  }
  
  public function quoteLayout()
  {
    
    $cart = \Modules\Icommerce\Entities\Cart::find(60);
    $customerData = [
    
    ];
    return view("icommerce::frontend.livewire.cart.pdf.pdf", ["cart" => $cart]);
  }
  
  
  public function quoteEmail()
  {
    
    $order = \Modules\Icommerce\Entities\Order::find(6);
    
    return view("icommerce::emails.order", ["data" => ["order" => $order]]);
  }
}
