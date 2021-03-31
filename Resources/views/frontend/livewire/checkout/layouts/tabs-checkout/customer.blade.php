<div class="card-ckeckout card-customer mb-3">
  
  @if($errors->has('userId'))
    <br/>
    <span class="alert alert-danger" role="alert">{{ $errors->first('userId') }}</span>
  @endif
  
  <hr class="my-2"/>
  
  <div id="customerData" class="row">
    @guest
    
      <div class="col-md-6">
      
        <div class="card mb-0 border-0">
          <div class="card-header bg-white cursor-pointer">
            <label class="form-check-label cursor-pointer">
            
              {{ trans('icommerce::customer.sub_titles.im_client') }}
            </label>
          </div>
          <div id="check-login">
            <div class="card-block my-3 checkout-login">
              <!-- FORMULARIO -->
              <div class="alert alert-danger d-none" id="loginAlert"></div>
            
              @includeFirst(['iprofile.widgets.login','iprofile::frontend.widgets.login'],["embedded" => true, "route" => $locale . '.icommerce.store.checkout', "register" => false])
          
            </div>
          </div>
        </div>
    
    
    
      </div>
    
    <div class="col-md-6">
     
      <div class="card mb-0 border-0">
        <div class="card-header bg-white cursor-pointer">
          <label class="form-check-label cursor-pointer">
            {{ trans('icommerce::customer.sub_titles.new_client') }}
          </label>
        </div>

        <div id="check-register">
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

   
    @endguest
    
      @include("icommerce::frontend.livewire.checkout.partials.customer-logged")


    

    </div>
  </div>
