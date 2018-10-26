@extends('layouts.site')

@section('content')
    <div class="">
        <div class="row">
            <div class="page-title w-100">{{$topic->title}}</div>
        </div>
        <div class="topic-info">

        </div>
        {{dd($topic)}}

        <div class="topic-comments">{{dd($comments)}}</div>
    </div>
@endsection