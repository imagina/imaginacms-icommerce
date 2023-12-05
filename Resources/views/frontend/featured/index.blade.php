@extends('layouts.master')

@section('title')
  {{trans("icommerce::common.featured.title")}}  | @parent
@stop

@section('content')

  <div class="page icommerce icommerce-offers-index py-5">


    <div class="container">
      <div class="row">
        <div class="col-12">
          @include('icommerce::frontend.partials.breadcrumb')
        </div>

        <div class="col-lg-12">

          <livewire:isite::items-list
            moduleName="Icommerce"
            itemComponentName="icommerce::product-list-item"
            itemComponentNamespace="Modules\Icommerce\View\Components\ProductListItem"
            entityName="Product"
            :title="$title"
            :params="[
            'filter' => ['category' => $category->id ?? null, 'manufacturers' => isset($manufacturer->id) ? [$manufacturer->id] : [],'featured' => isset($featured) ? $featured : false],
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
