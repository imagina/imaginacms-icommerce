<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{

	public $count = 0;

	public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('icommerce::livewire.counter');
    }
}