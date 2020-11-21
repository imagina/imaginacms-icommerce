<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class FilterManufacturers extends Component
{
	
    protected $manufacturers;
    public $selectedManufacturers;

	protected $listeners = ['productListRendered'];
	
	public function mount(){
		$this->selectedManufacturers = [];
	}
    /*
    * When Manufacturer has been selected
    * 
    */
    public function updatedSelectedManufacturers(){
	

        $this->emit('updateFilter',[
          'manufacturers' => array_values($this->selectedManufacturers)
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
		$this->selectedManufacturers  = $params["filter"]["manufacturers"] ?? [];
		
        $this->manufacturers = $this->getProductRepository()->getManufacturers(json_decode(json_encode($params)));
        
	}

    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.filter-manufacturers';
    	$ttpl = 'icommerce.livewire.filter-manufacturers';

    	if (view()->exists($ttpl)) $tpl = $ttpl;
	
			$isExpanded = false;
		
			$count = count(array_intersect($this->manufacturers ? $this->manufacturers->pluck("id")->toArray() : [],$this->selectedManufacturers));
			if($count) $isExpanded = true;
			
			return view($tpl,['manufacturers' => $this->manufacturers,"isExpanded" => $isExpanded]);
			
    }

}