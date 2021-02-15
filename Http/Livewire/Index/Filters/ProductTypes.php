<?php

namespace Modules\Icommerce\Http\Livewire\Index\Filters;

use Livewire\Component;

class ProductTypes extends Component
{
	

    public $productTypes;
    public $selectedType;
    public $isExpanded;
    public $show;

    protected $listeners = ['itemListRendered'];

    public function mount(){

       $this->productTypes = config("asgard.icommerce.config.filters.product-types.options");
       $this->isExpanded = config("asgard.icommerce.config.filters.product-types.isExpanded") ?? false;
       $this->show = false;
       
    }

    /*
    * When SelectedType has been selected
    * option = "searchable" (consultable) value = 1
    * option = "affordable" (comprable) value = 0
    */
    public function updatedSelectedType(){

        //\Log::info("Selected Type: ".json_encode($this->selectedType));

         $this->emit('getData',[
            'filters' => [
                'isCall' => (boolean)$this->selectedType
            ]
        ]);
        /*
        $this->emit('updateFilter',[
          'isCall' => (boolean)$this->selectedType
        ]);
        */
       
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
    public function itemListRendered($params){


        $resultShowFilter = $this->getProductRepository()->getProductTypes(json_decode(json_encode($params)));

        // Validation from URL
        if(isset($params["filter"]["isCall"])){
            $this->selectedType = $params["filter"]["isCall"];
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