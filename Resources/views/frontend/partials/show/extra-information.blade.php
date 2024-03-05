<div class="extra-information">

    <div class="infor-measures">
        @php $unit = getUnitClass($product,"length") @endphp
        @if($product->length>0)
            {{trans("icommerce::products.table.length")}}: {{$product->length}}{{$unit}}
        @endif
        @if($product->width>0)
            {{trans("icommerce::products.table.width")}}: {{$product->width}}{{$unit}}
        @endif
        @if($product->height>0)
            {{trans("icommerce::products.table.height")}}: {{$product->height}}{{$unit}}
        @endif
    </div>

    @if($product->weight>0)
        <div class="infor-weight">
            {{trans("icommerce::products.table.weight")}}: {{$product->weight}} {{getUnitClass($product)}}
        </div>
    @endif
    
    @if($product->volume>0)
        <div class="infor-volume">
            {{trans("icommerce::products.table.volume")}}: {{$product->volume}} {{ getUnitClass($product,"volume") }}
        </div>
    @endif

</div>