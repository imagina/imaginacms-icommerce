<?php

namespace Modules\Icommerce\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;
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
  public $wishlistEnable;
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
  public $contentTitleMaxHeight;
  public $contentTitleNumberOfCharacters;
  public $contentTitleToUppercase;
  public $contentCategoryFontSize;
  public $contentCategoryEnable;
  public $contentCategoryToUppercase;
  public $contentPriceFontSize;
  public $contentPriceFontWeight;
  public $customIndexContactLabel;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($item,
                              $itemListLayout = null,
                              $layout = null,
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
                              $wishlistEnable = null,
                              $wishlistIcon = null,
                              $addToCartWithQuantityStyle = null,
                              $withTextInAddToCart = null,
                              $withIconInAddToCart = null,
                              $addToCartWithQuantity = null,
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
                              $contentTitleMaxHeight = null,
                              $contentTitleNumberOfCharacters = null,
                              $contentTitleToUppercase = false,
                              $contentCategoryEnable = null,
                              $contentCategoryFontSize = 8,
                              $contentCategoryToUppercase = true,
                              $contentPriceFontSize = 8,
                              $contentPriceFontWeight = null,
                              $parentAttributes = null,
                              $editLink,
                              $tooltipEditLink)
  {
    $this->product = $item;
    
    $this->itemListLayout = $itemListLayout ?? "product-list-item-layout-1";
    
    list($this->discountRibbonStyle,
      $this->discountPosition,
      $this->imagePadding,
      $this->imageBorder,
      $this->imageBorderColor,
      $this->imageBorderRadius,
      $this->imageAspect,
      $this->externalPadding,
      $this->externalBorder,
      $this->externalBorderRadius,
      $this->externalBorderColor,
      $this->externalShadowOnHover,
      $this->externalShadowOnHoverColor,
      $this->addToCartIcon,
      $this->wishlistEnable,
      $this->wishlistIcon,
      $this->addToCartWithQuantityStyle,
      $this->withTextInAddToCart,
      $this->withIconInAddToCart,
      $this->addToCartWithQuantity,
      $this->showButtonsOnMouseHover,
      $this->buttonsLayout,
      $this->buttonsPosition,
      $this->contentAlign,
      $this->contentExternalPaddingX,
      $this->contentExternalPaddingY,
      $this->addToCartWithQuantityPaddingX,
      $this->addToCartWithQuantityPaddingY,
      $this->addToCartWithQuantityMarginBottom,
      $this->contentTitleFontSize,
      $this->contentTitleMaxHeight,
      $this->contentTitleNumberOfCharacters,
      $this->contentTitleToUppercase,
      $this->contentCategoryEnable,
      $this->contentCategoryFontSize,
      $this->contentCategoryToUppercase,
      $this->contentPriceFontSize,
      $this->contentPriceFontWeight,
      $this->view,
      $this->customIndexContactLabel) =
      Cache::store('array')->remember("productListItemSettings", 60*60*24, function () use ( //Caché de settings de productos por 30 días
      $discountRibbonStyle,
      $discountPosition,
      $imagePadding,
      $imageBorder,
      $imageBorderColor,
      $imageBorderRadius,
      $imageAspect,
      $externalPadding,
      $externalBorder,
      $externalBorderRadius,
      $externalBorderColor,
      $externalShadowOnHover,
      $externalShadowOnHoverColor,
      $addToCartIcon,
      $wishlistEnable,
      $wishlistIcon,
      $addToCartWithQuantityStyle,
      $withTextInAddToCart,
      $withIconInAddToCart,
      $addToCartWithQuantity,
      $showButtonsOnMouseHover,
      $buttonsLayout,
      $buttonsPosition,
      $contentAlign,
      $contentExternalPaddingX,
      $contentExternalPaddingY,
      $addToCartWithQuantityPaddingX,
      $addToCartWithQuantityPaddingY,
      $addToCartWithQuantityMarginBottom,
      $contentTitleFontSize,
      $contentTitleMaxHeight,
      $contentTitleNumberOfCharacters,
      $contentTitleToUppercase,
      $contentCategoryEnable,
      $contentCategoryFontSize,
      $contentCategoryToUppercase,
      $contentPriceFontSize,
      $contentPriceFontWeight,
      $layout
    ) {
      $productListItemLayout = $layout ?? setting('icommerce::productListItemLayout', null, 'product-list-item-layout-1');
      return [
        $discountRibbonStyle ?? setting('icommerce::productDiscountRibbonStyle', null, "flag"),
        $discountPosition ?? setting('icommerce::productDiscountPosition', null, "top-right"),
        $imagePadding ?? setting('icommerce::productImagePadding', null, 0),
        $imageBorder ?? setting('icommerce::productImageBorder', null, false),
        $imageBorderColor ?? setting('icommerce::productImageBorderColor', null, "#dddddd"),
        $imageBorderRadius ?? setting('icommerce::productImageBorderRadius', null, 0),
        $imageAspect ?? setting('icommerce::productAspect', null, '1-1'),
        $externalPadding ?? setting('icommerce::productExternalPadding', null, 0),
        $externalBorder ?? setting('icommerce::productExternalBorder', null, false),
        $externalBorderRadius ?? setting('icommerce::productExternalBorderRadius', null, 0),
        $externalBorderColor ?? setting('icommerce::productExternalBorderColor', null, "#dddddd"),
        $externalShadowOnHover ?? setting('icommerce::productExternalShadowOnHover', null, true),
        $externalShadowOnHoverColor ?? setting('icommerce::productExternalShadowOnHoverColor', null, "rgba(0, 0, 0, 0.15)"),
        $addToCartIcon ?? setting('icommerce::productAddToCartIcon', null, "fa-shopping-cart"),
        $wishlistEnable ?? setting('icommerce::productWishlistEnable', null, true),
        $wishlistIcon ?? setting('icommerce::productWishlistIcon', null, "fa-heart-o"),
        $addToCartWithQuantityStyle ?? setting('icommerce::productAddToCartWithQuantityStyle', null, "square"),
        $withTextInAddToCart ?? setting('icommerce::productWithTextInAddToCart', null, true),
        $withIconInAddToCart ?? setting('icommerce::productWithIconInAddToCart', null, true),
        $addToCartWithQuantity ?? setting('icommerce::product-add-to-cart-with-quantity', null, false),
        $showButtonsOnMouseHover ?? setting('icommerce::productShowButtonsOnMouseHover', null, false),
        $buttonsLayout ?? setting('icommerce::productButtonsLayout', null, 'borders'),
        $buttonsPosition ?? setting('icommerce::productButtonsPosition', null, 'in-content'),
        $contentAlign ?? setting('icommerce::productContentAlign', null, "left"),
        $contentExternalPaddingX ?? setting('icommerce::productContentExternalPaddingX', null, 0),
        $contentExternalPaddingY ?? setting('icommerce::productContentExternalPaddingY', null, 0),
        $addToCartWithQuantityPaddingX ?? setting('icommerce::productAddToCartWithQuantityPaddingX', null, 0),
        $addToCartWithQuantityPaddingY ?? setting('icommerce::productAddToCartWithQuantityPaddingY', null, 0),
        $addToCartWithQuantityMarginBottom ?? setting('icommerce::productAddToCartWithQuantityMarginBottom', null, 0),
        $contentTitleFontSize ?? setting('icommerce::productContentTitleFontSize', null, 14),
        $contentTitleMaxHeight ?? setting('icommerce::productContentTitleMaxHeight', null, 14),
        $contentTitleNumberOfCharacters ?? setting('icommerce::productContentTitleNumberOfCharacters', null, 100),
        $contentTitleToUppercase ?? setting('icommerce::productContentTitleToUppercase', null, false),
        $contentCategoryEnable ?? setting('icommerce::productContentCategoryEnable', null, true),
        $contentCategoryFontSize ?? setting('icommerce::productContentCategoryFontSize', null, 8),
        $contentCategoryToUppercase ?? setting('icommerce::productContentCategoryToUppercase', null, true),
        $contentPriceFontSize ?? setting('icommerce::productContentPriceFontSize', null, 8),
        $contentPriceFontWeight ?? setting('icommerce::productContentPriceFontWeight', null, "normal"),
        "icommerce::frontend.components.product.product-list-item.layouts." . $productListItemLayout . ".index",
        setting('icommerce::customIndexContactLabel', null, 'Contáctenos')
      ];
    });
    
 
    $this->editLink = $editLink;
    $this->tooltipEditLink = $tooltipEditLink;
    
    if (!empty($parentAttributes))
      $this->getParentAttributes($parentAttributes);
  }
  
  private function getParentAttributes($parentAttributes)
  {
    
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