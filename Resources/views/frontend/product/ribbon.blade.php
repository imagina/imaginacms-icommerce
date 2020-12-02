<div id="productRibbon">
  <!--Ribbon Sold out-->
  @if(($product->quantity <= 0) || !$product->stock_status)
    <div id="ribbonSoldOut" class="ribbonContent">
      <div class="asideRibbon">
        <div class="ribbonLabel">AGOTADO</div>
      </div>
    </div>

    <!--Ribbon Product new-->
  @elseif($product->is_new)
    <div id="ribbonNewProduct" class="ribbonContent">
      <div class="asideRibbon">
        <div class="ribbonLabel"><b>NUEVO</b></div>
        <div class="ribbonLabel">PRODUCTO</div>
      </div>
    </div>
  @endif

<!--Ribbon discount-->
  @if($product->discount)
    <div id="ribbonDiscount" class="ribbonContent">
      <div class="asideRibbon">
        @if($product->discount && ($product->discount->criteria == 'fixed'))
          <b><i class="fa fa-tags"></i></b>
        @else
          <b>{{$product->discount->discount ?? 30}}%</b>
        @endif
        <div class="ribbonLabel">DTO.</div>
      </div>
    </div>
  @endif
</div>
