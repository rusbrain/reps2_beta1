@extends('layouts.site')

@section('header')
    @include('header')
@endsection

@section('navigation')
    @include('navigation')
@endsection

@section('sidebar-left')
    @include('sidebar-left')
@endsection

@section('content')
    <div class="col-md-6 content-center"></div>
@endsection

@section('sidebar-right')
    @include('sidebar-right')
@endsection

@section('footer')
    @include('footer')
@endsection