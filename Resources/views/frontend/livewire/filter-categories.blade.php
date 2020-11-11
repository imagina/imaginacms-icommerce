<div class="filter-categories mb-4">
  <h4 class="text-secondary">{{ trans('icommerce::categories.plural') }}</h4>
  <hr>
  
  <div class="row">
    <div class="col-12">
      <div class="list-categories overflow-auto">
        <ul class="list-group list-group-flush">
          
          @foreach($categories as $category)
            @if($category->parent_id == 0)
              @includeFirst(['icommerce.index.category','icommerce::frontend.index.category'])
            @endif
          @endforeach
        
        
        </ul>
      </div>
    </div>
  </div>

</div>