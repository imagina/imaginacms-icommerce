 <meta itemprop="name" content="{{$product->name}}">
 <meta itemprop="sku" content="{{$product->sku}}">
 <meta itemprop="description" content="{{$product->summary}}">
 <meta itemprop="image" content="{{$product->mediaFiles()->mainimage->path}}">
 @isset($product->manufacturer->name)
 <meta itemprop="brand" content="{{$product->manufacturer->name}}">
@endisset