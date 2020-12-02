@section('scripts')
    @php
        $currency=localesymbol(isset($code ) ? $code : 'USD');
    @endphp
    <script>

        var icommerce = {
            locales: {!! json_encode(LaravelLocalization::getSupportedLocales()) !!},
            currentLocale: '{{locale()}}',
            currencySymbolLeft:"{{isset($curreny) ? $currency->symbol_left : '$'}}",
            currencySymbolRight:"{{isset($curreny) ? $currency->symbol_right : ''}}",
            curremcyCode:"{{isset($curreny) ?  $currency->code : ''}}",
            curremcyValue:"{{isset($curreny) ? $currency->value : ''}}",
            url:"{{url('/')}}"
        };
    </script>
    @parent

@endsection
