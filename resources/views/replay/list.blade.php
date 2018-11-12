@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries();@endphp
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('replay.inner_replay_sidebar')
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="page-title w-100">{{$title}}</div>
            </div>
            @foreach($replays as $item => $replay)
                <div class="row page-replay-title">
                    <div class="col-md-12">
                        <div>
                            <span>#{{$item}}</span>
                            <span>
                            <a href="{{route('replay.get',['id' => $replay->id])}}">
                                {{$replay->title}}
                            </a>
                        </span>
                            <span>({{$replay->downloaded}})</span>
                        </div>
                        <a href="{{route('replay.download', ['id' => $replay->id])}}"><i class="fas fa-download"></i> {{$replay->downloaded}}</a>
                    </div>
                </div>
                <div class="row page-replays-subtitle">
                    <div class="col-md-12">
                        <p>
                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$replay->first_country_id]->code)}}"></span> vs
                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$replay->second_country_id]->code)}}"></span>
                        </p>
                        <p><span>{{$replay->first_race}}</span> vs <span>{{$replay->second_race}}</span></p>
                        <p>{{$replay->created_at}}</p>
                        <p>Map: {{$replay->map->name}}</p>
                        <p>Rating:{{$replay->rating}}</p>
                    </div>
                </div>
                <div class="row page-replay-content">
                    <div class=" col-md-12">
                        {{$replay->content}}
                    </div>
                </div>
            @endforeach
            @php $data = $replays @endphp
            <div class="row margin-top-20">
                @include('comment-pagination')
            </div>
        </div>
    </div>
@endsection