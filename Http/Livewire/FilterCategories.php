<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class FilterCategories extends Component
{

    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.filter-categories';
    	$ttpl = 'icommerce.livewire.filter-categories';

    	if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl);
    }

}