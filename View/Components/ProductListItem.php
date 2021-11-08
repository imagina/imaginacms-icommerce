<?php

namespace Modules\Icommerce\View\Components;

use Illuminate\View\Component;

class ProductListItem extends Component
{
  
  
  public $product;
  public $itemListLayout;
  public $productAspect;
  public $view;
  public $addToCartWithQuantity;
  public $editLink;
  public $tooltipEditLink;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($item, $itemListLayout = null, $layout = null, $addToCartWithQuantity = null,
                              $parentAttributes = null, $productAspect = null, $editLink , $tooltipEditLink)
  {
    $this->product = $item;
  
    $this->itemListLayout = $itemListLayout;
    $this->addToCartWithQuantity = $addToCartWithQuantity ?? setting('icommerce::product-add-to-cart-with-quantity',null,false);
    $productListItemLayout = $layout ?? setting('icommerce::productListItemLayout', null, 'product-list-item-layout-1');
    $this->productAspect = $productAspect ?? setting('icommerce::productAspect', null, '1-1');
    $this->view = "icommerce::frontend.components.product.product-list-item.layouts." . $productListItemLayout.".index";
    $this->editLink = $editLink;
    $this->tooltipEditLink = $tooltipEditLink;
  
    if(!empty($parentAttributes))
      $this->getParentAttributes($parentAttributes);
  }
  
  private function getParentAttributes($parentAttributes){
    
    isset($parentAttributes["itemListLayout"]) ? $this->itemListLayout = $parentAttributes["itemListLayout"] : false;
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