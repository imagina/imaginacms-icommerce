<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ProductTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->id,
      'title' => $this->title,
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
  
    // Tax Class
    if(isset($this->taxClass))
      $item['taxClass'] = $this->taxClass;
    
    // Categories
    if(isset($this->categories))
      $item['categories'] = $this->categories;
    
    // Category
    if(isset($this->category))
      $item['category'] = $this->category;
    
    // Tags
    if(isset($this->tags))
      $item['tags'] = $this->tags;
    
    // Orders
    if(isset($this->orders))
      $item['orders'] = $this->orders;
    
    // Featured Products
    if(isset($this->featuredProducts))
      $item['featuredProducts'] = $this->featuredProducts;
  
    // Manufacturer
    if(isset($this->manufacturer))
      $item['manufacturer'] = $this->manufacturer;
  
    // Discounts
    if(isset($this->discounts))
      $item['discounts'] = $this->discounts;
  
    // Options
    if(isset($this->options))
      $item['options'] = $this->options;
  
    // Option Values
    if(isset($this->optionValues))
      $item['optionValues'] = $this->optionValues;
  
    // Related Products
    if(isset($this->relatedProducts))
      $item['relatedProducts'] = $this->relatedProducts;
  
    // Wishlist
    if(isset($this->wishlists))
      $item['wishlists'] = $this->wishlists;
  
    // Coupons
    if(isset($this->coupons))
      $item['coupons'] = $this->coupons;
    
    // Parent
    if(isset($this->parent))
      $item['parent'] = $this->parent;
    
    // Children
    if(isset($this->children))
      $item['children'] = $this->children;
    
    // Gallery
    if(count($this->gallery))
      $item['gallery'] = $this->gallery;
  
    return $item;
  }
}