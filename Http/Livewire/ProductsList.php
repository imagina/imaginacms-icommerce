<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class ProductsList extends Component
{

    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.products-list';
    	$ttpl = 'icommerce.livewire.products-list';

    	if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl);
    }

}