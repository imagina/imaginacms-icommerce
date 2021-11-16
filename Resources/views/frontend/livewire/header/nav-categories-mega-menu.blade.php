 <div>
  <div class="col-auto">
  <nav class="navbar navbar-expand-md navbar-category p-0">
    <div id="navbarCollapse" class="collapse navbar-collapse">
      <ul id="navbarUl" class="navbar-nav">
        <li id="liNavItem" class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
             >
            <i class="fa fa-bars mr-2"></i> CATEGOR&Iacute;AS
          </a>
          <ul id="ulNavItem" class="{{$params["type"] ?? "dropdown-menu"}}">
            @foreach($categories as $category)
              @php($firstChildrenLevel = count($category->children) ? $category->children  : null)
              <li class="nav-item {{$firstChildrenLevel ? 'dropdown' : ''}}">
                  <a href="{{$category->url}}" class="nav-link" data-toggle="{{$firstChildrenLevel ? 'dropdown' : ''}}"
                     onclick="window.location.href = '{{$category->url}}'">
                  @php($mediaFiles = $category->mediaFiles())

                  @if(isset($mediaFiles->tertiaryimage->path) && !strpos($mediaFiles->tertiaryimage->path,"default.jpg"))
                    <img class="filter" src="{{$mediaFiles->tertiaryimage->path}}">
                  @endif
                  {{$category->title}}
                </a>
                @if($firstChildrenLevel)
                  <div class="dropdown-menu">

                  <h3><a href="{{$category->url}}">{{$category->title}}</a></h3>
                  @if($firstChildrenLevel)
                    <ul class="frame-dropdown">
                      @foreach($firstChildrenLevel as $firstChildLevel)
                        <li class="nav-item">
                          <a class="nav-link" href="{{$firstChildLevel->url}}">{{$firstChildLevel->title}}</a>
                          @php($secondChildrenLevel = $firstChildLevel->children ?? null)
                          @if($secondChildrenLevel)
                            <div class="dropdown-submenu">
                              @foreach($secondChildrenLevel as $secondChildLevel)
                                <a href="{{$secondChildLevel->url}}">{{$secondChildLevel->title}}</a>
                              @endforeach
                            </div>
                          @endif
                        </li>
                      @endforeach
                    </ul>
                  @endif
                </div>
                @endif
              </li>

            @endforeach

          </ul>
        </li>
      </ul>
    </div>
  </nav>
   </div>
   <div class="modal modal-menu fade" id="menuModal" tabindex="-1" role="dialog"
        aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header bg-primary rounded-0">
           <img src="@setting('isite::logo1')" class="img-fluid mx-auto py-2"/>
           <button  type="button" class="close my-0" data-dismiss="modal" aria-label="Close">
             <i class="fa fa-times-circle text-white"></i>
           </button>
         </div>
         <div class="modal-body">

           <nav class="navbar  navbar-movil  p-0">

             <div class="collapse navbar-collapse show " id="modalBody">
          </div>
        </nav>
      </div>
    </div>
  </div>
</div>
 </div>
@section('scripts-owl')
  @parent
  <script>

    $(document).ready(function () {

      function divtomodal() {

        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        if (width <= 992) {
          console.log('xs');
          $('#ulNavItem').addClass("navbar-nav");
          $('#ulNavItem').removeClass("dropdown-menu");
          $('#modalBody').append($("#ulNavItem"));
        } else {
          console.log('not-xs');
          $('#ulNavItem').removeClass("navbar-nav");
          $('#ulNavItem').addClass("dropdown-menu");
          $('#liNavItem').append($("#ulNavItem"));
        }

      }

      $(window).resize(divtomodal);

      var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
      if(width<=992)
        divtomodal()
    });
  </script>

@stop
