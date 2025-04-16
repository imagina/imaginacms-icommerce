@php
  if($addToCartWithQuantity || $positionButtonBuyWhatsApp) {
    $classButton = $buttonsLayout . ' ' . $buttonsPosition .' '. $alignButtonBuyWhatsApp;
  } else {
    $classButton = 'd-inline-block';
  }
@endphp
@if($showButtonBuyWhatsApp)
  <div class="buttons {{$classButton ?? ''}} buttons-whatsapp">
    <x-isite::button :style="$buttonsLayout" buttonClasses="buy-whatsapp button-small {{$classButtonBuyWhatsApp}}"
                     :href='$textHreftButtonBuyWhatsApp'
                     :withIcon="true"
                     :color="$withStyleButtonBuyWhatsApp ? 'primary':'green'"
                     iconClass="fa fa-whatsapp"
                     :withLabel="$withTextButtonBuyWhatsApp"
                     :sizeLabel="$fontSizeButtonBuyWhatsApp"
                     :label="$labelBuyWhatsApp ?? trans('icommerce::products.button.labelBuyWhatsApp')"
                     target="_blank"

    />
  </div>
  @once
    <style>
      :root {
        --color-by-whatsapp: {{$colorButtonBuyWhatsApp}};
      }
      .buttons-whatsapp .buy-whatsapp {
        & i {
          font-size: {{$fontSizeButtonBuyWhatsApp}}px !important;
        }
      }
      .buttons-whatsapp .button-green {
        color: #ffffff;
        border-width: 1px;
        border-style: solid;
        border-color: var(--color-by-whatsapp);
        background-color:  var(--color-by-whatsapp);
      &:hover {
         background-color: color-mix(in srgb, var(--color-by-whatsapp) 95%, black);
         color: #ffffff;
       }
      }

    </style>
  @endonce
@endif