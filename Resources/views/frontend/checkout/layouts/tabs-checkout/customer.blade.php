@php
  $locale = LaravelLocalization::setLocale() ?: App::getLocale();
@endphp
<div class="card-ckeckout card-customer mb-3">

    <h4 class="ckeckout-subtitle my-1 font-weight-bold">
      {{ trans('icommerce::customer.title') }}
    </h4>
  <hr class="my-2"/>
  
  <div id="customerData" class="row">

    <div class="col-md-6">
      <div class="card mb-0 border-0" v-if="!user">
        <div class="card-header bg-white cursor-pointer" role="tab" id="headingRegister" v-on:click="customerRegisterToggle = !customerRegisterToggle">
          <label class="form-check-label cursor-pointer">
            <svg v-if="!customerRegisterToggle" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus"
                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            <svg v-else width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-dash" fill="currentColor"
                 xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
            </svg>

            {{ trans('icommerce::customer.sub_titles.new_client') }}
          </label>
        </div>

        <div id="check-register" class="collapse show" role="tabpanel" aria-labelledby="headingRegister">
          <div class="card-block">
            <div class="card mb-0 border-0">

              <div class="card-block my-3 checkout-register">
                <div class="alert alert-danger d-none" id="registerAlert"></div>
                <div class="formUser">
                  @includeFirst(['iprofile.widgets.register','iprofile::frontend.widgets.register'],["embedded" => true, "route" => $locale . '.icommerce.checkout'])
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">

      <div class="card mb-0 border-0" v-if="!user">
        <div class="card-header bg-white cursor-pointer" role="tab" id="headingLogin"
             v-on:click="customerLoginToggle = !customerLoginToggle">
          <label class="form-check-label cursor-pointer">
            <svg v-if="!customerLoginToggle" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus"
                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            <svg v-else width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-dash" fill="currentColor"
                 xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
            </svg>

            {{ trans('icommerce::customer.sub_titles.im_client') }}
          </label>
        </div>
        <div id="check-login" class="collapse" role="tabpanel" aria-labelledby="headingLogin">
          <div class="card-block my-3 checkout-login">
            <!-- FORMULARIO -->
            <div class="alert alert-danger d-none" id="loginAlert"></div>

            @includeFirst(['iprofile.widgets.login','iprofile::frontend.widgets.login'],["embedded" => true, "route" => $locale . '.icommerce.checkout', "register" => false])

          </div>
        </div>
      </div>



    </div>
    <div class="col-md-6">
      <div class='card mb-0 border-0' v-if="user">
        <div class='d-block'>
          @if(Auth::user())
            @php
              $mainImage=\Modules\Iprofile\Entities\Field::where('user_id',Auth::user()->id)->where('name','mainImage')->first();

            @endphp
            <div id="imgProfile" class="my-4 text-center">
              @if($mainImage)
                <img id="mainImage" class="img-fluid bg-white" src="{{ url($mainImage->value) }}" alt="Logo">
              @else
                <img id="mainImage" class="img-fluid bg-white" src="{{url('modules/iprofile/img/default.jpg')}}" alt="Logo">

              @endif
            </div>
          @endif
        </div>
        <div class='d-block'>
          {{ trans('icommerce::customer.logged.name') }}<strong> @{{user.fullName}}</strong>
        </div>
        <div class='d-block'>
          {{ trans('icommerce::customer.logged.email') }} <strong>@{{user.email}}</strong>
        </div>

        <hr>

      </div>
    </div>



    

    </div>
  </div>
