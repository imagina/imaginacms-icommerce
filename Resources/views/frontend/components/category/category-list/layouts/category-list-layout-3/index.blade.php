<section id="categoryList3">
  <div class="container">
    <div class="row">
      @php($index = 0)
      @foreach($categories as $key => $category)
        @if($category->status && $index <= 2)
          @if($index!=2)
            <div class="col-12 col-lg-6">
          @endif
          @if($index != 0)
            <div class="row">
          @endif
          
          <!-- Single Category -->
          <div class="col-12 {{$index ==0 ? "first-category" : "other-category" }}">
            <div id="{{ $category->title }}" class="items">
              <div class="card h-100 card-overlay overflow-hidden rounded border-0">
              
                  <x-media::single-image :alt="$category->title" :title="$category->title" :url="$category->url"
                                         :isMedia="true" :mediaFiles="$category->mediaFiles()" imgClasses="img-fluid"/>
  
                <a href="{{$category->url}}">
                <div class="card-img-overlay">
                  <h3 class="card-title text-white mb-1">{{$category->title}}</h3>
                  <div class="btn border-0">QUIERO COMPRAR</div>
                </div>
                </a>
                <a href="{{$category->url}}">
                  <div class="before"></div>
                </a>
              </div>
            </div>
          </div>
          
          @if($index != 0)
            <!-- close row -->
            </div>
          @endif
          @if($index!=1)
            <!-- close col-12 col-lg-6 -->
            </div>
          @endif
        @endif
        @php($index++)
      @endforeach
    </div>
  </div>
</section>