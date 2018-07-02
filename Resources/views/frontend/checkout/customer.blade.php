<div class="card card-block p-3 ">
<div class="row m-0">
    <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-2">
            1
    </div>
    <h3 class="d-flex align-items-center">
        {{ trans('icommerce::customer.title') }} 
    </h3>
</div>

<hr class="my-2" />
    <div id="customerData" role="tablist" aria-multiselectable="true">
      @if(!$user)
      <div class="card mb-0 border-0">
        <div class="card-header bg-white" role="tab" id="headingOne">
            <label class="form-check-label">
                <input 
                    type="radio" 
                    class="form-check-input" 
                    name="newOldCustomer" 
                    id="newOldCustomer1" 
                    value="1" 
                    data-parent="#customerData" 
                    data-toggle="collapse" 
                    data-target="#collapseOne" 
                    aria-expanded="true" 
                    aria-controls="collapseOne" 
                    checked>
             {{ trans('icommerce::customer.sub_titles.new_client') }} 
          </label>
        </div>

        <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
          <div class="card-block">

                <div id="Register" role="tablist" aria-multiselectable="true">
                  <div class="card mb-0 border-0">
                    <div class="card-header bg-white" role="tab" id="headingTwo_Two">
                          <label class="form-check-label">
                            <input 
                              type="radio" 
                              class="my-2" 
                              name="guestOrCustomer" 
                              id="guestOrCustomer2" 
                              value="2" 
                              data-parent="#Register" 
                              data-toggle="collapse" 
                              data-target="#collapseTwo_Two" 
                              aria-expanded="true" 
                              aria-controls="collapseTwo_Two"
                              checked>
                            {{ trans('icommerce::customer.sub_titles.guest_client') }} 
                        </label>
                    </div>
                    <div id="collapseTwo_Two" class="collapse show" role="tabpanel" aria-labelledby="headingTwo_Two">
                      <div class="card-block my-3 guestUser">
                          <div class="alert alert-danger d-none" id="registerAlert"></div>
                      <div class="form-group row">
                              <div class="col pr-1">
                               <label for="first_name">{{ trans('icommerce::customer.form.first_name') }} </label>
                               <input type="text" class="form-control" id="first_name_guest" name="first_name" v-model="billingData.first_name">

                              </div>
                              <div class="col pl-1">
                               <label for="last_name">{{ trans('icommerce::customer.form.last_name') }} </label>
                               <input type="text" class="form-control" id="last_name_guest" name="last_name" v-model="billingData.last_name">
                              </div>

                          </div>
                          <div class="form-group">
                              <label for="email">{{ trans('icommerce::customer.form.email') }} </label>
                              <input type="email" class="form-control" id="email_guest" name="email" aria-describedby="emailHelp">
                          </div>
                          <div class="form-group">
                              <label for="telephone">{{ trans('icommerce::customer.form.phone') }} </label>
                              <input type="text" class="form-control" id="telephone_guest" name="telephone">
                          </div>

                      </div>
                    </div>
                  </div>
                  <div class="card mb-0 border-0">
                    <div class="card-header bg-white" role="tab" id="headingOne_One">
                        <label class="form-check-label">
                          <input 
                            type="radio" 
                            class="my-2" 
                            name="guestOrCustomer" 
                            id="guestOrCustomer1" 
                            value="1" 
                            data-parent="#Register" 
                            data-toggle="collapse" 
                            data-target="#collapseOne_One" 
                            aria-expanded="true" 
                            aria-controls="collapseOne_One" >
                            {{ trans('icommerce::customer.sub_titles.register_account') }} 
                        </label>
                    </div>
                    <div id="collapseOne_One" class="collapse" role="tabpanel" aria-labelledby="headingOne_One">
                      <div class="card-block my-3">
                        <div class="alert alert-danger d-none" id="registerAlert"></div>
                        <div class="formUser">
                          <div class="form-group row">
                              <div class="col pr-1">
                               <label for="first_name">{{ trans('icommerce::customer.form.first_name') }} </label>
                               <input type="text" class="form-control ignore" id="first_name_register" name="first_name" v-model="billingData.first_name">

                              </div>
                              <div class="col pl-1">
                               <label for="last_name">{{ trans('icommerce::customer.form.last_name') }}</label>
                               <input type="text" class="form-control ignore" id="last_name_register" name="last_name" v-model="billingData.last_name">
                              </div>

                          </div>
                          <div class="form-group">
                              <label for="email">{{ trans('icommerce::customer.form.email') }}</label>
                              <input type="email" class="form-control ignore" id="email_register" name="email" aria-describedby="emailHelp">
                          </div>
                          <div class="form-group">
                              <label for="telephone">{{ trans('icommerce::customer.form.phone') }}</label>
                              <input type="text" class="form-control ignore" id="telephone_register" name="telephone">
                          </div>
                          <div class="passwordUser">
                            <div class="form-group">
                              <label for="password">{{ trans('icommerce::customer.form.paswd') }}</label>
                              <input type="password" class="form-control ignore" id="password_register" name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                              <label for="password2">{{ trans('icommerce::customer.form.paswd_confirm') }}</label>
                              <input type="password" class="form-control ignore" id="password_confirmation_register" name="password_confirmation" placeholder="Password Confirm">
                            </div>
                          </div>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                </div>       
          </div>
        </div>
      </div>
      <div class="card mb-0 border-0">
        <div class="card-header bg-white" role="tab" id="headingTwo">
          <label class="form-check-label">
            <input 
                type="radio" 
                class="form-check-input" 
                name="newOldCustomer" 
                id="newOldCustomer2" 
                value="2" 
                data-parent="#customerData" 
                data-toggle="collapse" 
                data-target="#collapseTwo" 
                aria-expanded="true" 
                aria-controls="collapseTwo">
             {{ trans('icommerce::customer.sub_titles.im_client') }} 
          </label>
        </div>
        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
          <div class="card-block my-3">
                <!-- FORMULARIO -->
                <div class="alert alert-danger d-none" id="loginAlert"></div>
                <div class="container formLogin">
                    @include('partials.notifications')
                    {!! Form::open(['route' => 'login.post']) !!}
                        <!-- email -->
                        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="row">
                                <label for="email">
                                    <i class="fa fa-at"></i>
                                    {{ trans('user::auth.email') }}
                                </label>
                                <input type="email"
                                       class="form-control"
                                       name="email"
                                       id="email_login"
                                       value="{{ old('email')}}"
                                       required>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <!-- pass -->
                        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="row">
                                <label for="">
                                    <i class="fa fa-lock"></i>
                                    {{ trans('user::auth.password') }}
                                </label>
                                <input type="password"
                                       class="form-control"
                                       name="password"
                                       id="password_login"
                                       value="{{ old('password')}}"
                                       required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}

                            </div>
                        </div>
                        <!-- remember account -->
                        <div class="row">
                            <div class="col-6 p-0 text-left">
                                <div class="checkbox icheck">
                                    <label>
                                        <input type="checkbox"
                                               name="remember_me">
                                            {{ trans('user::auth.remember me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 p-0 text-right">
                                <button type="button" class="btn btn-primary btn-block btn-flat loginSubmit">
                                    {{ trans('user::auth.login') }}
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                    <!-- RECUPERAR CONTRASEÑA -->
                    <hr>
                    <div class="col-12">
                        <p class="text-center">
                            <a href="{{ route('account.reset')}}">
                                {{ trans('user::auth.forgot password') }}
                            </a>
                        </p>
                    </div>
                </div>
          </div>
        </div>
      </div>

      @else
        <div class='card mb-0 border-0'>
          <div class='d-block'>
            <strong>{{ trans('icommerce::customer.logged.name') }}  </strong>{{$user->first_name.", ".$user->last_name}}
            <input type='hidden' id="first_name" name="first_name" value="{{$user->first_name}}" v-model="first_name">
            <input type='hidden' id="last_name" name="last_name" value="{{$user->last_name}}" v-model="last_name">
          </div>
          <div class='d-block'>
            <strong>{{ trans('icommerce::customer.logged.email') }}  </strong>{{$user->email}}
            <input type='hidden' id="email" name="email" value="{{$user->email}}">
          </div>
          <hr>
          <div class="d-block text-right">
            <i class="fa fa-id-card-o mr-2"></i>
            <a href="{{url('/account')}}">{{ trans('icommerce::customer.logged.view_profile') }} </a>

          </div>
          <div class="d-block text-right">
            <i class="fa fa-pencil-square-o mr-2"></i>
            <a href="{{url('/account/profile')}}">{{ trans('icommerce::customer.logged.edit_profile') }} </a>
          </div>
          <div class="d-block text-right">
            <a href="{{url('/checkout/logout')}}">{{ trans('icommerce::customer.logged.logout') }} </a>
          </div>
          <input type='hidden' name="user_id" value="{{$user->id}}">
        </div>
      @endif
    </div>
</div>