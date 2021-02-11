<?php

namespace Modules\Icommerce\Http\Livewire\Index\Filters;

use Livewire\Component;

class Manufacturers extends Component
{
	
    protected $manufacturers;
    public $selectedManufacturers;
    public $isExpanded;

	protected $listeners = ['itemListRendered'];
	
	public function mount(){
		$this->selectedManufacturers = [];
        $this->isExpanded = config("asgard.icommerce.config.filters.manufacturers.isExpanded") ?? false;
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
	public function itemListRendered($params){
		$this->selectedManufacturers  = $params["filter"]["manufacturers"] ?? [];
		
        $this->manufacturers = $this->getProductRepository()->getManufacturers(json_decode(json_encode($params)));
        
	}

    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.index.filters.manufacturers';
    	$ttpl = 'icommerce.livewire.filter-manufacturers';
    	
    	if (view()->exists($ttpl)) $tpl = $ttpl;
	
		
		$count = count(array_intersect($this->manufacturers ? $this->manufacturers->pluck("id")->toArray() : [],$this->selectedManufacturers));
		
        if($count) $this->isExpanded = true;
			
		return view($tpl,['manufacturers' => $this->manufacturers]);
			
    }

}