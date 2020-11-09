<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class FilterOrderBy extends Component
{

    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.filter-orderby';
    	$ttpl = 'icommerce.livewire.filter-orderby';

    	if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl);
    }

}