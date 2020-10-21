<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class Test extends Component
{

 	public $message = 'Hello World!';
 	
    public function render()
    {
        return view('icommerce::livewire.test');
    }

}