@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries();@endphp

@section('sidebar-left')
    <!-- All Forum Topics -->
    @include('sidebar-widgets.search-replay-form')
    <!-- END All Forum Topics -->
@endsection

{{--{{dd($replays)}}--}}
@section('content')

    <!-- Breadcrumbs -->
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/">Главная</a>
                </li>
                <li>
                    <a href="" class="active">/ {!! $title !!}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>{!! $title !!}</div>
        </div>
        @if($replays->total() > 0)
            @foreach($replays as $item => $replay)
                <div class="user-replay-wrapper">
                    <div class="col-md-12 user-replay-header">
                        <div class="user-nickname text-bold">
                            <a href="{{route('replay.get',['id' => $replay->id])}}"> {{$replay->title}} </a>
                        </div>
                        <div class="info">
                            <a href="{{route('replay.get',['id' => $replay->id])}}#comments">
                                <img src="{{route('home')}}/images/icons/message-square-white.png" alt="">
                                ({{$replay->comments_count}})
                            </a>
                            <a href="{{route('replay.download', ['id' => $replay->id])}}">
                                <img src="{{route('home')}}/images/icons/download.png" alt="">
                                {{$replay->downloaded}}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 user-replay-info">
                        <div>
                            @if($replay->first_country_id)
                                <span class="flag-icon flag-icon-{{mb_strtolower($countries[$replay->first_country_id]->code)}}"></span>
                            @else
                                <span>NO</span>
                            @endif
                            VS
                            @if($replay->second_country_id)
                                <span class="flag-icon flag-icon-{{mb_strtolower($countries[$replay->second_country_id]->code)}}"></span>
                            @else
                                <span>NO</span>
                            @endif
                        </div>
                        <div class="race">
                            {{$replay->first_race}} vs {{$replay->second_race}}
                        </div>
                        <div class="article-creating-date">
                            <img src="{{route('home')}}/images/icons/clock.png" alt="">
                            {{$replay->created_at}}
                        </div>
                        <div class="user-replay-map">
                            Карта:
                            <span>{{$replay->map->name??'не указано'}}</span>
                        </div>
                        <div class="user-replay-rating">
                            <img src="{{route('home')}}/images/icons/icon_rate_blue.png" alt="">
                            {{$replay->rating}}
                        </div>
                    </div>
                    <div class="col-md-12 user-replay-content-wrapper">
                        <div class="user-replay-content">
                            {!! $replay->content !!}
                        </div>
                    </div>
                </div><!-- close div /.user-replay-wrapper -->
            @endforeach
        @else
            <div class="user-replay-wrapper">
                <p>Cписок реплеев пуст</p>
            </div>
        @endif
    </div><!-- close div /.content-box -->

    <!--  PAGINATION -->
    @php  $data = $replays @endphp
    @include('pagination')
    <!-- END  PAGINATION -->
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