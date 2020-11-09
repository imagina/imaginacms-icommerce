<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class FilterManufacturers extends Component
{


	protected $listeners = ['productListRendered'];


	private function getProductRepository(){
    	return app('Modules\Icommerce\Repositories\ProductRepository');
  	}

	/*
    * Listener - Product List Rendered 
    *
    */
	public function productListRendered($params){

		// Testing
		\Log::info("Filter Manufacturers: ".json_encode($params));
		$newParams = json_decode(json_encode($params));

		$products = $this->getProductRepository()->getItemsBy($newParams);

		\Log::info("Products: ".json_encode($products));

	}

    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.filter-manufacturers';
    	$ttpl = 'icommerce.livewire.filter-manufacturers';

    	if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl);
    }

}