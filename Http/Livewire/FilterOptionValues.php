<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class FilterOptionValues extends Component
{

	
    public $selectedOptionValues = [];
    public $option;

    public function mount($option){

        $this->option = $option;

    }
    /*
    * When Option Value has been selected
    * 
    */
    public function updatedSelectedOptionValues(){

         // Testing
        \Log::info("updated - Selected Option Values : ".json_encode($this->selectedOptionValues));

       
        $newOV = [];
        foreach($this->selectedOptionValues as $key => $m){
            if($m)
                array_push($newOV, $m);
        }
        \Log::info("format to filter: ".json_encode($newOV));

        $this->selectedOptionValues = array_filter($this->selectedOptionValues);
        //$newOptionValues = $this->selectedOptionValues;
        $newOptionValues = $newOV;

        $this->emit('updateFilter',[
            'optionValues' => $newOptionValues
        ]);

        /*
        $old = $this->selectedOptionValues;
        $this->selectedOptionValues = null;
        foreach($old as $key => $value){
            $this->selectedOptionValues[$value] = "{$value}";
        }
        */
       



    }

	/*
    * Render 
    *
    */
    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.filter-option-values';
    	$ttpl = 'icommerce.livewire.filter-option-values';

    	if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl);
        
    }

}