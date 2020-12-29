<?php

namespace Modules\Icommerce\Http\Livewire\Index\Filters;

use Livewire\Component;

class ProductTypes extends Component
{
	

    public $productTypes;
    public $selectedType;
    public $isExpanded;
    public $show;

    protected $listeners = ['productListRendered'];

    public function mount(){

       $this->productTypes = config("asgard.icommerce.config.filters.product-types.options");
       $this->show = false;
       $this->isExpanded = false;


    }

    /*
    * When SelectedType has been selected
    * option = "searchable" (consultable) price == 0
    * option = "affordable" (comprable) price > 0
    */
    public function updatedSelectedType(){

        //\Log::info("Selected Type: ".json_encode($this->selectedType));

        $this->emit('updateFilter',[
          'productType' => $this->selectedType
        ]);
    
        $this->isExpanded = true;
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


        $resultShowFilter = $this->getProductRepository()->getProductTypes(json_decode(json_encode($params)));

        // Validation from URL
        if(isset($params["filter"]["productType"])){
            $this->selectedType = $params["filter"]["productType"];
            $this->show = true;
        }

        if($this->isExpanded || $resultShowFilter)
            $this->show = true;
        
    }
    
    /*
    * Render
    *
    */
    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.index.filters.product-types';
        return view($tpl);

    }


}