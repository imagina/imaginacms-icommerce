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
  <style>
    #categoryList2 {
      padding-top: 45px;
      padding-bottom: 30px;
    }
    #categoryList2 h3 {
      text-transform: uppercase;
      margin-bottom: 41px;
    }
    #categoryList2 .category-list-2__item {
      margin-bottom: 22px;
    }
    #categoryList2 .category-list-2__item figure {
      position: relative;
      height: 395px;
      margin: 0;
      overflow: hidden;
    }
    #categoryList2 .category-list-2__item figure .before {
      position: absolute;
      content: '';
      width: 100%;
      height: 100%;
      background-color: rgba(104, 77, 52, 0.32);
      z-index: 1;
    }
    #categoryList2 .category-list-2__item figure img {
      transition: all 0.5s;
    }
    #categoryList2 .category-list-2__item figure figcaption {
      position: absolute;
      left: 27px;
      bottom: 31px;
      z-index: 2;
    }
    #categoryList2 .category-list-2__item figure figcaption h2 {
      margin-bottom: 20px;
    }
    #categoryList2 .category-list-2__item figure figcaption .btn-custom {
      font-size: 18px;
      margin-left: 15px;
    }
    #categoryList2 .category-list-2__item figure figcaption .btn-custom i {
      font-size: 20px;
    }
    #categoryList2 .category-list-2__item figure:hover img, #categoryList2 .category-list-2__item figure:focus img {
      transform: scale(1.1);
    }
    /***** Media Queries *****/
    @media (max-width: 576px) {
      #categoryList2 {
        padding-right: 0;
        padding-left: 0;
      }
      #categoryList2 .category-list-2__item {
        padding: 0;
        margin-bottom: 1px;
      }
      #categoryList2 .category-list-2__item figure {
        height: 168px;
      }
      #categoryList2 .category-list-2__item figure figcaption {
        left: 23px;
        bottom: 11px;
      }
      #categoryList2 .category-list-2__item figure figcaption h2 {
        font-size: 26px;
        margin-bottom: 2px;
      }
      #categoryList2 .category-list-2__item figure figcaption .btn-custom {
        font-size: 11px;
        padding: 0;
        margin-left: 0;
      }
      #categoryList2 .category-list-2__item figure figcaption .btn-custom i {
        font-size: 14px;
        vertical-align: middle;
      }
    }

  </style>
</section>
