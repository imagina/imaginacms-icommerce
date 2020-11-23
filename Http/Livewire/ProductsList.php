<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App;
use Modules\Icommerce\Repositories\ProductRepository;

// Transformers
use Modules\Icommerce\Transformers\ProductTransformer;

use Illuminate\Http\Request;

class ProductsList extends Component
{

	use WithPagination;

    protected $paginationTheme = 'bootstrap';

	private $order;
	private $firstRequest;

	public $category;
    public $manufacturer;

	public $totalProducts;
	public $orderBy;
	public $search;
	public $mainLayout;
	public $layoutClass;

	public $priceMin;
	public $priceMax;
	public $filters;

	public $dataRequest;

    public $configs;

	protected $listeners = ['updateFilter'];

	protected $queryString = ['search','orderBy','priceMin','priceMax','page'];

	protected $emitProductListRendered;
	

	/*
    * Runs once, immediately after the component is instantiated,
    * but before render() is called
    */
	public function mount(Request $request,$category,$manufacturer)
	{

	    $this->category = $category;
        $this->manufacturer = $manufacturer;
        
	    $this->totalProducts = 0;
	    $this->filters = [];
        
        $this->initConfigs();

        $this->orderBy = $this->configs['orderBy']['default'] ?? "nameaz";
        $this->order = $this->configs['orderBy']['options'][$this->orderBy]['order'];

        $this->mainLayout = $this->configs['mainLayout']['default'] ?? "four";
        $this->layoutClass = $this->configs['mainLayout']['options'][$this->mainLayout]['class'];

	    $this->priceMin = null;
	    $this->priceMax = null;

	    $this->dataRequest = $request->all();
	    $this->firstRequest = true;

	    $this->emitProductListRendered = false	;

	}

    /*
    * Init Configs to ProductList
    *
    */
    public function initConfigs(){

        $this->configs['orderBy'] = config("asgard.icommerce.config.orderBy");
        $this->configs['mainLayout'] = config("asgard.icommerce.config.layoutIndex");

    }
	/*
    * Updating Attribute OrderBy
    *
    */
	public function updatingOrderBy(){
		$this->emitProductListRendered = false;
        $this->resetPage();
    }
    
  
    /*
    * Listener - Update Filters
    *
    */
    public function updateFilter($filter){
    
        $this->emitProductListRendered = true;
        $this->filters = array_merge($this->filters, $filter);
        $this->resetPage();
    
    }

    /*
    * Function Frontend - When change the layout
    *
    */
    public function changeLayout($c){
    	$this->mainLayout = $c;
        $this->layoutClass = $this->configs['mainLayout']['options'][$this->mainLayout]['class'];
    }

    /*
    * Update Parameters Url to keep the Filters
    *
    */
    public function updateParametersUrl(){

     
        $paramsUrl = http_build_query([
    	    "page" => $this->page ?? 1,
            "filters" => $this->filters,
            "orderBy" => $this->orderBy
        ]);
 
        $this->emit('urlChange', $paramsUrl);
        
    }

    /*
    * Check Values From Request
    * just First Request
    */
    public function checkValuesFromRequest(){
        
        if(!empty($this->dataRequest)){
            foreach ($this->dataRequest as $key => $value) {
                $this->{$key} = $value;
            }
   
        }

        $this->firstRequest = false;
    }

    /*
    * Make params to Repository
    * before execcute the query
    */
    public function makeParamsToRepository(){

     
    	if($this->firstRequest)
    		$this->checkValuesFromRequest();
        
        $this->order = $this->configs['orderBy']['options'][$this->orderBy]['order'];

        if(is_string($this->search) && $this->search){
          $this->filters["search"] = $this->search;
          $this->filters["locale"] = App::getLocale();
        }

    	$params = [
    		"include" => ['discounts','translations','category','categories','manufacturer','productOptions'],
    		"take" => setting('icommmerce::product-per-page',null,12),
    		"page" => $this->page ?? 1,
    		"filter" => $this->filters,
            "order" =>  $this->order
        ];
    	
    	if(isset($this->category->id))
    		$params["filter"]["category"] = $this->category->id;

        if(isset($this->manufacturer->id))
            $params["filter"]["manufacturers"] = [$this->manufacturer->id];
    	
	    return $params;
    	
    }

    /*
    * Get Product Repository
    *
    */
	private function getProductRepository(){
		return app('Modules\Icommerce\Repositories\ProductRepository');
    }
    
    /*
    * Render
    *
    */
    public function render(){
     	
     	
     	$params = $this->makeParamsToRepository();

        //	\Log::info("params: ".json_encode($params));
    	$products = $this->getProductRepository()->getItemsBy(json_decode(json_encode($params)));
    
    	$this->totalProducts = $products->total();

    	$tpl = 'icommerce::frontend.livewire.products-list';

    	//Updates Parameters URL
    	$this->updateParametersUrl();

  		// Emit Finish Render
		\Log::info("Emit list rendered: ".json_encode($this->emitProductListRendered));
		$this->emitProductListRendered ? $this->emit('productListRendered', $params) : false;

        return view($tpl,['products'=> $products, 'params' => $params]);
    }

}