
@extends('layouts.master')

@section('content')
    
    <x-isite::breadcrumb>
        @isset($organization->id)
            <li class="breadcrumb-item text-capitalize store-index" aria-current="page">
                <a
                  href="{{tenant_route(request()->getHost(), \LaravelLocalization::getCurrentLocale() . '.icommerce.store.index')}}">
                    {{ trans('icommerce::routes.store.index.index') }}
                    
                    {{$organization->title}}
                
                </a>
            </li>
        @endisset
        <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
    </x-isite::breadcrumb>

    <livewire:icommerce::checkout :cartId="$cart->id ?? $cartId ?? null" :order="$order ?? null"
                                  :orderId="$order->id ?? $orderId ?? null" :currency="$currency ?? null"
                                  :currencyId="$currency->id ?? $currencyId ?? null" key="checkout" />

@include('icommerce::frontend.checkout.style')
@stop