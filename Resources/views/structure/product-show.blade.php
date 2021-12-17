@extends('layouts.master')

@section('meta')

  @include('icommerce::structure.meta-social')
  
  @if(isset($schemaScript))
    {!! $schemaScript !!}
  @endif
  
@stop

@section('title')
  {{ $product->name }} | @parent
@stop

