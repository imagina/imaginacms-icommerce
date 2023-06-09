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
    <style>
        #categoryList3 .first-category {
            padding-bottom: 40px;
            border-bottom: solid 1px #b4b4b4;
            margin-bottom: 40px;
        }
        @media (max-width: 767px) {
            #categoryList3 .first-category {
                padding-bottom: 20px;
                padding-left: 0;
                padding-right: 0;
                border-bottom: solid 1px #b4b4b4;
                margin-bottom: 20px;
            }
        }
        #categoryList3 .first-category .items {
            height: 880px;
        }
        @media (max-width: 767px) {
            #categoryList3 .first-category .items {
                height: 400px;
            }
        }
        #categoryList3 .other-category .items {
            height: 400px;
        }
        #categoryList3 .other-category:first-child {
            padding-bottom: 40px;
            border-bottom: solid 1px #b4b4b4;
            margin-bottom: 40px;
        }
        @media (max-width: 767px) {
            #categoryList3 .other-category:first-child {
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
        }
        #categoryList3 .items {
            position: relative;
        }
        #categoryList3 .items .imagen, #categoryList3 .items .image-link {
            overflow: hidden;
        }
        #categoryList3 .items .imagen img, #categoryList3 .items .image-link img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            transform: scale(1);
            transition: all 500ms ease-in-out;
        }
        #categoryList3 .items .before {
            position: absolute;
            content: "";
            width: 100%;
            height: 100%;
            background-color: rgba(60, 60, 59, 0.5);
            z-index: 1;
        }
        #categoryList3 .items:nth-of-type(2):before {
            content: '';
            border-bottom: 1px solid #b4b4b4;
            position: absolute;
            bottom: -40px;
            display: block;
            height: 100%;
            z-index: 99;
            width: 100%;
        }
        #categoryList3 .items .card-img-overlay {
            margin: 20px;
            padding: 20px;
            border: 1px solid #fff;
            z-index: 99;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        #categoryList3 .items h3 {
            font-size: 3.75rem;
            font-weight: bold;
        }
        #categoryList3 .items .btn {
            font-size: 0.938rem;
            border-radius: 0;
            color: #0A0808;
            background-color: rgba(255, 255, 255, 0.7);
        }
        #categoryList3 .items:hover img {
            transform: scale(1.1);
        }
        @media (max-width: 769px) {
            #categoryList3 .items h3 {
                font-size: 1.875rem;
            }
            #categoryList3 .items:nth-of-type(1):before, #categoryList3 .items:nth-of-type(2):before {
                border-bottom: 1px solid #b4b4b4;
                bottom: -20px;
            }
        }

    </style>
</section>