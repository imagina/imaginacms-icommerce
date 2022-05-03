<meta name="keywords" content="{{$product->meta_keyword ?? ''}}">
<meta name="description" content="{{$product->meta_description??$product->summary}}">
<meta name="robots" content="{{$product->options->meta_robots??'INDEX,FOLLOW'}}">
<!-- Schema.org para Google+ -->
<meta itemprop="name" content="{{$product->meta_title??$product->name}}">
<meta itemprop="description" content="{{$product->meta_description??$product->summary}}">
<meta itemprop="image"
        content=" {{url($product->mediaFiles()->mainimage->path ?? 'modules/icommerce/img/product/default.jpg') }}">
<!-- Open Graph para Facebook-->
  
<meta property="og:title" content="{{$product->meta_title??$product->name}}"/>
<meta property="og:type" content="article"/>
<meta property="og:url" content="{{$product->url}}"/>
<meta property="og:image" content="{{url($product->mediaFiles()->mainimage->path ?? 'modules/icommerce/img/product/default.jpg') }}"/>
<meta property="og:description" content="{{$product->meta_description??$product->summary}}"/>
<meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
<meta property="og:locale" content="{{config('asgard.iblog.config.oglocal')}}">
<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
<meta name="twitter:title" content="{{$product->meta_title??$product->name}}">
<meta name="twitter:description" content="{{$product->meta_description??$product->summary}}">
<meta name="twitter:creator" content="">
<meta name="twitter:image:src" content="{{url($product->mediaFiles()->mainimage->path ?? 'modules/icommerce/img/product/default.jpg') }}">

@section('title')
  
  {{$product->meta_title??$product->name}}  | @parent
@stop