@if($categories && count($categories)>0)
<div class="filter-categories mb-4">

  @php($titleFilter = config("asgard.icommerce.config.filters.categories.title"))
  <h5 class="text-secondary">{{ trans($titleFilter) }}</h5>
  <hr>
  
  <div class="row">
    <div class="col-12">
      <div class="list-categories">
        <ul class="list-group list-group-flush">
          
          @foreach($categories as $category)
            @if($category->parent_id == 0)
              @include('icommerce::frontend.livewire.index.filters.categories.category-item')
            @endif
          @endforeach
        
        
        </ul>
      </div>
    </div>
  </div>

</div>
@endif