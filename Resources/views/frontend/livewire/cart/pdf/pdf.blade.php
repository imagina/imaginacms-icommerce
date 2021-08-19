<html>
<head>
  <style>
    @page {
      margin: 0cm 0cm;
      font-family: Arial;
    }

    body {
      margin: 3cm 2cm 2cm;
    }

    header .header{
      justify-content: space-between;
    }


    header .img {
      width: 150px;
    }

    header .box {
      height: auto;
      width: 33.3%;
      display: inline-block;
    }



    #content {
      height: auto;
    }

    #contentA {
      background-color: lime;
    }

    #contentB {
      background-color: yellow;
    }

    #contentC {
      background-color: blue;
    }

    #gridFooter {

      margin: 0.25cm 0cm 0cm;
      height: auto;
    }

    #footerA {
      background-color: red;
    }
  </style>
</head>
<body>
<header>
  <div class="header">
    <div class="box">
      <img class="img" src="@setting('isite::'.setting('icommerce::pdfLogoHeader'))" alt="Logotipo">
    </div>
      <div class="box">
        <h1>Cotizacion</h1>
      </div>
      <div class="box">
        <div>
          <strong>Fecha</strong>
          <br>
          <div><?php echo date("Y-m-d")?></div>
          <br>
        </div>
      </div>
  </div>
    <div class="content-site-data">
        <div>
          <br>
          <strong>Telefono :</strong>
          <div>
            <x-isite::contact.phones/>
          </div>
        </div>
        <div>
          <strong>Direccion :</strong>
          <x-isite::contact.addresses/>
        </div>
        <div>
          <strong>Correo electronico :</strong>
          <x-isite::contact.emails/>
        </div>
        <br>
      </div>
  </div>
</header>
<main>
  <div id="content">
    <meta charset="UTF-8">
    <div id="contentA">{!!setting("icommerce::pdfCustomHeader")!!}</div>

    <div id="contentB">
      @if(isset($cart))
        @if($cart->products->count())
          @foreach($cart->products as $cartProduct)
            <div class="item_carting border-bottom pt-4">
              <div class="row item_carting">
                <div class="col-3 pr-0 pb-2">
                  <div class="img-product-cart">
                    <x-media::single-image
                      :alt="$cartProduct->product->name"
                      :title="$cartProduct->product->name"
                      :url="$cartProduct->product->url"
                      :isMedia="true"
                      :mediaFiles="$cartProduct->product->mediaFiles()"/>
                  </div>
                </div>
                <div class="col pr-0">
                  <!-- titulo -->
                  <h6 class="mb-1 __title">
                    <a href="{{$cartProduct->product->url}}" class="text-dark">
                      {{ $cartProduct->product->name }}
                      @if($cartProduct->productOptionValues->count())
                        <br>
                        @foreach($cartProduct->productOptionValues as $productOptionValue)
                          <label>{{$productOptionValue->option->description}}
                            : {{$productOptionValue->optionValue->description}}</label>
                        @endforeach
                      @endif
                    </a>
                  </h6>
                  <!-- valor y cantidad -->
                  <p class="mb-0 text-muted pb-2" style="font-size: 13px">
                    {{trans('icommerce::cart.table.quantity')}}: {{ $cartProduct->quantity }} <br>
                    {{trans('icommerce::cart.table.price_per_unit')}}
                    : {{isset($currency) ? $currency->symbol_left : '$'}}
                    {{formatMoney($cartProduct->product->discount->price ?? $cartProduct->product->price)}} {{isset($currency) ? $currency->symbol_right : ''}}
                  </p>
                </div>
              </div>
            </div>
          @endforeach
        @else
          <h6 class="h-100 text-muted d-flex align-items-center justify-content-center">
            {{trans('icommerce::cart.articles.empty_cart')}}
          </h6>
        @endif
      @endif
    </div>
  </div>
  <div id="contentC">{!!setting("icommerce::pdfCustomProduct")!!}</div>
</main>
<footer>
  <div id="gridFooter">
    <div id="footerA">{!!setting("icommerce::pdfCustomFooter")!!}</div>
  </div>
</footer>
</body>
</html>