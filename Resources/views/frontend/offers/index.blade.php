@extends('layouts.master')

@section('title')
  {{trans("icommerce::common.offers.title")}}  | @parent
@stop

@section('content')

  <div class="page icommerce icommerce-offers-index py-5">

    <div class="container">
      <div class="row">

        {{-- Banner Top--}}
        @includeFirst(["icommerce.partials.index.custom-banner","icommerce::frontend.partials.banner"])

        <div class="col-lg-12">

          <livewire:isite::items-list
            moduleName="Icommerce"
            itemComponentName="icommerce::product-list-item"
            itemComponentNamespace="Modules\Icommerce\View\Components\ProductListItem"
            entityName="Product"
            :title="$title"
            :params="[
            'filter' => ['category' => $category->id ?? null, 'manufacturers' => isset($manufacturer->id) ? [$manufacturer->id] : [],'withDiscount' => isset($withDiscount) ? $withDiscount : false],
            'include' => ['discounts','translations','category','categories','manufacturer','productOptions'],
            'take' => setting('icommerce::product-per-page',null,12)]"
            :configOrderBy="config('asgard.icommerce.config.orderBy')"
            :pagination="config('asgard.icommerce.config.pagination')"
            :configLayoutIndex="config('asgard.icommerce.config.layoutIndex')"
            :responsiveTopContent="['mobile'=>false,'desktop'=>false]"/>

          <hr>

        </div>

      </div>
    </div>

  </div>
@stop
