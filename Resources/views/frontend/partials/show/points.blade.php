@if(is_module_enabled('Ipoint') && $product->points>0)
  <div class="points py-1 d-flex">
    <label class="font-weight-bold">
      {{trans("icommerce::products.table.points win",['points' => $product->points])}}
    </label>
  </div>
@endif