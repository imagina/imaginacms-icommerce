@section('meta')
  @if(isset($category) && !empty($category))
      <meta name="description" content="{{$category->meta_description ?? $category->description ?? ''}}">
      <!-- Schema.org para Google+ -->
      <meta itemprop="name" content="{{$category->meta_title ?? $category->title ?? ''}}">
      <meta itemprop="description" content="{{$category->meta_description ?? $category->description ?? ''}}">
      <meta itemprop="image"
            content=" {{url($category->mainimage->path??'modules/icommerce/img/category/default.jpg')}}">
  @endif
@stop

@section('title')
  {{isset($category->title)? $category->title: trans("icommerce::routes.store.index")}}  | @parent
@stop