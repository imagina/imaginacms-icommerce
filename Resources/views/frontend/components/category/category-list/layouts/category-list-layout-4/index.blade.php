<section id="categoryList4">
    <div class="card-categories">
        @foreach($categories as $key => $category)
            <div class="item-category">
                <div class="bg-img">
                    <x-media::single-image :alt="$category->title" :title="$category->title" :url="$category->url"
                                           :isMedia="true" :mediaFiles="$category->mediaFiles()" imgClasses="img-fluid"/>
                </div>
                <div class="card-overlay">
                    <h5 class="card-title mb-0"><a href="{{$category->url}}">{{$category->title}}</a></h5>
                </div>
            </div>
        @endforeach
    </div>
</section>
