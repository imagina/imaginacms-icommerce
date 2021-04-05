<?php

namespace Modules\Icommerce\View\Components;

use Illuminate\View\Component;

class ProductListItem extends Component
{
  
  
  public $product;
  public $productListLayout;
  public $productAspect;
  public $view;
  public $addToCartWithQuantity;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($item, $itemListLayout = null, $layout = null, $addToCartWithQuantity = null,
                              $parentAttributes = null, $productAspect = null)
  {
    $this->product = $item;
    $this->productListLayout = $itemListLayout;
    $this->addToCartWithQuantity = $addToCartWithQuantity ?? setting('icommerce::product-add-to-cart-with-quantity',null,false);
    $productListItemLayout = $layout ?? setting('icommerce::productListItemLayout', null, 'product-list-item-layout-1');
    $this->productAspect = $productAspect ?? setting('icommerce::productAspect', null, '1-1');
    $this->view = "icommerce::frontend.components.product.product-list-item.layouts." . $productListItemLayout.".index";
  
    if(!empty($parentAttributes))
      $this->getParentAttributes($parentAttributes);
  }
  
  private function getParentAttributes($parentAttributes){
    
    isset($parentAttributes["productListLayout"]) ? $this->productListLayout = $parentAttributes["productListLayout"] : false;
    isset($parentAttributes["addToCartWithQuantity"]) ? $this->addToCartWithQuantity = $parentAttributes["addToCartWithQuantity"] : false;
    
  }
  
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Codntracts\View\View|string
   */
  public function render()
  {
    return view($this->view);
  }
}