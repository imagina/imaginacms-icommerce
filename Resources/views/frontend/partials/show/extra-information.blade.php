<div class="extra-information">

    <div class="infor-measures">
        @php $unit = getUnitClass($product,"length"); @endphp
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

    @if(isset($product->mediaFiles()->sizereference->id) && !is_null($product->mediaFiles()->sizereference->id))
        <div class="col-12 py-3">
            <a class="button-size-guide text-primary py-3 h4" target="_blank"
               href="{{$product->mediaFiles()->sizereference->path}}">
                    <span class="border rounded">
                     <i class="fa-solid fa-ruler-horizontal"></i>
                    </span>
                {{trans('icommerce::products.sizeGuide')}}
            </a>
        </div>
    @endif

</div>