<nav class="navbar navbar-expand-md navbar-category p-0">
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-bars mr-2"></i> CATEGORÍAS
        </a>
        <ul class="{{$params["type"] ?? "dropdown-menu"}}">
          @foreach($categories as $category)
            @if($category->parent_id == 0)
              <li class="nav-item dropdown">
                <a href="{{$category->new_url}}" class="nav-link" data-toggle="dropdown">
                  <img class="white" src="/assets/media/iconos/ic-computadores.png">
                  <img class="dark" src="/assets/media/iconos/ic-computadores.png">
                  {{$category->title}}
                </a>
                <div class="dropdown-menu">
                  @php($firstChildrenLevel = $categories->where("parent_id",$category->id))
                  <h3><a href="{{$category->new_url}}">{{$category->title}}</a></h3>
                  @if($firstChildrenLevel)
                    <ul class="frame-dropdown">
                      @foreach($firstChildrenLevel as $firstChildLevel)
                        <li class="nav-item">
                          <a class="nav-link" href="{{$firstChildLevel->new_url}}">{{$firstChildLevel->title}}</a>
                          @php($secondChildrenLevel = $categories->where("parent_id",$firstChildLevel->id))
                          @if($secondChildrenLevel)
                            <div class="dropdown-submenu">
                              @foreach($secondChildrenLevel as $secondChildLevel)
                                <a href="{{$secondChildLevel->new_url}}">{{$secondChildLevel->title}}</a>
                              @endforeach
                            </div>
                          @endif
                        </li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              </li>
            @endif
          @endforeach
        
        </ul>
      </li>
    </ul>
  </div>
</nav>