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
  
        <x-isite::carousel.owl-carousel
          id="childrenCategoriesIndex"
          repository="Modules\Icommerce\Repositories\CategoryRepository"
          :params="['take' => 20,'filter' => $filter]"
          :margin="10"
          itemLayout="item-list-layout-1"
          :dots="false"
          :autoplay="false"
          :responsive="[0 => ['items' =>  2],640 => ['items' => 2],992 => ['items' => 4]]"/>
        
        <x-icommerce::category-list :params="['filter' => $filter, 'take' => 12]" layout="category-list-layout-4"/>

      </div>
    </div>
  </div>
</section>