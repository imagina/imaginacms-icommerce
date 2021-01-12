@if(isset($manufacturer->id))
            <div class="text-title">
              <h1 class="text-main text-uppercase mb-4 px-3 text-center">{{$manufacturer->name}}</h1>
            </div>
            
            <div class="card-autor-mini card mb-4 border-0 text-center ml-3">
              @if(isset($manufacturer) && isset($manufacturer->mediaFiles()->tertiaryimage->path))
                <div class="img-circle border rounded-circle mx-auto my-4  lazyload" style="background-image: url('{{$manufacturer->mediaFiles()->tertiaryimage->path}}');
                  background-size: cover;background-repeat: no-repeat;height: 128px;width: 128px;"></div>
              
              @endif
                @if(isset( $manufacturer->options->secondarydescription))
              <div class="card-body">
                <div class="summary">
                  {!! $manufacturer->options->secondarydescription !!}
                </div>
              </div>
                  @endif
            </div>
@endif