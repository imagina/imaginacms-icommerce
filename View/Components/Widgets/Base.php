<?php

namespace Modules\Icommerce\View\Components\Widgets;

use Illuminate\View\Component;

class Base extends Component
{
  
  public $id;
  public $isExpanded;
  public $view;
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($id,$isExpanded = false)
  {
  
    $this->id = $id;
    $this->isExpanded = $isExpanded;
    $this->view = "icommerce::frontend.components.widgets.base";
  
  }

  public function render()
  {
  
    return view($this->view);

  }

}