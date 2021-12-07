<div id="content_index_commerce">
  
      <!-- store-header -->
      <div class="row pb-4 no-gutters store-header">
        <div class="col-lg-5">
          <div class="card h-100 store-card border-0">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 pb-3 text-center">
                  
                  <div class="store-logo mb-3">
                    <x-media::single-image :mediaFiles="$organization->mediaFiles()" :isMedia="true" />
                  </div>
                  <div class="store-raiting">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-half-o"></i>
                  </div>
                  
                </div>
                <div class="col-md-6 pl-2 pb-3">
                  <div class="store-name">
                    {{$organization->title}}
                  </div>
                  <div class="store-followers">
                    10 seguidores
                  </div>
                  <div class="btn btn-store">
                    <i class="fa fa-heart-o"></i> SEGUIR
                  </div>
                </div>
                <div class="col-12">
                  <div class="store-social">
                    <span class="pr-3">Síguenos!</span> <x-isite::social id="storeSocial"/>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-7">
          <div class="store-slider">
            <x-media::gallery
              :mediaFiles="$organization->mediaFiles()" :zones="['mainimage']"
              :autoplayTimeout="3000"
              :margin="0"
              :autoplay="true"
              :responsive="[0 => ['items' => 1]]"
              :navText="['<i class=\'fa fa-angle-left\'></i>','<i class=\'fa fa fa-angle-right\'></i>']"/>

          </div>
        </div>
      </div>
  
  </div>
