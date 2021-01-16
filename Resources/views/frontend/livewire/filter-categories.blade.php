@if($categories && count($categories)>0)
<div class="filter-categories">

  <div class="title">
    <a class ="item" data-toggle="collapse" href="#collapseCategories" role="button" aria-expanded="true" aria-controls="collapseCategories">
        
        @php($titleFilter = config("asgard.icommerce.config.filters.categories.title"))
        <h5>
          <i class="fa angle float-right" aria-hidden="true"></i>
          {{ trans($titleFilter) }}
        </h5>

      </a>

  </div>

  <div class="content position-relative">

    <div class="collapse show" id="collapseCategories">

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

</div>
@endif