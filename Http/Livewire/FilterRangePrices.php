<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

use Modules\Icommerce\Repositories\ProductRepository;

class FilterRangePrices extends Component
{

	public $priceMin;
	public $priceMax;
  	public $step;
	public $selPriceMin;
	public $selPriceMax;

	public $show;
	
	protected $listeners = ['productListRendered','updateRange'];

	/*
    * Runs once, immediately after the component is instantiated, 
    * but before render() is called
    */
	public function mount()
	{
    	$this->step = setting('icommerce::filterRangePricesStep',null,20000);
		$this->priceMin = 0;
		$this->priceMax = 1;
		$this->selPriceMin = 0;
		$this->selPriceMax = 1;
		$this->show = true;

	}
  
  /**
   * update range
   * Emit updateFilter
   *
   */
  	public function updateRange($data){

	    $this->selPriceMin = $data["selPriceMin"];
	    $this->selPriceMax = $data["selPriceMax"];
	  	//\Log::info("Sel Price Min: ".$this->selPriceMin);
	  	//\Log::info("Sel Price Max: ".$this->selPriceMax);

	    $this->emit('updateFilter',[
	      'priceRange' => [
	        'from' => $this->selPriceMin,
	        'to' => $this->selPriceMax
	      ]
	    ]);

  	}
  
  	/*
    * Get Product Repository
    *
    */
  	private function getProductRepository(){
    	return app('Modules\Icommerce\Repositories\ProductRepository');
  	}

	/*
    * Listener - Product List Rendered 
    *
    */
	public function productListRendered($params){

		// Testing
		//\Log::info("Filter Range Params: ".json_encode($params));
	
		$selectedPrices  = $params["filter"]["priceRange"] ?? null;
		
		//\Log::info("Selected Prices Range: ".json_encode($selectedPrices)." Params: ".json_encode($params));

		$range = $this->getProductRepository()->getPriceRange(json_decode(json_encode($params)));
		
		// Testing
		//\Log::info("Selected Prices Range: ".json_encode($selectedPrices)." Params: ".json_encode($params));
		
    	$this->priceMin = round($range->minPrice);
    	$this->priceMax = round($range->maxPrice);
		
		if(!empty($selectedPrices)){
			$this->selPriceMin = $selectedPrices["from"];
			$this->selPriceMax = $selectedPrices["to"]; 
		}else{
			$this->selPriceMin = $this->priceMin;
			$this->selPriceMax = $this->priceMax;
		}
		
		//\Log::info($this->priceMin."-".$this->selPriceMin."-".$this->priceMax."-".$this->selPriceMax);

		//Validating if there is no price range
		if($this->selPriceMin==$this->selPriceMax && $this->priceMin==$this->selPriceMin && $this->priceMax==$this->selPriceMax){
			$this->show = false;
		}

		$originalPriceMax = $this->priceMax;

		// Sum Step Because the widget performs a calculation for the range
		$this->priceMax+=intval($this->step);

		// Validating the selected price if the "step" has increased the maximum value
		if($this->selPriceMax==$originalPriceMax && $this->selPriceMax!=$this->priceMax){
			$this->selPriceMax = $this->priceMax;
		}


		$this->dispatchBrowserEvent('filter-prices-updated', [
			'newPriceMin' => $this->priceMin,
			'newPriceMax' => $this->priceMax,
			'newSelPriceMin' => $this->selPriceMin,
			'newSelPriceMax' => $this->selPriceMax,
			'step' => $this->step
		]);
		
	}

	/*
    * Render 
    *
    */
    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.filter-range-prices';
    	$ttpl = 'icommerce.livewire.filter-range-prices';

    	if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl);
    }

}