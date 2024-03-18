@php
  $order = $data["order"];
@endphp
<div>
  <h1 class="title" style="text-align: center;
        width: 80%;
        font-size: 30px;
        margin: 12px auto;">{{trans('icommerce::orders.title.single_order_title')}} # {{$order->id}}</h1>

  <p style="text-align: center; margin: 0;"> {{trans("icommerce::orders.table.status")}}: {{$order->status->title}}</p>

</div>


<p>
  {{trans('icommerce::common.emailMsg.orderurl')}}
</p>
<div>
  <a href='{{$order->url}}'
     style="text-decoration: none;
       background-color: {{Setting::get('isite::brandSecondary')}};
       padding: 10px;
       margin: 10px 0;
       color: white;"
     target="_blank">{{trans("icommerce::orders.table.details")}}: #{{$order->id}}</a>
  <br>

  @if(isset($order->organization_id) && !empty($order->organization_id))
    @php
      $organizationRepository = app("Modules\Isite\Repositories\OrganizationRepository");
      $organization = $organizationRepository->getItem($order->organization_id);
    @endphp
    <p>
      {{trans("icommerce::orders.sub-orders.details_1").' '.$order->parent_id.', '.trans("icommerce::orders.sub-orders.details_2").' '.$organization->title.'.'}}
    </p>
  @endif
</div>
<br>
<div class="table-products" style="margin-bottom: 15px; font-size: 10px">
  <table style="width: 100%;border-collapse: collapse;">
    <thead style="background-color: #eee;">
    <tr>
      <th>{{trans('icommerce::orders.table.product')}}</th>
      <th>Sku</th>
      <th>{{trans('icommerce::orders.table.quantity')}}</th>
      <th>{{trans('icommerce::orders.table.unit price')}}</th>
      <th>Total</th>
    </tr>
    </thead>
    <tbody>

    @php
      $currency = isset($order->currency) ? $order->currency : localesymbol($code??'USD');
    @endphp
    @foreach($order->orderItems as $product)
      <tr class="product-order">
        <td>
          <a href="{{$product->product->url}}">
            <h4>{{$product->title}}</h4>
          </a>

          <!--Show item options-->
          @if($product->orderOption()->count())
            <div class="text-muted" style="font-size: 13px">({{
                  $product->product_options_label
              }})
            </div>
          @endif
        </td>
        <td>
          {{$product->product->sku}}<br>
        </td>
        <td>{{$product->quantity}}</td>
        <td>{{$currency->symbol_left}}{{formatMoney($product->price)}}{{$currency->symbol_right}}</td>
        <td
          class="text-right">{{$currency->symbol_left}}{{formatMoney($product->total)}}{{$currency->symbol_right}}</td>
      </tr>
    @endforeach
    <tr>
      <td colspan="5">
        <br>
      </td>
    </tr>

    <tr class="subtotal">
      <td colspan="3" style="text-align: right">{{trans('icommerce::orders.table.subtotal')}}</td>

      @php
        $rest = 0;
        if(!empty($order->shipping_amount)){
            $rest = $order->shipping_amount;
        }
        if(!empty($order->tax_amount)){
            $rest = $rest + $order->tax_amount;
        }
        $subtotal = $order->total + $order->coupon_total - $rest;
      @endphp

      <td colspan="2"
          style="text-align: right">{{$order->currency->symbol_left ?? ''}}{{number_format($subtotal,2)}}{{$order->currency->symbol_right ?? ''}}</td>
    </tr>
    @if($order->coupon_total > 0)
      <tr class="couponTotal">
        @php($coupon = $order->coupons->first())
        <td colspan="3" class="text-right font-weight-bold">{{trans('icommerce::orders.table.coupon')}}
          ({{$coupon->code}}
          - {{$coupon->type_discount ? $coupon->discount ."%" : $currency->symbol_left.' '.formatMoney($coupon->discount).' '.$currency->symbol_right }}
          )
        </td>
        <td
          class="text-right">
          - {{$currency->symbol_left}}  {{formatMoney($order->coupon_total) }} {{$currency->symbol_right}}</td>
      </tr>
    @endif

    @if(!empty($order->shipping_amount))
      <tr class="shippingTotal">
        <td colspan="3" style="text-align: right">{{trans('icommerce::orders.table.shipping_method')}}</td>
        <td colspan="2"
            style="text-align: right">{{$order->shipping_method}} {{ $order->shipping_amount>0 ? ' - '.number_format($order->shipping_amount,2,".",",") : ''}}{{$order->currency->symbol_right ?? ''}}</td>
      </tr>
    @endif

    @if(!empty($order->tax_amount) && $order->tax_amount!=0)
      <tr class="taxAmount">
        <td colspan="3" style="text-align: right">{{trans('icommerce::order_summary.tax')}}</td>
        <td colspan="2"
            style="text-align: right">{{$order->currency->symbol_left ?? ''}}{{number_format($order->tax_amount,2,".",",")}}{{$order->currency->symbol_right ?? ''}}</td>
      </tr>
    @endif


    <tr class="total">
      <td colspan="3" style="text-align: right">Total</td>
      <td colspan="2"
          style="text-align: right">{{$order->currency->symbol_left ?? ''}}{{number_format($order->total,2,".",",")}}{{$order->currency->symbol_right ?? ''}}</td>
    </tr>
    </tbody>
  </table>
</div>

<?php
$orderTransformed = collect(new \Modules\Icommerce\Transformers\OrderTransformer(\Modules\Icommerce\Entities\Order::with(['customer', 'addedBy', 'orderItems', 'orderHistory', 'transactions',
  'paymentCountry', 'shippingCountry', 'shippingDepartment', 'paymentDepartment'])->where("id", $order->id)->first()))->toArray();
$informationBlocks = $orderTransformed["informationBlocks"];
?>

<div class="user-information">
  <div class="row" style=" width: 100%; display: inline-block;
      margin-bottom: 60px;
      text-align: left;">
    @foreach($informationBlocks as $block)
      <div class="col" style="  width: 43%;
      display: block;
      float: left;
      padding: 0 15px;">
        <h4>{{ $block["title"] }}</h4>
        @foreach($block["values"] as $item)
          <p><b>{{ $item["label"] ?? "" }}:</b> {!! $item["value"] ?? "" !!}</p>
        @endforeach
      </div>
    @endforeach
  </div>
</div>