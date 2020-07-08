<div class="card card-block  p-3 mb-3">
    <div class="row m-0 pointer" data-toggle="collapse" href="#customerData" role="button" aria-expanded="false" aria-controls="customerData">
        <div class="rounded-circle bg-primary text-white mr-3 d-flex align-items-center px-3 py-2">
            1
        </div>
        <h3 class="d-flex align-items-center my-1">
            {{ trans('icommerce::customer.title') }}
        </h3>
    </div>

    <div id="customerData" class="collapse show" role="tablist" aria-multiselectable="true">
        <hr class="my-2"/>
        <div class="card mb-0 border-0" v-if="!user">
            <div class="card-header bg-white" role="tab" id="headingOne">
                <label class="form-check-label">
                    <input
                            type="radio"
                            class="form-check-input"
                            name="newOldCustomer"
                            id="newOldCustomer1"
                            value="1"
                            v-model="customerType"
                            data-parent="#customerData"
                            data-toggle="collapse"
                            data-target="#collapseOne"
                            aria-expanded="true"
                            aria-controls="collapseOne">
                    {{ trans('icommerce::customer.sub_titles.new_client') }}
                </label>
            </div>

            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-block">
                    <div class="card mb-0 border-0">

                        <div class="card-block my-3">
                            <div class="alert alert-danger d-none" id="registerAlert"></div>
                            <div class="formUser">
                                <div class="form-group row">
                                    <div class="col pr-1">
                                        <label for="first_name">{{ trans('icommerce::customer.form.first_name') }} </label>
                                        <input type="text" class="form-control ignore" id="first_name_register"
                                               name="first_name" v-model="newUser.name">

                                    </div>
                                    <div class="col pl-1">
                                        <label for="last_name">{{ trans('icommerce::customer.form.last_name') }}</label>
                                        <input type="text" class="form-control ignore" id="last_name_register"
                                               name="last_name" v-model="newUser.lastName">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="email">{{ trans('icommerce::customer.form.email') }}</label>
                                    <input type="email" class="form-control ignore" id="email_register" name="email"
                                           v-model="newUser.email" aria-describedby="emailHelp">
                                </div>
                                <div class="form-group">
                                    <label for="telephone">{{ trans('icommerce::customer.form.phone') }}</label>
                                    <input type="text" class="form-control ignore" id="telephone_register"
                                           v-model="newUser.owner_cellphone" name="telephone">
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ trans('icommerce::customer.form.paswd') }}</label>
                                    <input type="password" class="form-control ignore" id="password_register"
                                           v-model="newUser.password" name="password" placeholder="Clave">
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ trans('icommerce::customer.form.paswd') }}</label>
                                    <input type="password" class="form-control ignore" id="password_confirmation_register"
                                           v-model="newUser.password_confirmation" name="password_confirmation" placeholder="Confirmación de clave">
                                </div>
                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-primary" @click="registerUser" name="button">
                                    Registrar</button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-0 border-0" v-if="!user">
            <div class="card-header bg-white" role="tab" id="headingTwo">
                <label class="form-check-label">
                    <input
                            type="radio"
                            class="form-check-input"
                            name="newOldCustomer"
                            id="newOldCustomer2"
                            value="2"
                            v-model="customerType"
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
                                       v-model="email"
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
                                       v-model="password"
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
                                <button type="button" @click="loginUser" class="
                                btn btn-primary btn-block btn-flat loginSubmit">
                                {{ trans('user::auth.login') }}
                                </button>
                            </div>
                        </div>
                        <!-- RECUPERAR CONTRASEÑA -->
                        {{--      <hr>
                                    <div class="col-12">
                                      <p class="text-center">
                                        <a href="{{ route('account.reset')}}">
                                          {{ trans('user::auth.forgot password') }}
                                        </a>
                                      </p>
                                    </div>
                                    --}}
                    </div>
                </div>
            </div>
        </div>

        <div class='card mb-0 border-0' v-if="user">
            <div class='d-block'>
                <strong>{{ trans('icommerce::customer.logged.name') }} @{{user.fullName}}</strong>
            </div>
            <div class='d-block'>
                <strong>{{ trans('icommerce::customer.logged.email') }} @{{user.email}}</strong>
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
    </div>
</div>
