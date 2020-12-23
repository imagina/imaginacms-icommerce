<section id="categoryList2" class="category-list container-fluid">
  <div class="row mx-0">
  @foreach($categories as $index => $category)
    @if($category->status)
      @php
        if ($index != 2 && $index != 3) {
           $col = 'col-md-6';
        } elseif ($index == 2) {
           $col = 'col-md-7';
        } elseif ($index == 3) {
           $col = 'col-md-5';
        }
      @endphp
      
      <div class="{{$col}} category-list-2__item position-relative">
        <a href="{{$category->url}}">
          <figure>
            <x-media::single-image :alt="$category->title" :title="$category->title" :url="$category->url" :isMedia="true"
                                   :mediaFiles="$category->mediaFiles()" imgClasses="cover-img"/>
          
            <figcaption>
              <h2 class="text-white">{{$category->title}}</h2>
              
              <button class="btn-custom text-center text-white text-uppercase bg-transparent border-0"
                      type="button">
                <i class="fa fa-arrow-circle-right mr-1" aria-hidden="true"></i>
                Ver productos
              </button>
            </figcaption>
          </figure>
        </a>
      </div>
   @endif
  @endforeach
  </div>
</section>