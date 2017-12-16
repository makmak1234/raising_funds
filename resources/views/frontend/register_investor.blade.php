@extends('layouts.app_front')

{{-- @include('backend.register_investor_content') --}}

@component('backend.register_investor_content')
    <input type="hidden" name="front" value="true" >
@endcomponent
