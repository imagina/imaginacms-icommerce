<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;

class Wishlist extends Component
{

 
  public function mount(Request $request)
  {
    
   
  }
  
 
  
  public function render()
  {


    $tpl = 'icommerce::frontend.livewire.wishlist';
    $ttpl = 'icommerce.livewire.wishlist';

    if (view()->exists($ttpl)) $tpl = $ttpl;

  }
  
}
