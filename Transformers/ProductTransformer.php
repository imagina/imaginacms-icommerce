<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Icommerce\Entities\Status;
use Modules\Ihelpers\Transformers\BaseApiTransformer;

class ProductTransformer extends BaseApiTransformer
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->id,
      'name' => $this->name ?? '',
      'slug' => $this->slug ?? '',
      'summary' => $this->summary ?? '',
      'metaTitle' => $this->meta_title ?? '',
      'metaDescription' => $this->meta_description ?? '',
      'options' => $this->when($this->options, $this->options),
      'sku' => $this->when($this->sku, $this->sku),
      'quantity' => $this->when($this->quantity, $this->quantity),
      'shipping' => $this->when($this->shipping, ((int)$this->shipping ? true : false)),
      'price' => $this->when($this->price, $this->price),
      'dateAvailable' => $this->when($this->date_available, $this->date_available),
      'weight' => $this->when($this->weight, $this->weight),
      'length' => $this->when($this->length, $this->length),
      'width' => $this->when($this->width, $this->width),
      'height' => $this->when($this->height, $this->height),
      'subtract' => $this->when($this->subtract, ((int)$this->subtract ? true : false)),
      'minimum' => $this->when($this->minimum, $this->minimum),
      'reference' => $this->when($this->reference, $this->reference),
      'description' => $this->when($this->description, $this->description),
      'rating' => $this->when($this->rating, $this->rating),
      'freeshipping' => $this->when($this->freeshipping, ((int)$this->freeshipping ? true : false)),
      'orderWeight' => $this->when($this->order_weight, $this->order_weight),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'status' => $this->when($this->status, $this->status),
      'stockStatus' => $this->when($this->stock_status, $this->stock_status),
      'parentId' => $this->when($this->parent_id, $this->parent_id),
      'categoryId' => $this->when($this->category_id, $this->category_id),
      'categories' => CategoryTransformer::collection($this->whenLoaded('categories')),
      'category' => new CategoryTransformer($this->whenLoaded('category')),
      'productOptions' => ProductOptionTransformer::collection($this->whenLoaded('productOptions')),
      'optionValues' => ProductOptionValueTransformer::collection($this->whenLoaded('optionValues')),
      'relatedProducts' => ProductTransformer::collection($this->whenLoaded('relatedProducts')),
      'mainImage' => $this->mainImage,
      'gallery' => $this->gallery,
    ];

    /*RELATIONSHIPS*/
    // Tax Class
    $this->ifRequestInclude('addedBy') ?
      $data['addedBy'] = ($this->added_by_id ? new TaxClassTransformer($this->addedBy) : false) : false;

    // Tax Class
    $this->ifRequestInclude('taxClass') ?
      $data['taxClass'] = ($this->tax_class_id ? new TaxClassTransformer($this->taxClass) : false) : false;

    // Tags
    $this->ifRequestInclude('tags') ?
      $data['tags'] = ($this->tags ? TagTransformer::collection($this->tags) : false) : false;

    // Orders
    $this->ifRequestInclude('orders') ?
      $data['orders'] = ($this->orders ? OrderTransformer::collection($this->orders) : false) : false;

    // Featured Products
    $this->ifRequestInclude('featuredProducts') ?
      $data['featuredProducts'] = ($this->featuredProducts ? ProductTransformer::collection($this->featuredProducts) : false) : false;

    // Manufacturer
    $this->ifRequestInclude('manufacturer') ?
      $data['manufacturer'] = ($this->manufacturer_id ? OrderTransformer::collection($this->manufacturer) : false) : false;

    /* OJO PROBAR
    // Discounts
    $this->ifRequestInclude('discounts') ?
      $data['discounts'] = ($this->discounts ? OrderTransformer::collection($this->discounts) : false) : false;
  */

    /* OJO FALTA TRANSFORMER
    // Product Options
    $this->ifRequestInclude('productOptions') ?
      $data['productOptions'] = ($this->productOptions ? $this->productOptions : false) : false;
  */

    // Wishlist
    $this->ifRequestInclude('wishlists') ?
      $data['wishlists'] = ($this->wishlists ? WishlistTransformer::collection($this->wishlists) : false) : false;

    // Coupons
    $this->ifRequestInclude('coupons') ?
      $data['coupons'] = ($this->coupons ? CouponTransformer::collection($this->coupons) : false) : false;

    // Parent
    $this->ifRequestInclude('parent') ?
      $data['parent'] = ($this->parent_id ? new ProductTransformer($this->parent) : false) : false;

    // Children
    $this->ifRequestInclude('children') ?
      $data['children'] = ($this->children ? ProductTransformer::collection($this->children) : false) : false;


    // TRANSLATIONS
    $filter = json_decode($request->filter);
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as $lang => $value) {
        if ($this->hasTranslation($lang)) {
          $data[$lang]['name'] = $this->hasTranslation($lang) ?
            $this->translate("$lang")['name'] : '';
          $data[$lang]['description'] = $this->hasTranslation($lang) ?
            $this->translate("$lang")['description'] : '';
          $data[$lang]['summary'] = $this->hasTranslation($lang) ?
            $this->translate("$lang")['summary'] : '';
          $data[$lang]['slug'] = $this->hasTranslation($lang) ?
            $this->translate("$lang")['slug'] : '';
          $data[$lang]['metaTitle'] = $this->hasTranslation($lang) ?
            $this->translate("$lang")['metaTitle'] : '';
          $data[$lang]['metaDescription'] = $this->hasTranslation($lang) ?
            $this->translate("$lang")['metaDescription'] : '';
        }
      }
    }

    return $data;
  }
}
