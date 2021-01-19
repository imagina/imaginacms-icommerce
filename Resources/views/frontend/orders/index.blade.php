@extends('iprofile::frontend.layouts.master')

@php
  $currency=localesymbol($code??'USD')
@endphp
@section('profileTitle')
  {{trans("icommerce::orders.title.myOrders")}}
@endsection

@section('profileBreadcrumb')
  <x-isite::breadcrumb>
    <li class="breadcrumb-item active" aria-current="page">{{trans('icommerce::orders.breadcrumb.title')}}</li>
  </x-isite::breadcrumb>
@endsection
@section('profileContent')
  <div class="cart-content">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class=" bg-secondary text-white">
        <tr>
          <th>{{trans('icommerce::orders.table.id')}}</th>
          <th>{{trans('icommerce::orders.table.email')}}</th>
          <th>{{trans('icommerce::orders.table.total')}}</th>
          <th>{{trans('icommerce::orders.table.status')}}</th>
          <th>{{trans('core::core.table.created at')}}</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($orders)): ?>
        <?php foreach ($orders as $order): ?>
        <tr class='clickable-row cursor-pointer' data-href="{{ $order->url }}">
          <td>{{ $order->id }}</td>
          <td>{{ $order->email }}</td>
          <td>{{$currency->symbol_left}} {{formatMoney($order->total) }}{{$currency->symbol_right}} </td>
          <td>{{$order->status->title}}</td>
          <td>{{ $order->created_at }}</td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
    <!--End of Shopping cart items-->
    <hr class="my-4 hr-lg">
    <div class="cart-content-footer">
      <div class="row">
        {{$orders->links()}}
      </div>
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-8 text-right mt-3 mt-md-0">
          <div class="cart-content-totals"></div>
          <!-- Proceed to checkout -->
          <a href="{{\URL::route(\LaravelLocalization::getCurrentLocale() . '.iprofile.account.index')}}" class="btn btn-outline-primary btn-rounded btn-lg my-2">
            {{trans('icommerce::orders.button.Back_to_profile')}}
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  @parent
  <script type="text/javascript">
    $(document).ready(function () {
      $("table .clickable-row").click(function () {
        window.location = $(this).data("href");
      });
    });
  </script>
@stop
