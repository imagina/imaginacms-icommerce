@foreach($categories->all() as $category)
  @livewire("icommerce::products-by-category", ["criteria" => $category->id, "field" => "id", "params" => ["take" => 20]],key("featured-".$category->slug))
@endforeach