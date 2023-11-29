@extends('layouts.master')
@section('content')
    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="{{url('/admin')}}" frameborder="0" allowfullscreen></iframe>
    </div>
@stop

@section('footer')
@stop
@section('shortcuts')
@stop

@push('js-stack')
@endpush
