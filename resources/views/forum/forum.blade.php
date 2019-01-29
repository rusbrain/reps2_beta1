@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('sidebar-left')
    <!-- All Forum Topics -->
    @include('sidebar-widgets.all-forum-sections')
    <!-- END All Forum Topics -->
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/">
                        Главная
                    </a>
                </li>
                <li>
                    <a href="" class="active">/ Форум</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    @if($sections)
        @foreach($sections as $section)
            <div class="content-box">
                <div class="row">
                    <div class="col-md-12 ">
                        <a href="{{route('forum.section.index', ['name' => $section->name])}}" class="forum-section-title">
                            {{$section->title}}
                        </a>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-2 ">
                        <div class="forum-section-info">
                            <span>Темы:</span>
                            <span class="forum-section-topics">{{$section->topics_count}}</span>
                        </div>
                    </div>
                    <div class="col-md-10 padding-top-10">
                        <div class="content-box-topic-desc padding-left-15 margin-bottom-15">
                            <a href="{{route('forum.section.index', ['name' => $section->name])}}">
                                <h2 class="margin-bottom-10">
                                    {!! $section->description !!}
                                </h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- close div /.content-box -->
        @endforeach
    @endif
@endsection

@section('sidebar-right')
    <!--Banners-->
    @include('sidebar-widgets.banner')
    <!-- END Banners -->

    <!-- New Users-->
    @include('sidebar-widgets.new-users')
    <!-- END New Users-->

    <!-- User's Replays-->
    @include('sidebar-widgets.users-replays')
    <!-- END User's Replays-->

    <!-- Gallery -->
    @include('sidebar-widgets.random-gallery')
    <!-- END Gallery -->
@endsection