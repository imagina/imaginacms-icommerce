<a href="{{ route(locale().'.icommerce.store.checkout',['orderId' => $order->id]) }}"
  style="text-decoration: none;
    background-color: {{Setting::get('isite::brandSecondary')}};
    padding: 10px;
    margin: 10px 0;
    color: white;
    display: inline-block;"
  target="_blank">{{trans('icommerce::common.button.buy again')}}</a>