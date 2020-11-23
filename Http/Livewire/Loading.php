<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class Loading extends Component
{

	public $loading;

	protected $listeners = ['changeStatusLoading'];

	
	public function mount()
	{
		$this->loading = true;
	}
	
	public function changeStatusLoading($status)
    {
        $this->loading = $status;
        //\Log::info("Loading Listener Status:".(int)$status);
    }

    public function render()
    {

    	$tpl = 'icommerce::frontend.livewire.loading';

        return view($tpl);
    }

}