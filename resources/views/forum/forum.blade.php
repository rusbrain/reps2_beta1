@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@php $section_icons = $general_helper->getSectionIcons(); @endphp

@section('sidebar-left')
    <!-- All Forum Topics -->
    @include('sidebar-widgets.general-forum-sections')
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
                    <div class="col-md-12">
                        <div class="forum-section-title">
                            <a href="{{route('forum.section.index', ['name' => $section->name])}}" class="">
                                <img src="{{route('home').$section_icons[$section->id]}}" class="margin-right-15" alt="">
                                {{$section->title}}
                            </a>
                            <div class="forum-section-info">
                                <div>
                                    <span>Темы:</span>
                                    <span class="forum-section-topics">{{$section->topics_count}}</span>
                                </div>
                                <div>
                                    <span>Комментариев:</span>
                                    <span class="forum-section-topics">{{$section->comment_count}}</span>
                                </div>
                                <div>
                                    <a href="{{route('forum.section.index', ['name' => $section->name])}}">
                                        <img src="/images/icons/arrow-right-white.png" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-12 padding-top-10">
                        <div class="content-box-topic-desc margin-bottom-15">
                            <p class="forum-section-link">
                                {!! $section->description !!}
                            </p>
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