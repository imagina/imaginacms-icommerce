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
</section>