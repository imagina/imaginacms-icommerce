<?php

namespace Modules\Icommerce\View\Components;

use Illuminate\View\Component;

class ProductListItem extends Component
{
  
  
  public $product;
  public $mainLayout;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($product, $mainLayout = null)
  {
    $this->product = $product;
    $this->mainLayout = $mainLayout;
  }
  
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|string
   */
  public function render()
  {
    
    $productListItemLayout = setting('icommerce::productListItemLayout');
    $view = "icommerce::frontend.components.product-list-item.layouts." . $productListItemLayout.".index";
    
    return view($view);
  }
}