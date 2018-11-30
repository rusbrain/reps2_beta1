@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('inner_forum_sidebar')
        </div>
        <div class="col-md-9 content-center-main-wrapper">
            <div class="content-center-main">
{{--                {{dd($sections)}}--}}
                @foreach($sections as $section)
                    <div class="forum-section">
                        <a class="w-100 forum-section-title"
                           href="{{route('forum.section.index', ['name' => $section->name])}}">
                            <span>{{$section->title}}</span>
                        </a>
                        <div class="forum-section-topics">
                            Тем: {{$section->topics_count}}
                        </div>
                        <div class="forum-section-description">
                            Описание: {!! $section->description !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection