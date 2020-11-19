<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class FilterProductOptions extends Component
{

    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.filter-product-options';
    	$ttpl = 'icommerce.livewire.filter-product-options';

    	if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl);
    }

}