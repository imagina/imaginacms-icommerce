<section class="children-categories-index">
  
  <div class="container">
    <div class="row">
      <div class="col-12">
        {{-- Breadcrumb --}}
        @php
        if(isset($category->id)){
          $filter = ['ids'=> $category->children->pluck('id')->toArray()];
        }else{
          $filter = ['parentId'=> 0];
        }
        @endphp
        
        <x-icommerce::category-list :params="['filter' => $filter, 'take' => 12]" layout="category-list-layout-4"/>

      </div>
    </div>
  </div>
</section>