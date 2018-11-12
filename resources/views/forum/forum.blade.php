@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('inner_forum_sidebar')
        </div>
        <div class="col-md-9 content-center-main-wrapper">
            <div class="content-center-main">
                @foreach($sections as $section)
                    <div class="forum-section-row row">
                        <a class="w-100" href="{{route('forum.section.index', ['name' => $section->name])}}">
                            {{$section->title}}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection