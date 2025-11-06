@php
  $order = $data["order"]
@endphp

<table role="presentation" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
  <tbody>
    <tr>
      <td align="left">
        <h1 class="title" style="text-align:left;width:80%;font-size:20px;margin:12px auto;">
          {{trans('icommerce::orders.title.single_order_title')}} # {{$order->id}}
        </h1>
      </td>
      {{--
      <td>
        <p><strong>{{trans("icommerce::orders.table.status")}}: {{$order->status->title}}</strong></p>
      </td>
      --}}
    </tr>
    {{--
    <tr>
      <td>
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
          <tr style="text-align:justify;font-size:15px;line-height:22px;color:#212529;">
            <td>
              <p style="font-size:15px;line-height:22px;color:#212529;">
                {{trans('icommerce::common.emailMsg.orderurl')}}
              </p>
            </td>
          </tr>
          <tr>
            <td>
              <table>
                <tr>
                  <td>
                    @include('icommerce::emails.button', ["route" => $order->url, "content" =>
                    trans("icommerce::orders.table.details") . ': #' . $order->id])
                  </td>
                  <td>
                    @include('icommerce::emails.button', ["route" => $order->route(locale() .
                    '.icommerce.store.checkout', ['orderId' => $order->id]), "content" =>
                    trans('icommerce::common.button.buy again')])
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    --}}
    <tr>
      @if(isset($order->organization_id) && !empty($order->organization_id))
        @php
          $organizationRepository = app("Modules\Isite\Repositories\OrganizationRepository");
          $organization = $organizationRepository->getItem($order->organization_id)
        @endphp
        <p>
          {{trans("icommerce::orders.sub-orders.details_1") . ' ' . $order->parent_id . ', ' . trans("icommerce::orders.sub-orders.details_2") . ' ' . $organization->title . '.'}}
        </p>
      @endif
    </tr>

    @include('icommerce::emails.other-infor')

    <tr>
      <td>
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
          <thead>
            <tr>
              <th
                style="background-color:#a5a5a53b;padding:15px 10px 15px;margin:0;font-weight:600;color:#212529;font-size:14px;line-height:1;text-transform:capitalize;text-align:left;width:100%;border-radius:4px 4px 4px 4px;"
                align="left" width="100%">
                {{trans('icommerce::orders.table.product')}}
              </th>
              <th
                style="background-color:#a5a5a53b;padding:15px 10px 15px;margin:0;font-weight:600;color:#212529;font-size:14px;line-height:1;text-transform:capitalize;text-align:left;width:100%;border-radius:4px 4px 4px 4px;"
                align="left" width="100%">
                Sku
              </th>
              {{--
              <th
                style="background-color:#a5a5a53b;padding:15px 10px 15px;margin:0;font-weight:600;color:#212529;font-size:14px;line-height:1;text-transform:capitalize;text-align:left;width:100%;border-radius:4px 4px 4px 4px;"
                align="left" width="100%">
                {{trans('icommerce::orders.table.quantity')}}
              </th>
              <th
                style="background-color:#a5a5a53b;padding:15px 10px 15px;margin:0;font-weight:600;color:#212529;font-size:14px;line-height:1;text-transform:capitalize;text-align:left;width:100%;border-radius:4px 4px 4px 4px;"
                align="left" width="100%">
                {{trans('icommerce::orders.table.unit price')}}
              </th>
              <th
                style="background-color:#a5a5a53b;padding:15px 10px 15px;margin:0;font-weight:600;color:#212529;font-size:14px;line-height:1;text-transform:capitalize;text-align:left;width:100%;border-radius:4px 4px 4px 4px;"
                align="left" width="100%">
                Total
              </th>
              --}}
            </tr>
          </thead>
          <tbody>
            @php
              $currency = isset($order->currency) ? $order->currency : localesymbol($code ?? 'USD')
            @endphp
            @foreach($order->orderItems as $product)
              <tr>
                <th style="color:#212529;font-size: 13px; text-align: left;">
                  <a href="{{$product->product->url}}" style="text-decoration:none;">
                    <h4 style="margin-bottom: 0;color:#212529;">{{$product->title}}</h4>
                  </a>
                  <!--Show item options-->
                  @if($product->orderOption()->count())
                    <div style="font-size: 13px;color:#212529;">({{$product->product_options_label}})</div>
                  @endif
                  @if(isset($product->details))
                    <p style="font-size: 12px; margin-top: 0;color:#212529;">
                      {{$product->details}}
                    </p>
                  @endif
                </th>
                <td style="color:#212529;font-size: 13px; text-align: left;">
                  {{$product->product->sku}}<br>
                </td>
                {{--
                <td style="color:#212529;font-size: 13px; text-align: left;">
                  {{$product->quantity}}
                </td>
                <td style="color:#212529;font-size: 13px; text-align: left;">
                  {{$currency->symbol_left}}{{formatMoney($product->price)}}{{$currency->symbol_right}}
                </td>
                <td style="color:#212529;font-size: 13px; text-align: left;">
                  {{$currency->symbol_left}}{{formatMoney($product->total)}}{{$currency->symbol_right}}
                </td>
                --}}
              </tr>
            @endforeach
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="5">
        <br>
      </td>
    </tr>
    {{--
    <tr>
      <td>
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
          <tr>
            <td colspan="3" style="text-align: right;font-weight:600;color:#212529;">
              {{trans('icommerce::orders.table.subtotal')}}
            </td>
            @php
            $rest = 0;
            if (!empty($order->shipping_amount)) {
            $rest = $order->shipping_amount;
            }
            if (!empty($order->tax_amount)) {
            $rest = $rest + $order->tax_amount;
            }
            $subtotal = $order->total + $order->coupon_total - $rest
            @endphp

            <td colspan="2" style="text-align: right;font-weight:400;color:#212529;">
              {{$order->currency->symbol_left ?? ''}}{{number_format($subtotal, 2)}}{{$order->currency->symbol_right ??
              ''}}
            </td>
          </tr>
          @if($order->coupon_total > 0)
          <tr>
            @php($coupon = $order->coupons->first())
            <td colspan="3" style="text-align: right;font-weight:600;color:#212529;">
              {{trans('icommerce::orders.table.coupon')}}
              ({{$coupon->code}}
              -
              {{$coupon->type_discount ? $coupon->discount . "%" : $currency->symbol_left . ' ' .
              formatMoney($coupon->discount) . ' ' . $currency->symbol_right }}
              )
            </td>
            <td style="text-align: right;font-weight:400;color:#212529;">
              - {{$currency->symbol_left}} {{formatMoney($order->coupon_total) }} {{$currency->symbol_right}}
            </td>
          </tr>
          @endif
          @if(!empty($order->shipping_amount))
          <tr class="shippingTotal">
            <td colspan="3" style="text-align: right;font-weight:600;color:#212529;">
              {{trans('icommerce::orders.table.shipping_method')}}
            </td>
            <td colspan="2" style="text-align: right;font-weight:400;color:#212529;">
              {{$order->shipping_method}}
              {{ $order->shipping_amount > 0 ? ' - ' . number_format($order->shipping_amount, 2) :
              ''}}{{$order->currency->symbol_right ?? ''}}
            </td>
          </tr>
          @endif
          @if(!empty($order->tax_amount) && $order->tax_amount != 0)
          <tr>
            <td colspan="3" style="text-align: right;font-weight:600;color:#212529;">
              {{trans('icommerce::order_summary.tax')}}
            </td>
            <td colspan="2" style="text-align: right;font-weight:400;color:#212529;">
              {{$order->currency->symbol_left ?? ''}}{{number_format($order->tax_amount,
              2)}}{{$order->currency->symbol_right ?? ''}}
            </td>
          </tr>
          @endif
          <tr>
            <td colspan="3" style="text-align: right;font-weight:600;color:#212529;">
              Total
            </td>
            <td colspan="2" style="text-align: right;font-weight:400;color:#212529;">
              {{$order->currency->symbol_left ?? ''}}{{number_format($rder->total, 2)}}{{$order->currency->symbol_right
              ?? ''}}
            </td>
          </tr>
        </table>
      </td>
    </tr>
    --}}


    <tr>
      <td>
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
          <tr>
            @php
              $orderTransformed = collect(new
                \Modules\Icommerce\Transformers\OrderTransformer(\Modules\Icommerce\Entities\Order::with([
                  'customer',
                  'addedBy',
                  'orderItems',
                  'orderHistory',
                  'transactions',
                  'paymentCountry',
                  'shippingCountry',
                  'shippingDepartment',
                  'paymentDepartment'
                ])->where("id", $order->id)->first()))->toArray();
              $informationBlocks = $orderTransformed["informationBlocks"];
              $groupedBlocks = $informationBlocks->chunk(2);
            @endphp
            @foreach($groupedBlocks as $groupBlock)
              <td style="width:50%; vertical-align: top; padding-right: 10px;">
                @foreach($groupBlock as $block)
                  <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                    <thead style="background:transparent;">
                      <h4 style="margin-bottom: 5px; color:#212529;font-size:14px;">{{ $block["title"] }}</h4>
                    </thead>
                    <tbody>
                      @foreach($block["values"] as $item)
                        <tr>
                          <th
                            style="background-color:#a5a5a53b;padding:15px 10px 15px;margin:0;font-weight:600;color:#212529;font-size:14px;line-height:1;text-transform:capitalize;text-align:left;width:100%;border-radius:4px 4px 4px 4px;"
                            align="left" width="100%">
                            {{ $item["label"] ?? "" }}:
                          </th>
                        </tr>
                        <tr>
                          <td
                            style="padding:20px 10px 20px;font-size:14px;font-weight:400;color:#212529;text-align:left;width:100%;"
                            align="left" width="100%">
                            {!! $item["value"] ?? "" !!}
                          </td>
                        </tr>
                        <tr>
                          <td style="padding:10px;border-top:1px solid #ddd;"></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                @endforeach
              </td>
            @endforeach
          </tr>
        </table>
      </td>
    </tr>


    {{--
    <tr>
      <td>
        @include('icommerce::emails.button', [$route = $order->route(locale().'.icommerce.store.checkout',['orderId' =>
        $order->id]), $content => trans('icommerce::common.button.buy again') ])
      </td>
    </tr>
    --}}

  </tbody>
</table>