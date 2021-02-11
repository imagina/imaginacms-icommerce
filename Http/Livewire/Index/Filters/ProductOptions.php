<?php

namespace Modules\Icommerce\Http\Livewire\Index\Filters;

use Livewire\Component;

class ProductOptions extends Component
{
	
	
	protected $productOptions;
    public $selectedOptionValues;
    
	protected $listeners = ['itemListRendered'];


		public function mount(){
			$this->selectedOptionValues = [];
		}
     /*
    * When Option Value has been selected
    * 
    */
    public function updatedSelectedOptionValues(){


        $this->emit('updateFilter',[
            'optionValues' => array_values($this->selectedOptionValues)
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

		$this->selectedOptionValues = $params["filter"]["optionValues"] ?? [];

		$this->productOptions = $this->getProductRepository()->getProductOptions(json_decode(json_encode($params)));
		
	}

	/*
    * Render 
    *
    */
    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.index.filters.product-options.index';
    	$ttpl = 'icommerce.livewire.filter-product-options';

    	if (view()->exists($ttpl)) $tpl = $ttpl;

    	return view($tpl,['productOptions' => $this->productOptions]);
        
    }

}