<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class FilterManufacturers extends Component
{

    protected $manufacturers;
    public $selectedManufacturers;

	protected $listeners = ['productListRendered'];


    /*
    * When Manufacturer has been selected
    * 
    */
    public function updatedSelectedManufacturers(){

        $newManu = [];
        foreach($this->selectedManufacturers as $key => $m){
            if($m)
                array_push($newManu, $key);
        }
        
        $this->emit('updateFilter',[
          'manufacturers' => $newManu
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

		
        $oldManufacturers  = $params["filter"]["manufacturers"] ?? null;
        if(!empty($oldManufacturers)){
            foreach($oldManufacturers as $oldM){
                $this->selectedManufacturers[$oldM] = true;
            }
        }
        
        // Remove from the filter so that it brings all the manufacturers and does not limit to one manufacturers
        if(isset($params["filter"]["manufacturers"]))
            unset($params["filter"]["manufacturers"]);

        $this->manufacturers = $this->getProductRepository()->getManufacturers(json_decode(json_encode($params)));
        
	}

    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.filter-manufacturers';
    	$ttpl = 'icommerce.livewire.filter-manufacturers';

    	if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl,['manufacturers' => $this->manufacturers]);
    }

}