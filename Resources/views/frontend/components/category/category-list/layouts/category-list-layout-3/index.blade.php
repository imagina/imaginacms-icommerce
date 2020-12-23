<section id="categoryList3">
  <div class="container">
    <div class="row">
      @foreach($categories as $key => $category)
        @if($key > 2) @php continue; @endphp @endif
        @if($category->status)
          @if($key!=2)
            <div class="col-12 col-lg-6">
          @endif
          @if($key != 0)
            <div class="row">
          @endif
          
          <!-- Single Category -->
          <div class="col-12 {{$key ==0 ? "first-category" : "other-category" }}">
            <div id="{{ $category->title }}" class="items">
              <div class="card h-100 card-overlay rounded border-0">
                <a href="{{$category->url}}" class="position-relative h-100 imagen">
                  <x-media::single-image :alt="$category->title" :title="$category->title" :url="$category->url" :isMedia="true"
                                         :mediaFiles="$category->mediaFiles()" imgClasses="img-fluid"/>
                </a>
                <div class="card-img-overlay">
                  <h3 class="card-title text-white mb-1">{{$category->title}}</h3>
                  <a class="btn border-0" href="{{$category->url}}">QUIERO COMPRAR</a>
                </div>
              </div>
            </div>
          </div>
          
          @if($key != 0)
            <!-- close row -->
            </div>
          @endif
          @if($key!=1)
            <!-- close col-12 col-lg-6 -->
            </div>
          @endif
        @endif
      @endforeach
    </div>
  </div>
</section>