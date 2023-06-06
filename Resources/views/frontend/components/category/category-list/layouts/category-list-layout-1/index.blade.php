<section id="categoryList1" class="category-list">
  <div class="container-fluid px-0">
    <div class="row no-gutters">
      @foreach($categories as $category)
      <div class="col-12 col-md-4">
        <div class="card h-100 card-overlay rounded border-0">
          <a href="{{$category->url}}" class="position-relative" style="background-image: url('{{$category->mediaFiles()->mainimage->path}}')">
            <div class="card-img-overlay">
              <h3 class="card-title text-white mb-1">{{$category->title}}</h3>
            </div>
          </a>
        </div>
      </div>
      @endforeach

    </div>
  </div>
  <style>
    #categoryList1 .card a {
      height: calc(100vh *.72) !important;
      background-size: cover;
      background-repeat: no-repeat;
    }
    #categoryList1 .card h3 {
      font-size: 2.375rem;
    }
    #categoryList1 .card:hover {
      box-shadow: 0px 0px 9px 0px #949393;
      z-index: 9;
    }
    @media (max-width: 576px) {
      #categoryList1 .card h3 {
        font-size: 1.125rem;
      }
    }

  </style>
</section>
