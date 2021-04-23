@section('meta')
  @if(isset($category->id) || isset($manufacturer->id))
    
    @php
    if(isset($category->id)){
        $title = $category->meta_title ?? $category->title . (isset($manufacturer->id) ? " - ".$manufacturer->meta_title ?? $manufacturer->title : '');
        $description = $category->meta_description ?? $category->description . (isset($manufacturer->id) ? " - ".$manufacturer->meta_description ?? $manufacturer->description : '');
        
          $mediaFiles = $category->mediaFiles();
          $withImage = !strpos($mediaFiles->mainimage->path,"default.jpg");
          if(!$withImage){
            if(isset($manufacturer->id)){
              $mediaFiles = $manufacturer->mediaFiles();
              $withImage = !strpos($mediaFiles->mainimage->path,"default.jpg");
              if($withImage){
                $image = $mediaFiles->mainimage->path;
              }
            }
          }else{
            $image = $mediaFiles->mainimage->path;
          }
          
          $type = isset($manufacturer->id) ? "branch" : "category";
          
          $url = $category->url;
    }elseif(isset($manufacturer->id)){
       $title =$manufacturer->meta_title ?? $manufacturer->title;
        $description = $manufacturer->meta_description ?? $manufacturer->description;
            
              $mediaFiles = $manufacturer->mediaFiles();
              $withImage = !strpos($mediaFiles->mainimage->path,"default.jpg");
              if($withImage){
                $image = $mediaFiles->mainimage->path;
              }
              
              $type = "branch";
              
              $url = $manufacturer->url;
    }
    
    @endphp
    
    
    <meta name="description" content="{{$description}}">
    <!-- Schema.org para Google+ -->
    <meta itemprop="name" content="{{$title}}">
    <meta itemprop="description" content="{{$description}}">
    
    @if($withImage)
    <meta itemprop="image" content=" {{url($image)}}">
    <meta property="og:image" content="{{url($image) }}"/>
    <meta name="twitter:image:src" content="{{url($image) }}">
    @endif
    <meta property="og:title"
          content="{{$title}}"/>
    <meta property="og:type" content="{{$type}}"/>
    <meta property="og:url" content="{{$url}}"/>
    <meta property="og:description"
          content="{{$description}}"/>
    <meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
    <meta property="og:locale" content="{{config('asgard.iblog.config.oglocal')}}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
    <meta name="twitter:title"
          content="{{$title}}">
    <meta name="twitter:description"
          content="{{$description}}">
    <meta name="twitter:creator" content="">
  @endif
@stop

@section('title')
  {{isset($category->title)? $category->title : isset($manufacturer->title) ? $manufacturer->title : trans("icommerce::routes.store.index.index")}}  | @parent
@stop