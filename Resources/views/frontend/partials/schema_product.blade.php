<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Product",
  "name": "{{$product->title}}",
  "image": [
    "{{url($product->options->mainimage ?? $product->mainimage ?? 'modules/icommerce/img/product/default.jpg')}}"
   ],
  "description": "{{strip_tags($product->description)}}",
  "sku": "{{$product->sku}}",
  "brand": {
    "@type": "Thing",
    "name": "{{$product->manufacturer->title ?? Setting::get('core::site-name') }}"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{$product->rating ?? 3}}",
    "reviewCount": "100"
  },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "{{$currency->code ?? 'USD'}}",
    "price": "{{formatMoney($product->price)}}",
    "availability": "{{$product->stock_status==0 ? 'http://schema.org/OutOfStock':'http://schema.org/InStock'}}",
    "seller": {
      "@type": "Organization",
      "name": "{{Setting::get('core::site-name')}}"
    }
  }
}
</script>