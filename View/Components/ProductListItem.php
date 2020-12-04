<?php

namespace Modules\Icommerce\View\Components;

use Illuminate\View\Component;

class ProductListItem extends Component
{
  
  
  public $product;
  public $productListLayout;
  public $view;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($product, $productListLayout = null, $layout = null)
  {
    $this->product = $product;
    $this->productListLayout = $productListLayout;
    $productListItemLayout = $layout ?? setting('icommerce::productListItemLayout', null, 'product-list-item-layout-1');
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