<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Icommerce\Entities\Status;
use Modules\Ihelpers\Traits\Transformeable;
use Modules\Iprofile\Transformers\UserTransformer;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Modules\Marketplace\Transformers\StoreTransformer as MarketplaceStoreTransformer;
use Modules\Icurrency\Support\Facades\Currency;

class ProductTransformer extends BaseApiTransformer
{
    use Transformeable;

    public function toArray($request)
    {
        $filter = json_decode($request->filter);
        //$price = Currency::convert($this->price);
        //$price = $this->present()->price();

        $data = [
            'id' => $this->id,
            'name' => $this->name ?? '',
            'slug' => $this->slug ?? '',
            'summary' => $this->summary ?? '',
            'metaTitle' => $this->meta_title ?? '',
            'metaDescription' => $this->meta_description ?? '',
            'options' => $this->when($this->options, $this->options),
            'sku' => $this->when($this->sku, $this->sku),
            'quantity' => $this->when(isset($this->quantity), $this->quantity),
            'shipping' => $this->when($this->shipping, ((int)$this->shipping ? true : false)),
            'price' => $this->when($this->price, $this->price),
            'formattedPrice' => formatMoney($this->price),
            'dateAvailable' => $this->when($this->date_available, $this->date_available),
            'weight' => $this->when($this->weight, $this->weight),
            'length' => $this->when($this->length, $this->length),
            'width' => $this->when($this->width, $this->width),
            'height' => $this->when($this->height, $this->height),
            'subtract' => $this->when($this->subtract, ((int)$this->subtract ? true : false)),
            'minimum' => $this->when($this->minimum, $this->minimum),
            'reference' => $this->when($this->reference, $this->reference),
            'description' => $this->when($this->description, $this->description),
            'rating' => $this->when($this->rating, (int)$this->rating),
            'freeshipping' => $this->when($this->freeshipping, ((int)$this->freeshipping ? true : false)),
            'orderWeight' => $this->when($this->order_weight, $this->order_weight),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'status' => $this->when(isset($this->status), $this->status),
            'stockStatus' => $this->when(isset($this->stock_status), $this->stock_status),
            'parentId' => $this->when($this->parent_id, $this->parent_id),
            'categoryId' => $this->when($this->category_id, intval($this->category_id)),
            'categories' => CategoryTransformer::collection($this->whenLoaded('categories')),
            'discounts' => ProductDiscountTransformer::collection($this->whenLoaded('discounts')),
            'category' => new CategoryTransformer($this->whenLoaded('category')),
            'productOptions' => ProductOptionPivotTransformer::collection($this->whenLoaded('productOptions')),
            'optionValues' => ProductOptionValueTransformer::collection($this->whenLoaded('optionValues')),
            'relatedProducts' => ProductTransformer::collection($this->whenLoaded('relatedProducts')),
            'mainImage' => $this->mainImage,
            'gallery' => $this->gallery,
            'storeId' => $this->store_id,
            'averageRating'=> (float)$this->averageRating ?? 0,
            'featured' => $this->featured ? '1' : '0',
            'sortOrder' => !$this->sort_order ? "0": (string)$this->sort_order,
            'visible' => $this->featured  ? 1 : 0,
            'url' => $this->url ?? '#',
            //'productDiscounts' => $this->discounts()->pluck('discount_id'),
            // totalDiscounts deprecated, bad way to calculate discounts
            'totalDiscounts' => $this->present()->totalDiscounts,
            'isCall' => $this->is_call ? '1' : '0',
            'customUrl' => $this->when($this->custom_url, $this->custom_url),

            'totalTaxes' => $this->getTotalTaxes($filter),
            'manufacturerId' => $this->when($this->manufacturer_id, intval($this->manufacturer_id)),
            'taxClassId' => $this->when($this->tax_class_id, intval($this->tax_class_id)),
            'mediaFiles' => $this->mediaFiles(),
            'isNew' => $this->is_new,
            'isAvailable' => $this->is_available,
        ];

        $discount = $this->discount;
        if(isset($discount->id)){
            $data["discount"] = new ProductDiscountTransformer($discount);
        }

        if(is_module_enabled('Icommercepricelist')){
            $data['priceLists'] = \Modules\Icommercepricelist\Transformers\PriceListTransformer::collection($this->whenLoaded('priceLists'));
        }else{
            $data['priceLists'] = [];
        }

        /*RELATIONSHIPS*/
        // Tax Class
        $this->ifRequestInclude('addedBy') ?
            $data['addedBy'] = ($this->added_by_id ? new UserTransformer($this->addedBy) : false) : false;

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
            $data['manufacturer'] = ($this->manufacturer_id ? new ManufacturerTransformer($this->manufacturer) : false) : false;

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

        if (is_module_enabled('Marketplace')) {
            $data['store'] = new MarketplaceStoreTransformer($this->whenLoaded('store'));
        } else {
            $data['store'] = new StoreTransformer($this->whenLoaded('store'));
        }

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

        $this->customIncludes($data);

        return $data;
    }

    private function getTotalTaxes($filter)
    {
        $basePrice = $this->price ? $this->price : 0;
        $taxes = [];
        if (isset($this->taxClass) && isset($this->taxClass->rates)) {
            $taxes = $this->taxClass->rates;
            if (isset($filter->geozone)) {
                $taxes = $taxes->where('geozone_id', $filter->geozone);
            }
        }
        $totalTaxes = 0;
        foreach ($taxes as $tax) {
            $totalTaxes += floatval(($basePrice * $tax->rate) / 100);
        }
        return $totalTaxes;
    }
}
