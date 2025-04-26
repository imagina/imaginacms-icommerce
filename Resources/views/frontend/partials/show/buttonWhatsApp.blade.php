@php
  $numberBuyWhatsApp = json_decode(setting(setting('icommerce::productSelectSettingButtonBuyWhatsApp', 'isite::whatsapp1')))
@endphp
@if(!empty(trim($numberBuyWhatsApp->number)) && setting('icommerce::productShowButtonBuyWhatsApp',null,false))
  <div class="button-show-whatsApp d-inline-flex align-items-center p-1">
    <!-- BUTTON WHATSAPP -->
    @php
      $textBuyWhatsApp = setting('icommerce::productShowButtonBuyWhatsAppTextMessage').' *'. $product->name. '* ' . url()->full()
    @endphp
    <a class="btn buy-whatsapp" aria-label="buy whatsapp"
       href="https://wa.me/{{$numberBuyWhatsApp->callingCode . $numberBuyWhatsApp->number}}?text={{ urlencode($textBuyWhatsApp) }}"
       target="_blank">
      <i class="fa fa-whatsapp"></i>
      <span>{{ trans('icommerce::products.button.buyShowWhatsApp') }}</span>
    </a>
  </div>
@endif

<style>
  .button-show-whatsApp .buy-whatsapp {
    background-color: var(--color-by-whatsapp, #25D366);
    color: #ffffff;
    &:hover {
      background-color: color-mix(in srgb, var(--color-by-whatsapp, #25D366) 95%, black);
    }
  }
</style>
