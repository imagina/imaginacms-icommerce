@if($categories && count($categories)>0)
<div class="filter-categories mb-4">

  <h5 class="text-secondary">{{$titleFilter}}</h5>
  <hr>
  
  <div class="row">
    <div class="col-12">
      <div class="list-categories">
        <ul class="list-group list-group-flush">
          
          @foreach($categories as $category)
            @if($category->parent_id == 0)
              @include('icommerce::frontend.livewire.index.filters.categories.category-item',["level" => 0])
            @endif
          @endforeach
        
        
        </ul>
      </div>
    </div>
  </div>

</div>
@endif