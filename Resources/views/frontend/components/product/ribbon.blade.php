<div class="productRibbon {{$discountRibbonStyle}} {{$discountPosition}}">

  <!--Ribbon Sold out-->
  @if($product->is_sold_out)
    <div class="ribbonSoldOut ribbonContent">
      <div class="asideRibbon">
        <div class="ribbonLabel">{{trans('icommerce::products.alerts.sold out')}}</div>
      </div>
    </div>

    <!--Ribbon Product new-->
  @elseif($product->is_new)
    <div class="ribbonNewProduct ribbonContent">
      <div class="asideRibbon">
        <div class="ribbonLabel"><b>{{trans('icommerce::products.alerts.new')}}</b></div>
      </div>
    </div>
  @endif
<!--Ribbon discount-->
  @if(isset($discount) && $discount && !$product->is_sold_out)
    <div class="ribbonDiscount ribbonContent">
      <div class="asideRibbon">
        @if($discount && ($discount->criteria == 'fixed'))
          <b><i class="fa fa-tags"></i></b>
        @else
          <b>{{round($discount->discount) ?? 0}}%</b>
        @endif
        <div class="ribbonLabel">{{ trans('icommerce::products.alerts.withDiscount') }}</div>
      </div>
    </div>
  @endif

</div>
