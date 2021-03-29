
  <hr>
  <div class="row">
    <div class="col pb-5">
      
      <div class="wizard-checkout">
        <div wire:ignore.self class="wizard-checkout-inner">
          <ul class="nav nav-tabs nav-justified @guest guest @endguest" role="tablist">
            <li role="presentation" class="uno nav-item {{$step == 1 ? 'active' : 'disabled'}}">
              <a class="nav-link" href="#step1" data-toggle="tab" aria-controls="step1" role="tab" wire:click="setStep(1)
                         aria-expanded="true">
              <span class="round-tab">1</span>
              @if($errors->has('userId'))
                <i class="fa fa-exclamation-triangle text-warning d-inline-block" aria-hidden="true"></i>
              @endif <span>Datos Personales</span>
              </a>
            
            </li>
            <li role="presentation" class="dos nav-item {{$step == 2 ? 'active' : 'disabled'}}">
              <a class="nav-link" href="#step2" data-toggle="tab" aria-controls="step2" role="tab" wire:click="setStep(2)"
                 aria-expanded="false">
                <span class="round-tab">2</span>
                @if($errors->has('billingAddress') || $errors->has('paymentMethod'))
                  <i class="fa fa-exclamation-triangle text-warning d-inline-block" aria-hidden="true"></i>
                  @endif <span>Formas de Pago</span>
               
              </a>
            
            </li>
            @if($requireShippingMethod)
              <li role="presentation" class="tres nav-item {{$step == 3 ? 'active' : 'disabled'}}">
                <a class="nav-link" href="#step3" data-toggle="tab" aria-controls="step3" role="tab" wire:click="setStep(3)"
                   aria-expanded="false">
                
                  <span class="round-tab">3</span>
                  @if($errors->has('shippingAddress') || $errors->has('shippingMethod'))
                    <i class="fa fa-exclamation-triangle text-warning d-inline-block" aria-hidden="true"></i>
                  @endif <span>Metodos de Envio</span>
              
                </a>
                
              </li>
            @endif
          </ul>
        </div>
        
        
        <div class="tab-content">
          <div class="tab-pane {{$step == 1 ? 'active' : ''}}" role="tabpanel" id="step1">
            <div class="tab-content-in py-3 mb-4">
              @include('icommerce::frontend.livewire.checkout.layouts.tabs-checkout.customer')
            </div>
            <div class="text-right">
              <a class="btn btn-outline-primary font-weight-bold mb-3"
                 href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
              @auth
                <button type="button" class="btn btn-dark next-step mb-3">
                  <i class="fa fa-share d-block d-md-none"></i> <span class="d-none d-md-block">Siguiente</span>
                </button>
              @endauth
              @guest
                <div class="btn btn-light border font-weight-bold mb-3 start-step">Debe autenticarse para
                  continuar
                </div>
              @endguest
            
            </div>
          </div>
          
          <div class="tab-pane {{$step == 2 ? 'active' : ''}}" role="tabpanel" id="step2">
            <div class="tab-content-in py-3 mb-4">
              <div class="row">
                <div class="col-md-6">
                  @include('icommerce::frontend.livewire.checkout.layouts.tabs-checkout.billing_details')
                </div>
                <div class="col-md-6">
                  @include('icommerce::frontend.livewire.checkout.layouts.tabs-checkout.payment_methods')
                </div>
              </div>
            </div>
            
            
            <div class="text-right">
              <a class="btn btn-outline-primary font-weight-bold mb-3"
                 href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
              
              @auth
                <button type="button" class="btn btn-dark prev-step mb-3">
                  <i class="fa fa-reply d-block d-md-none"></i> <span class="d-none d-md-block">Anterior</span>
                </button>
                <button type="button" class="btn btn-dark next-step mb-3">
                  <i class="fa fa-share d-block d-md-none"></i> <span class="d-none d-md-block">Siguiente</span>
                </button>
              
              @endauth
              
              @guest
                <div class="btn btn-light border font-weight-bold mb-3 start-step">Debe autenticarse para
                  continuar
                </div>
              @endguest
            
            
            </div>
          </div>
          
          <div class="tab-pane {{$step == 3 ? 'active' : ''}}" role="tabpanel" id="step3">
            <div class="tab-content-in py-3 mb-4">
              
              <div class="row">
                <div class="col-md-6">
                  @include('icommerce::frontend.livewire.checkout.layouts.tabs-checkout.shipping_details')
                </div>
                <div class="col-md-6">
                  @include('icommerce::frontend.livewire.checkout.layouts.tabs-checkout.shipping_methods')
                </div>
              </div>
            
            </div>
            
            <div class="text-right">
              <a class="btn btn-outline-primary font-weight-bold mb-3"
                 href="{{url('/')}}">{{ trans('icommerce::checkout.continue_buying') }}</a>
              
              @auth
                <button type="button" class="btn btn-dark prev-step mb-3">
                  <i class="fa fa-reply d-block d-md-none"></i> <span class="d-none d-md-block">Anterior</span>
                </button>
              @endauth
              
              @guest
                <div class="btn btn-light border font-weight-bold mb-3 start-step">Debe autenticarse para
                  continuar
                </div>
              @endguest
            
            </div>
          </div>
          
          <div class="clearfix"></div>
        </div>
      
      
      </div>
    
    </div>
    <div class="col-md-4 pb-5">
      @include('icommerce::frontend.livewire.checkout.partials.order_summary')
    </div>
  </div>


  
  @section('scripts')
    
    @parent
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <!--<script src="https://lifemedical.imaginacolombia.com/modules/icommerce/js/json/index.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/v-mask/dist/v-mask.min.js"></script>
  
    <script type="text/javascript">
      Vue.use(VueMask.VueMaskPlugin);
    
      $(document).ready(function () {
        $('.wizard-checkout .nav-tabs > li a[title]').tooltip();
      
        //Wizard
        $('.wizard-checkout a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var target = $(e.target);
          if (target.parent().hasClass('disabled')) {
            return false;
          }
        });
      
        $(".wizard-checkout .next-step").click(function (e) {
          var active = $('.wizard-checkout .nav-tabs li.active');
          active.next().removeClass('disabled');
          nextTab(active);
        });
        $(".wizard-checkout .prev-step").click(function (e) {
          var active = $('.wizard-checkout .nav-tabs li.active');
          prevTab(active);
        });
        $(".wizard-checkout .start-step").click(function (e) {
          var active = $('.wizard-checkout .nav-tabs li.dos');
          $('.wizard-checkout .nav-tabs li:first-child a').tab('show');
          prevTab(active);
        });
      
      
        $('.wizard-checkout .nav-tabs').on('click', 'li', function () {
          $('.wizard-checkout .nav-tabs li.active').removeClass('active');
          $(this).addClass('active');
        });
      
      });
    
      function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
        console.log(elem);
      }
    
      function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
      }
    </script>


  @stop

