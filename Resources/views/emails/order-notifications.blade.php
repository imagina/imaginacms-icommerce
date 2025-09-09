@php
  $order = $data["order"];
@endphp

<table>
  @if(!empty($order->first_name) && !empty($order->last_name))
    <tr>
      <td style="font-size:17px; color:#212529;padding-bottom: 25px;text-align:left;">
        <strong> {{$order->first_name}}, {{$order->last_name}}</strong>
      </td>
    </tr>
  @endif
  <tr>
    <td style="font-size:17px; color:#212529;">
      {!! trans("icommerce::orders.messages.statusChanged", ["orderId" => $order->id]) !!}
    </td>
  </tr>
  <tr>
    <td style="font-size:16px; color:#212529;font-weight:700;">
      {!! trans("icommerce::orders.messages.status", ["statusName"=>$order->status->title]) !!}
    </td>
  </tr>
  <tr>
    @php
      $comment = $data["comment"];
    @endphp
    <td>
      @if(!empty($comment) && strlen($comment) > 5)
        <table>
          <tr>
            <th style="color:#212529; text-align: left; font-size: 16px; padding-top: 30px;">
              {{trans("icommerce::orders.table.comment")}}:
            </th>
          </tr>
          <tr>
            <td style="font-size:14px; color:#212529;text-align: left;">
              {{$comment}}
            </td>
          </tr>
        </table>
      @endif
    </td>
  </tr>
  <tr>
    <td style="font-size: 14px; color: #212529; padding-top: 10px;">
      {{trans('icommerce::common.emailMsg.orderurl')}}
    </td>
  </tr>
  <tr>
    <td align="center" style="padding: 20px 0 10px 0;">
      @include('icommerce::emails.button', ["route" =>$order->url,"content" =>trans("icommerce::orders.title.detail order")])
    </td>
  </tr>
</table>
