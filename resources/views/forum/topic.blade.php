@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('left_inner_sidebar')
        </div>
        <div class="col-md-9">
            <div class="page-title w-100">{{$topic->title}}</div>
            <div class="topic-info">
                <div class="">
                    <img src="{{$topic->}}" alt="">
                </div>          
            </div>
        </div>
        {{dd($topic)}}
        <div class="topic-comments">{{dd($comments)}}</div>
    </div>
@endsection