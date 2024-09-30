<?php

namespace Modules\Icommerce\Services;

class ProductService
{
    
    /*
    * Create Schema Script to Product
    */
    public function createSchemaScript($product,$currency){

        $schema["@context"] = "https://schema.org/";
        $schema["@type"] = "Product";
        $schema["name"] = $product->name;
        $schema["image"] = $product->mediaFiles()->mainimage->path ?? 'modules/icommerce/img/product/default.jpg';

        // Validate Manufacture
        if($product->manufacturer){
            $brand["@type"] = "Thing";
            $brand["@name"] = $product->manufacturer->name;
            $schema["brand"] = $brand;
        }

        // Validate rateable
        if(is_module_enabled('Rateable') && $product->timesRated()>0){
            $rating["@type"] = "AggregateRating";
            $rating["ratingValue"] = round($product->averageRating(),2);
            $rating["ratingCount"] = $product->timesRated();
            $schema["aggregateRating"] = $rating;
        }

        // Validate Offer
        if($product->discount){
            $offer["@type"] = "Offer";
            $offer["price"] = formatMoney($product->discount->price);
            $offer["priceCurrency"] = $currency->code;
            $offer["availability"] = "https://schema.org/InStock";
            $schema["offers"] = $offer;
        }
       
        
        $schemaJson = json_encode($schema,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
      return '<script type="application/ld+json"> '.$schemaJson.'</script>';

    }

}