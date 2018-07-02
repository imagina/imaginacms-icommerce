@php
    $categories=$category->children;
@endphp
<h6 class="mb-3 text-secondary">
    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
    FILTER
</h6>

<div class="card border-0 card-items mb-3">
    <div class="card-header text-uppercase bg-primary  py-2 px-3 text-white">
        SUB CATEGORIES
    </div>
    <ul class="list-group list-group-flush">

        @foreach($categories as $index =>$cat)
            <li class="list-group-item border-0 d-flex  align-items-center">
                <a id="cat_{{$cat->id}}"
                   href="{{$cat->url}}" >
                    {{$cat->title}}
                </a>
            </li>
        @endforeach
    </ul>
</div>

@include('icommerce::frontend.widgets.manufacturers')

<!--
    <div class="card border-0 card-items mb-3">
        <div class="card-header text-uppercase bg-primary  py-2 px-3 text-white">
            MANUFACTURER
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item border-0 d-flex  align-items-center">
                <a href="{{url('/')}}">CMC Rescue</a>
            </li>
            <li class="list-group-item border-0 d-flex  align-items-center">
                <a href="{{url('/')}}">Emergency Products + Research</a>
            </li>
            <li class="list-group-item border-0 d-flex  align-items-center">
                <a href="{{url('/')}}">FERNO WASHINGTON</a>
            </li>
            <li class="list-group-item border-0 d-flex  align-items-center">
                <a href="{{url('/')}}">Junkin Safety Appliance</a>
            </li>
            <li class="list-group-item border-0 d-flex  align-items-center">
                <a href="{{url('/')}}">Company</a>
            </li>
            <li class="list-group-item border-0 d-flex  align-items-center">
                <a href="{{url('/')}}">Life support Products Inc</a>
            </li>
            <li class="list-group-item border-0 d-flex  align-items-center">
                <a href="{{url('/')}}">Morrison Medical</a>
            </li>
            <li class="list-group-item border-0 d-flex  align-items-center">
                <a href="{{url('/')}}">R and B Fabrications</a>
            </li>
            <li class="list-group-item border-0 d-flex  align-items-center">
                <a href="{{url('/')}}">Skedco</a>
            </li>
        </ul>
    </div>
    -->
@include('icommerce::frontend.widgets.range_price')

@include('icommerce::frontend.widgets.wishlist')
<h6 class="pt-4 mb-3 text-secondary">
    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
    RELATED PAGE
</h6>
<p class="m-0 pl-2 text-justify">Lorem ipsum dolor sit amet1</p>
<p class="m-0 pl-2 text-justify">Lorem ipsum dolor sit amet1</p>

@section('scripts')
    @parent

    @stack('field_scripts')
@stop