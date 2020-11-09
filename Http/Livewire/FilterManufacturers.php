<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class FilterManufacturers extends Component
{

    public $manufacturers;
    public $selectedManufacturers;

	protected $listeners = ['productListRendered'];


    public function updatedSelectedManufacturers(){

        //\Log::info("Filter Manufacturers: ".json_encode($this->selectedManufacturers));
         
        $newManu = [];
        foreach($this->selectedManufacturers as $key => $m){
            if($m)
                array_push($newManu, $key);
        }
        //\Log::info("Filter Manufacturers: ".json_encode($newManu));
        $this->emit('updateFilter',[
          'manufacturers' => $newManu
        ]);

    }

	private function getProductRepository(){
    	return app('Modules\Icommerce\Repositories\ProductRepository');
  	}

	/*
    * Listener - Product List Rendered 
    *
    */
	public function productListRendered($params){

		// Testing
		//\Log::info("Filter Manufacturers: ".json_encode($params));
		//$newParams = json_decode(json_encode($params));

		//$manufacturers = $this->getProductRepository()->getManufacturers($newParams);

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