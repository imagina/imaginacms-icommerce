@if($categories && count($categories)>0)
<div class="filter-categories">

  <div class="title">
    @php($titleFilter = config("asgard.icommerce.config.filters.categories.title"))
    <h5>{{ trans($titleFilter) }}</h5>
  </div>

  <div class="content">

    <div class="row">
      <div class="col-12">
        <div class="list-categories overflow-auto">
          <ul class="list-group list-group-flush">
            
            @foreach($categories as $index => $category)
              @if($category->parent_id == 0)
                @include('icommerce::frontend.index.category')
              @endif
            @endforeach
          
          
          </ul>
        </div>
      </div>
    </div>

  </div>

</div>
@endif