@extends('layouts.user')

@section("content")
<nav-component></nav-component>
<view-component :name="{{ json_encode($name) }}"></view-component>

@endsection
