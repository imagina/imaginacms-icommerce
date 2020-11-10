<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class FilterManufacturers extends Component
{

    public $manufacturers;
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
        if(count($oldManufacturers)>0){
            foreach($oldManufacturers as $oldM){
                $this->selectedManufacturers[$oldM] = true;
            }
        }
        
    
        // Testing with All Manufacturers
        $paramsT = [
            "include" => [],
            "take" => false,
            "filter" => null
        ];

        $this->manufacturers = app('Modules\Icommerce\Repositories\ManufacturerRepository')->getItemsBy(json_decode(json_encode($paramsT)));

		//\Log::info("Manufacturers: ".json_encode($this->manufacturers));

	}

    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.filter-manufacturers';
    	$ttpl = 'icommerce.livewire.filter-manufacturers';

    	if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl);
    }

}