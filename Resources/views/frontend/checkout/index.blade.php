
@extends('layouts.master')

@section('content')


    <livewire:icommerce::checkout :cartId="$cart->id ?? $cartId ?? null" :order="$order ?? null"
                                  :orderId="$order->id ?? $orderId ?? null" :currency="$currency ?? null"
                                  :currencyId="$currency->id ?? $currencyId ?? null" key="checkout" />


@stop