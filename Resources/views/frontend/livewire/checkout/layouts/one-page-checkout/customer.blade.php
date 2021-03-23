
<div class="card card-block  p-3 mb-3">
  <div class="row m-0 pointer" data-toggle="collapse" href="#customerData" role="button" aria-expanded="false"
       aria-controls="customerData">
    <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-2">
      1
    </div>
    <h3 class="d-flex align-items-center my-1 h5">
      {{ trans('icommerce::customer.title') }}
    </h3>
  </div>
  
  <div id="customerData" class="collapse show" role="tablist" aria-multiselectable="true">
    <hr class="my-2"/>
    @guest
    <div class="card mb-0 border-0" >
      <div class="card-header bg-white" role="tab" id="headingRegister"
           style="cursor: pointer;">
        <label class="form-check-label" style="cursor: pointer;">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus"
               fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
          </svg>
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-dash" fill="currentColor"
               xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
          </svg>
          
          {{ trans('icommerce::customer.sub_titles.new_client') }}
        </label>
      </div>
      
      <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingRegister">
        <div class="card-block">
          <div class="card mb-0 border-0">
            
            <div class="card-block my-3">
              <div class="alert alert-danger d-none" id="registerAlert"></div>
              <div class="formUser">
                
                @include('iprofile::frontend.widgets.register',["embedded" => true, "route" => $locale . '.icommerce.store.checkout'])

              </div>
            
            </div>
          
          </div>
        </div>
      </div>
    </div>
    

      <div class="card mb-0 border-0">
        <div class="card-header bg-white" role="tab" id="headingLogin"
             style="cursor: pointer;"
        >
          <label class="form-check-label" style="cursor: pointer;">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus"
                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-dash" fill="currentColor"
                 xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
            </svg>
          
            {{ trans('icommerce::customer.sub_titles.im_client') }}
          </label>
        </div>
        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingLogin">
          <div class="card-block my-3">
            <!-- FORMULARIO -->
            <div class="alert alert-danger d-none" id="loginAlert"></div>
          
            @include('iprofile::frontend.widgets.login',["embedded" => true, "route" => $locale . '.icommerce.store.checkout', "register" => false])
        
          </div>
        </div>
      </div>
    @endguest
    
    @auth
      <div class='card mb-0 border-0'>
        <div class='d-block'>
          @if(Auth::user())
            @php
              $mainImage=\Modules\Iprofile\Entities\Field::where('user_id',Auth::user()->id)->where('name','mainImage')->first();
          
            @endphp
            <div id="imgProfile" class="mb-5 text-center">
              @if($mainImage)
                <img id="mainImage" class="img-fluid rounded-circle bg-white" src="{{ url($mainImage->value) }}" alt="Logo">
              @else
                <img id="mainImage" class="img-fluid rounded-circle bg-white" src="{{url('modules/iprofile/img/default.jpg')}}" alt="Logo">
            
              @endif
            </div>
          @endif
        </div>
        <div class='d-block'>
          {{ trans('icommerce::customer.logged.name') }}<strong> {{$user->present()->fullname}}</strong>
        </div>
        <div class='d-block'>
          {{ trans('icommerce::customer.logged.email') }} <strong>{{$user->email}}</strong>
        </div>
      
        <hr>
      <!-- <div class="d-block text-right">
      <i class="fa fa-id-card-o mr-2"></i>
      <a href="{{url('/account')}}">{{ trans('icommerce::customer.logged.view_profile') }} </a>

    </div>
    <div class="d-block text-right">
    <i class="fa fa-pencil-square-o mr-2"></i>
    <a href="{{url('/account/profile')}}">{{ trans('icommerce::customer.logged.edit_profile') }} </a>
  </div>
  <div class="d-block text-right">
  <a href="{{url('/checkout/logout')}}">{{ trans('icommerce::customer.logged.logout') }} </a>
</div> -->
    
      </div>
    @endauth

 
    </div>
  </div>
