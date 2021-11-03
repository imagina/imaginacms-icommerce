@if(is_module_enabled('Rateable') && setting('icommerce::showRatingProduct'))
    <x-rateable::rating :model="$product"/>
@endif