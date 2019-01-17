<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Icommerce\Entities\Status;
use Modules\Ihelpers\Transformers\BaseApiTransformer;

class ProductTransformer extends BaseApiTransformer
{
  public function toArray($request)
  {


    $data =  [
      'id' => $this->id,
      'name' => $this->name,
      'slug' => $this->slug,
      'summary' => $this->summary,
      'options' => $this->options,
      'status' => $this->getStatus(),
      'sku' => $this->sku,
      'quantity' => $this->quantity,
      'stock_status' => $this->stockStatus(),
      'shipping' => $this->shipping,
      'price' => $this->price,
      'date_available' => $this->date_available,
      'weight' => $this->weight,
      'length' => $this->length,
      'width' => $this->width,
      'height' => $this->height,
      'subtract' => $this->subtract,
      'minimum' => $this->minimum,
      'reference' => $this->reference,
      'description' => $this->description,
      'rating' => $this->rating,
      'freeshipping' => $this->freeshipping,
      'order_weight' => $this->order_weight,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,

     'status'=> $this->status,
    'stock_status'=> $this->stock_status,
    'category_id'=> $this->category_id,

    ];

    /*RELATIONSHIPS*/

    // Tax Class
    $this->ifRequestInclude('addedBy') ?
      $data['addedBy'] = ($this->added_by_id ? new TaxClassTransformer($this->addedBy) : false) : false;


    // Tax Class
    $this->ifRequestInclude('taxClass') ?
      $data['taxClass'] = ($this->tax_class_id ? new TaxClassTransformer($this->taxClass) : false) : false;

    // Categories
    $this->ifRequestInclude('categories') ?
      $data['categories'] = ($this->categories ? CategoryTransformer::collection($this->categories) : false) : false;

    // Category
    $this->ifRequestInclude('category') ?
      $data['category'] = ($this->category_id ? CategoryTransformer::collection($this->category) : false) : false;

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

    // Option Values
    $this->ifRequestInclude('optionValues') ?
      $data['optionValues'] = ($this->optionValues ? OptionValueTransformer::collection($this->optionValues) : false) : false;

    // Related Products
    $this->ifRequestInclude('relatedProducts') ?
      $data['relatedProducts'] = ($this->relatedProducts ? ProductTransformer::collection($this->relatedProducts) : false) : false;

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

    // Gallery
    $this->ifRequestInclude('gallery') ?
      $data['gallery'] = ($this->gallery ? $this->gallery : false) : false;


    // TRANSLATIONS
    $filter = json_decode($request->filter);

    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations){

      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as  $key => $value){
        if ($this->hasTranslation($key)) {
          $data['translates'][$key]['name'] = $this->translate("$key")['name'];
          $data['translates'][$key]['description'] = $this->translate("$key")['description'];
          $data['translates'][$key]['summary'] = $this->translate("$key")['summary'];
            $data['translates'][$key]['slug'] = $this->translate("$key")['slug'];
        }
      }
    }

    return $data;
  }
}
