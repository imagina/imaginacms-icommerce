<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ProductTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'name' => $this->name,
      'slug' => $this->slug,
      'summary' => $this->summary,
      'options' => $this->options,
      'status' => $this->status,
      'added_by_id' => $this->added_by_id,
      'category_id' => $this->category_id,
      'parent_id' => $this->parent_id,
      'tax_class_id' => $this->tax_class_id,
      'sku' => $this->sku,
      'quantity' => $this->quantity,
      'stock_status' => $this->stock_status,
      'manufacturer_id' => $this->manufacturer_id,
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
    ];
  
    // RELATIONSHIPS
    // Tax Class
    if(isset($this->taxClass))
      $data['taxClass'] = $this->taxClass;
    
    // Categories
    if(isset($this->categories))
      $data['categories'] = $this->categories;
    
    // Category
    if(isset($this->category))
      $data['category'] = $this->category;
    
    // Tags
    if(isset($this->tags))
      $data['tags'] = $this->tags;
    
    // Orders
    if(isset($this->orders))
      $data['orders'] = $this->orders;
    
    // Featured Products
    if(isset($this->featuredProducts))
      $data['featuredProducts'] = $this->featuredProducts;
  
    // Manufacturer
    if(isset($this->manufacturer))
      $data['manufacturer'] = $this->manufacturer;
  
    // Discounts
    if(isset($this->discounts))
      $data['discounts'] = $this->discounts;
  
    // Product Options
    if(isset($this->productOptions))
      $data['productOptions'] = $this->productOptions;
  
    // Option Values
    if(isset($this->optionValues))
      $data['optionValues'] = $this->optionValues;
  
    // Related Products
    if(isset($this->relatedProducts))
      $data['relatedProducts'] = $this->relatedProducts;
  
    // Wishlist
    if(isset($this->wishlists))
      $data['wishlists'] = $this->wishlists;
  
    // Coupons
    if(isset($this->coupons))
      $data['coupons'] = $this->coupons;
    
    // Parent
    if(isset($this->parent))
      $data['parent'] = $this->parent;
    
    // Children
    if(isset($this->children))
      $data['children'] = $this->children;
    
    // Gallery
    if(count($this->gallery))
      $data['gallery'] = $this->gallery;
  
  
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
        }
      }
    }
    
    return $data;
  }
}