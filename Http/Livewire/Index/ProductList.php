<?php

namespace Modules\Icommerce\Http\Livewire\Index;

use App;
use Illuminate\Http\Request;
use Livewire\Component;

// Transformers

use Livewire\WithPagination;

class ProductList extends Component
{
  use WithPagination;

  protected $paginationTheme = 'bootstrap';
  private $order;
  private $firstRequest;
  public $category;
  public $manufacturer;
  public $totalProducts;
  public $orderBy;
  public $search = '';
  public $productListLayout;
  public $layoutClass;
  public $priceMin;
  public $priceMax;
  public $filters = [];
  public $dataRequest;
  public $configs;

  protected $listeners = ['updateFilter'];

  protected $queryString = [
    'search' => ['except' => ''],
    'filters' => ['except' => []],
    'page' => ['except' => 1],
  ];

  protected $emitProductListRendered;

  /*
  * Runs once, immediately after the component is instantiated,
  * but before render() is called
  */
  public function mount(Request $request, $category, $manufacturer, $productListLayout = null)
  {
    $this->category = $category;
    $this->manufacturer = $manufacturer;

    $this->totalProducts = 0;

    $this->initConfigs();

    $this->orderBy = $this->configs['orderBy']['default'] ?? 'nameaz';
    $this->order = $this->configs['orderBy']['options'][$this->orderBy]['order'];

    $this->productListLayout = $productListLayout ?? $this->configs['productListLayout']['default'] ?? 'four';
    $this->layoutClass = $this->configs['productListLayout']['options'][$this->productListLayout]['class'];

    $this->priceMin = null;
    $this->priceMax = null;

    $this->dataRequest = $request->all();
    $this->firstRequest = true;

    $this->emitProductListRendered = false;

    $this->fill(request()->only('search', 'filters', 'page', 'orderBy'));
  }

  /*
  * Init Configs to ProductList
  *
  */
  public function initConfigs()
  {
    $this->configs['orderBy'] = config('asgard.icommerce.config.orderBy');
    $this->configs['productListLayout'] = config('asgard.icommerce.config.layoutIndex');
  }

  /*
  * Updating Attribute OrderBy
  *
  */
  public function updatingOrderBy()
  {
    $this->emitProductListRendered = false;
    $this->resetPage();
  }

  /*
  * Listener - Update Filters
  *
  */
  public function updateFilter($filter)
  {
    $this->emitProductListRendered = true;
    $this->filters = array_merge($this->filters, $filter);
    $this->resetPage();
  }

  /*
  * Function Frontend - When change the layout
  *
  */
  public function changeLayout($c)
  {
    $this->productListLayout = $c;
    $this->layoutClass = $this->configs['productListLayout']['options'][$this->productListLayout]['class'];
  }

  /*
  * Make params to Repository
  * before execcute the query
  */
  public function makeParamsToRepository()
  {
    if ($this->firstRequest) {
      $this->firstRequest = false;
    }

    $this->order = $this->configs['orderBy']['options'][$this->orderBy]['order'];

    if (is_string($this->search) && $this->search) {
      $this->filters['search'] = $this->search;
      $this->filters['locale'] = App::getLocale();
    }

    $params = [
      'include' => ['discounts', 'translations', 'category', 'categories', 'manufacturer', 'productOptions'],
      'take' => setting('icommerce::product-per-page', null, 12),
      'page' => $this->page ?? 1,
      'filter' => $this->filters,
      'order' => $this->order,
    ];

    if (isset($this->category->id)) {
      $params['filter']['category'] = $this->category->id;
    }

    if (isset($this->manufacturer->id)) {
      $params['filter']['manufacturers'] = [$this->manufacturer->id];
    }

    if (isset($params['filter']['withDiscount'])) {
      $params['filter']['withDiscount'] = (bool)$params['filter']['withDiscount'];
    }

    return $params;
  }

  /*
  * Get Product Repository
  *
  */
  private function getProductRepository()
  {
    return app('Modules\Icommerce\Repositories\ProductRepository');
  }

  /*
  * Render
  *
  */
  public function render()
  {
    if (!$this->firstRequest && !in_array('orderBy', $this->queryString)) {
      array_push($this->queryString, 'orderBy');
    }

    $params = $this->makeParamsToRepository();
    //\Log::info("params: ".json_encode($params));

    $products = $this->getProductRepository()->getItemsBy(json_decode(json_encode($params)));

    $this->totalProducts = $products->total();

    $tpl = 'icommerce::frontend.livewire.index.product-list';

    // Emit Finish Render
    //\Log::info("Emit list rendered: ".json_encode($this->emitProductListRendered));
    $this->emitProductListRendered ? $this->emit('productListRendered', $params) : false;

    return view($tpl, ['products' => $products, 'params' => $params]);
  }
}
