<?php

namespace Modules\Icommerce\View\Components;

use Illuminate\View\Component;

class ProductListItem extends Component
{
  
  
  public $product;
  public $mainLayout;
  public $view;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($product, $mainLayout = null)
  {
    $this->product = $product;
    $this->mainLayout = $mainLayout;
    $productListItemLayout = setting('icommerce::productListItemLayout');
    $this->view = "icommerce::frontend.components.product.product-list-item.layouts." . $productListItemLayout.".index";
  
  }
  
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|string
   */
  public function render()
  {
    return view($this->view);
  }
}