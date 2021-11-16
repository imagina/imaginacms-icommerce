@php
  $order = $data["order"];
@endphp

<p><strong> {{$order->first_name}}, {{$order->last_name}}</strong></p>
<p>
  {!! trans("icommerce::orders.messages.statusChanged",["orderId" => $order->id, "statusName" => $order->status->title])!!}
</p>
@php
  $comment = $data["comment"];
@endphp

@if(!empty($comment) && strlen($comment) > 5)
  <h4>{{trans("icommerce::orders.table.comment")}}:</h4>
  <p class="px-3" style="padding: 1rem !important">
    {{$comment}}
  </p>
@endif
<p>
  {{trans('icommerce::common.emailMsg.orderurl')}}
</p>
<p align="center">
  <a href='{{$order->url}}'
     style="text-decoration: none;
       background-color: {{Setting::get('isite::brandSecondary')}};
       padding: 10px;
       margin: 10px 0;
       color: white;"
     target="_blank">{{trans("icommerce::orders.title.detail order")}}</a>
  
</p>
