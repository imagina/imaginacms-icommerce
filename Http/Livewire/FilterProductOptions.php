<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class FilterProductOptions extends Component
{

	protected $productOptions;
    
	protected $listeners = ['productListRendered'];

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
        \Log::info("Filter Product Options: ".json_encode($params));

       
		$this->productOptions = $this->getProductRepository()->getProductOptions(json_decode(json_encode($params)));

	}

	/*
    * Render 
    *
    */
    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.filter-product-options';
    	$ttpl = 'icommerce.livewire.filter-product-options';

    	if (view()->exists($ttpl)) $tpl = $ttpl;

    	return view($tpl,['productOptions' => $this->productOptions]);
        
    }

}