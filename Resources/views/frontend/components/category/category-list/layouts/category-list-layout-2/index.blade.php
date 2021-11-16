<section id="categoryList2" class="category-list container-fluid">
  <div class="row mx-0">
    @php($index = 0)
    @foreach($categories as $key => $category)
      @if($category->status)

        <div class="{{$columns[$index%count($columns)]}} category-list-2__item position-relative">
          <figure>
            <x-media::single-image :alt="$category->title" :title="$category->title" :url="$category->url"
                                   :isMedia="true"
                                   :mediaFiles="$category->mediaFiles()" imgClasses="cover-img"/>
            <a href="{{$category->url}}">
              <div class="before"></div>
            </a>
            <figcaption>
              <a href="{{$category->url}}">
                <h2 class="text-white">{{$category->title}}</h2>
              </a>
              @if($showDescription)
                <div class="description">
                  {!! $category->description!!}
                </div>
              @endif
              <a href="{{$category->url}}">
                <button class="btn btn-custom text-center text-white bg-transparent border-0"
                        type="button">
                  <i class="fa fa-arrow-circle-right mr-1" aria-hidden="true/"></i>
                  {{trans('icommerce::categories.button.show_products')}}
                </button>
              </a>
            </figcaption>
          </figure>

        </div>
      @endif
      @php($index++)
    @endforeach
  </div>
</section>
