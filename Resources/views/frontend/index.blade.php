@extends('layouts.master')

{{-- Meta --}}
@includeFirst(['icommerce.index.meta','icommerce::frontend.index.meta'])


@section('content')

{{-- Preloader --}}
@includeFirst(['icommerce.partials.preloader','icommerce::frontend.partials.preloader'])
    

<div id="content_index_commerce" class="page mt-3">

    {{-- TOP PAGE (breadcrumb, orderby, etc --}}
    @includeFirst(['icommerce.index.top-page','icommerce::frontend.index.top-page'])
    
    {{-- CONTENT (Siderbar,Products GRID --}}
    @includeFirst(['icommerce.index.content','icommerce::frontend.index.content'])

</div>

@stop

{{-- VUEJS SCRIPTS--}}
@includeFirst(['icommerce.index.scripts','icommerce::frontend.index.scripts'])