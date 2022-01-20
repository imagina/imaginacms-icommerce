<?php

namespace Modules\Icommerce\View\Components;

use Illuminate\View\Component;

class ProductListItem extends Component
{
  
  
  public $product;
  public $itemListLayout;
  public $imageAspect;
  public $view;
  public $showButtonsOnMouseHover;
  public $addToCartWithQuantity;
  public $editLink;
  public $tooltipEditLink;
  public $withIconInAddToCart;
  public $withTextInAddToCart;
  public $discountRibbonStyle;
  public $addToCartWithQuantityStyle;
  public $addToCartIcon;
  public $wishlistIcon;
  public $discountPosition;
  public $externalPadding;
  public $imagePadding;
  public $imageBorder;
  public $imageBorderColor;
  public $imageBorderRadius;
  public $externalBorderRadius;
  public $externalBorder;
  public $externalBorderColor;
  public $buttonsLayout;
  public $buttonsPosition;
  public $externalShadowOnHover;
  public $externalShadowOnHoverColor;
  public $contentAlign;
  public $contentExternalPaddingX;
  public $contentExternalPaddingY;
  public $addToCartWithQuantityPaddingX;
  public $addToCartWithQuantityPaddingY;
  public $addToCartWithQuantityMarginBottom;
  public $contentTitleFontSize;
  public $contentTitleToUppercase;
  public $contentCategoryFontSize;
  public $contentCategoryToUppercase;
  public $contentPriceFontSize;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($item, $itemListLayout = null, $layout = null,
                              $discountRibbonStyle = null,
                              $discountPosition = null,
                              $imagePadding = null,
                              $imageBorder = null,
                              $imageBorderColor = null,
                              $imageBorderRadius = null,
                              $imageAspect = null,
                              $externalPadding = null,
                              $externalBorder = null,
                              $externalBorderRadius = null,
                              $externalBorderColor = null,
                              $externalShadowOnHover = null,
                              $externalShadowOnHoverColor = null,
                              $addToCartIcon = null,
                              $wishlistIcon = null,
                              $addToCartWithQuantityStyle = null,
                              $withTextInAddToCart = null,
                              $withIconInAddToCart = null,
                              $addToCartWithQuantity = false,
                              $showButtonsOnMouseHover = false,
                              $buttonsLayout = null,
                              $buttonsPosition = null,
                              $contentAlign = null,
                              $contentExternalPaddingX = null,
                              $contentExternalPaddingY = null,
                              $addToCartWithQuantityPaddingX = null,
                              $addToCartWithQuantityPaddingY = null,
                              $addToCartWithQuantityMarginBottom = null,
                              $contentTitleFontSize = null,
                              $contentTitleToUppercase = false,
                              $contentCategoryFontSize = 8,
                              $contentCategoryToUppercase = true,
                              $contentPriceFontSize = 8,
                              $parentAttributes = null,
                              $editLink,
                              $tooltipEditLink)
  {
    $this->product = $item;
  
    $this->itemListLayout = $itemListLayout ?? "product-list-item-layout-1";
  
    $this->discountRibbonStyle = $discountRibbonStyle ?? setting('icommerce::productDiscountRibbonStyle', null, "flag");
    $this->discountPosition = $discountPosition ?? setting('icommerce::productDiscountPosition', null, "top-right");
    $this->imagePadding = $imagePadding ?? setting('icommerce::productImagePadding', null, 0);
    $this->imageBorder = $imageBorder ?? setting('icommerce::productImageBorder', null, false);
    $this->imageBorderColor = $imageBorderColor ?? setting('icommerce::productImageBorderColor', null, "#dddddd");
    $this->imageBorderRadius = $imageBorderRadius ?? setting('icommerce::productImageBorderRadius', null, 0);
    $this->imageAspect = $imageAspect ?? setting('icommerce::productAspect', null, '1-1');
    $this->externalPadding = $externalPadding ?? setting('icommerce::productExternalPadding', null, 0);
    $this->externalBorder = $externalBorder ?? setting('icommerce::productExternalBorder', null, false);
    $this->externalBorderRadius = $externalBorderRadius ?? setting('icommerce::productExternalBorderRadius', null, 0);
    $this->externalBorderColor = $externalBorderColor ?? setting('icommerce::productExternalBorderColor', null, "#dddddd");
    $this->externalShadowOnHover = $externalShadowOnHover ?? setting('icommerce::productExternalShadowOnHover', null, true);
    $this->externalShadowOnHoverColor = $externalShadowOnHoverColor ?? setting('icommerce::productExternalShadowOnHoverColor', null, "rgba(0, 0, 0, 0.15)");
    $this->addToCartIcon = $addToCartIcon ?? setting('icommerce::productAddToCartIcon', null, "fa-shopping-cart");
    $this->wishlistIcon = $wishlistIcon ?? setting('icommerce::productWishlistIcon', null, "fa-heart-o");
    $this->addToCartWithQuantityStyle = $addToCartWithQuantityStyle ?? setting('icommerce::productAddToCartWithQuantityStyle', null, "square");
    $this->withTextInAddToCart = $withTextInAddToCart ?? setting('icommerce::productWithTextInAddToCart', null, true);
    $this->withIconInAddToCart = $withIconInAddToCart ?? setting('icommerce::productWithIconInAddToCart', null, true);
    $this->addToCartWithQuantity = $addToCartWithQuantity ?? setting('icommerce::product-add-to-cart-with-quantity',null,false);
    $this->showButtonsOnMouseHover = $showButtonsOnMouseHover ?? setting('icommerce::productShowButtonsOnMouseHover', null, false);
    $this->buttonsLayout = $buttonsLayout ?? setting('icommerce::productButtonsLayout', null, 'borders');
    $this->buttonsPosition = $buttonsPosition ?? setting('icommerce::productButtonsPosition', null, 'in-content');
    $this->contentAlign = $contentAlign ?? setting('icommerce::productContentAlign', null, "left");
    $this->contentExternalPaddingX = $contentExternalPaddingX ?? setting('icommerce::productContentExternalPaddingX', null, 0);
    $this->contentExternalPaddingY = $contentExternalPaddingY ?? setting('icommerce::productContentExternalPaddingY', null, 0);
    $this->addToCartWithQuantityPaddingX = $addToCartWithQuantityPaddingX ?? setting('icommerce::productAddToCartWithQuantityPaddingX', null, 0);
    $this->addToCartWithQuantityPaddingY = $addToCartWithQuantityPaddingY ?? setting('icommerce::productAddToCartWithQuantityPaddingY', null, 0);
    $this->addToCartWithQuantityMarginBottom = $addToCartWithQuantityMarginBottom ?? setting('icommerce::productAddToCartWithQuantityMarginBottom', null, 0);
    $this->contentTitleFontSize = $contentTitleFontSize ?? setting('icommerce::productContentTitleFontSize', null, 14);
    $this->contentTitleToUppercase = $contentTitleToUppercase ?? setting('icommerce::productContentTitleToUppercase', null, false);
    $this->contentCategoryFontSize = $contentCategoryFontSize ?? setting('icommerce::productContentCategoryFontSize', null, 8);
    $this->contentCategoryToUppercase = $contentCategoryToUppercase ?? setting('icommerce::productContentCategoryToUppercase', null, true);
    $this->contentPriceFontSize = $contentPriceFontSize ?? setting('icommerce::productContentPriceFontSize', null, 8);
    $productListItemLayout = $layout ?? setting('icommerce::productListItemLayout', null, 'product-list-item-layout-1');
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