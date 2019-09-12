@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php
    $countries = $general_helper->getCountries();
@endphp

@section('sidebar-left')
    <!-- Upcoming Tournaments -->
    @include('sidebar-widgets.tournaments')

    @include('sidebar-widgets.votes')
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li>
                    <a href="{{route('tournament.all')}}">Tурнир</a>
                </li>
                <li>
                    <a href="" class="active">/ {{$tourney->name}}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title ">
            <div>{{$tourney->name}}</div>
        </div>
        <div class="user-tournament-wrapper">
            <div class="replay-content">
                <div class="col-md-8">
                    <div>
                        <div class="replay-desc-right">Administrator:</div>
                        <div class="replay-desc-left">
                            @if(!empty($tourney->admin_user))
                                <div class="replay-author">
                                    @if($tourney->admin_user->avatar)
                                        <a href="{{route('user_profile',['id' => $tourney->admin_user->id])}}">
                                            <img src="{{$tourney->admin_user->avatar->link}}" class="user-avatar"
                                                 alt="">
                                        </a>
                                    @else
                                        <a href="{{route('user_profile',['id' => $tourney->admin_user->id])}}"
                                           class="logged-user-avatar no-header">A</a>
                                    @endif
                                    <div>
                                        <a href="{{route('user_profile',['id' => $tourney->admin_user->id])}}">{{$tourney->admin_user->name}}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Place:</div>
                        <div class="replay-desc-left">{{$tourney->place}}</div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Registration time:</div>
                        <div class="replay-desc-left">
                            {{\Carbon\Carbon::parse($tourney->created_at)->format('H:i d.m.Y')}}
                        </div>
                    </div>

                    <div>
                        <div class="replay-desc-right">Check-in time:</div>
                        <div class="replay-desc-left">
                            {{\Carbon\Carbon::parse($tourney->checkin_time)->format('H:i d.m.Y')}}
                        </div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Start of Tourney time:</div>
                        <div class="replay-desc-left">
                            {{\Carbon\Carbon::parse($tourney->start_time)->format('H:i d.m.Y')}}
                        </div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Prize Fond:</div>
                        <div class="replay-desc-left">
                            {{\App\TourneyList::getPrizePool($tourney->prize_pool)}}
                        </div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Status of tourney:</div>
                        <div class="replay-desc-left">
                            {{\App\TourneyList::$status[$tourney->status]}}
                        </div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Selection map:</div>
                        <div class="replay-desc-left">
                            {{\App\TourneyList::$map_types[$tourney->map_selecttype]}}
                        </div>
                    </div>
                    <div>
                        <div class="replay-desc-right">Importance tourney:</div>
                        <div class="replay-desc-left">
                            {!! \App\TourneyList::ImpToStars($tourney->id) !!}
                            {{--                            {{$tourney->importance}}--}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    @if($tourney->logo_link)
                        <div><img src='{{$tourney->logo_link}}'></div>
                    @endif
                    <div class="link">
                        @if($tourney->rules_link)
                            <a href='{{$tourney->rules_link}}' target="_blank">Rules/FAQ</a>
                        @endif
                        @if($tourney->vod_link)
                            <a href='{{$tourney->vod_link}}' target="_blank">Vod</a>
                        @endif
                        <a href=" " data-toggle="modal" data-target="#prizemap">Maps/Prize</a>
                    </div>
                    <div class="replay-download">
                        <img src="/images/icons/download-blue.png" alt="">
                        <a href="" class="">Full Replay</a>
                    </div>
                    <div class="replay-download">
                        <img src="/images/icons/download-blue.png" alt="">
                        <a href="" class="">Winner's Pack</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="user-tournament-wrapper">
            <!--Tourney Players -->
            <div class="row tourney_matches">
                <div class="col-md-5">
                    <div class="widget-header">Players</div>
                    @foreach($players as $key => $player)
                        <div class="tourney_ranking">
                            <div class="tourney-desc-right num">{{ $key + 1 }}</div>
                            <div class="tourney-desc-left user">
                                <a href="{{route('user_profile',['id' => $player->user->id])}}">
                                    @if($player->user->country_id)
                                        <span
                                            class="flag-icon flag-icon-{{mb_strtolower($countries[$player->user->country_id]->code)}}"></span>
                                    @else
                                        <span class="flag-icon"></span>
                                    @endif
                                    @if(!empty($player->user->race))
                                        <img
                                            src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons[$player->user->race]}}"
                                            alt="">
                                    @else
                                        <img
                                            src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons['All']}}"
                                            alt="">
                                    @endif
                                    <span class="overflow-hidden">{{$player->user->name}}</span>
                                </a>
                            </div>
                            <div class="tourney-desc-left checkin">{{ ($player->check_in == 1)?'YES':'NO' }}</div>
                            <div class="tourney-desc-left result">
                                @if (in_array($player->place_result, [1,2,3]))
                                    <img src="/images/icons/medal-{{$player->place_result}}.png">
                                @else
                                    {{$player->place_result}}
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Tourney matches -->
                <div class="col-md-7">
                    @php $n = 0; @endphp
                    @foreach($matches['rounds'] as $key => $round)
                        <div
                            class="widget-header">{{ $round }}   {!! App\TourneyMatch::getTourneyRoundMap($tourney->id, $key) !!}</div>
                        @foreach($matches['matches'][$key] as $match)
                            <div class="tourney_match">
                                <div class="tourney-desc-right num">{{ $n + 1 }}</div>
                                <div class="tourney-desc-left user align-right">
                                    @if(!empty($match->player1->user))
                                        @if(!empty($match->player1->user->race))
                                            <img
                                                src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons[$match->player1->user->race]}}"
                                                alt="">
                                        @else
                                            <img
                                                src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons['All']}}"
                                                alt="">
                                        @endif
                                        {{ $match->player1->user->name }}
                                    @else
                                        - Freeslot -
                                    @endif
                                </div>
                                <div class="tourney-desc-right score">{{ $match->player1_score }}</div>
                                <div
                                    class="tourney-desc-right score">{{ $match->player1_score > $match->player2_score ? '>':'<' }}</div>
                                <div class="tourney-desc-right score">{{ $match->player2_score  }}</div>
                                <div class="tourney-desc-right user align-left">
                                    @if(!empty($match->player2->user))
                                        @if(!empty($match->player2->user->race))
                                            <img
                                                src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons[$match->player2->user->race]}}"
                                                alt="">
                                        @else
                                            <img
                                                src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons['All']}}"
                                                alt="">
                                        @endif
                                        {{ $match->player2->user->name }}
                                    @else
                                        - Freeslot -
                                    @endif
                                </div>
                                <div class="tourney-desc-left reps">
                                    @if(!empty($match->file1))
                                        <span><a
                                                href="{{route('tourney.download', ['id' => $match->file1->id])}}">rep1</a></span>
                                    @endif
                                    @if(!empty($match->file2))
                                        <span><a
                                                href="{{route('tourney.download', ['id' => $match->file2->id])}}">rep2</a></span>
                                    @endif
                                    @if(!empty($match->file3))
                                        <span><a
                                                href="{{route('tourney.download', ['id' => $match->file3->id])}}">rep3</a></span>
                                    @endif
                                    @if(!empty($match->file4))
                                        <span><a
                                                href="{{route('tourney.download', ['id' => $match->file4->id])}}">rep4</a></span>
                                    @endif
                                    @if(!empty($match->file5))
                                        <span><a
                                                href="{{route('tourney.download', ['id' => $match->file5->id])}}">rep5</a></span>
                                    @endif
                                    @if(!empty($match->file6))
                                        <span><a
                                                href="{{route('tourney.download', ['id' => $match->file6->id])}}">rep6</a></span>
                                    @endif
                                    @if(!empty($match->file7))
                                        <span><a href="{{route('tourney.download', ['link' => $match->file7->link])}}">rep7</a></span>
                                    @endif
                                </div>
                            </div>
                            @php $n++; @endphp
                        @endforeach

                    @endforeach
                </div>
            </div>
        </div>


    </div><!-- close div /.content-box -->

    <div class="modal fade bd-example-modal-lg prizemap" id="prizemap" tabindex="-1" role="dialog"
         aria-labelledby="prizemap"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="title">Prize/Maps({{$tourney->name}})</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="widget-header">Prizes</div>
                            @foreach($prize as $key => $item)
                                <div class="tourney-match">
                                    <div class="tourney-desc-right">
                                        @if (in_array($key + 1, [1,2,3]))
                                            <img src="/images/icons/medal-{{$key + 1}}.png">
                                        @else
                                            {{$key + 1}}
                                        @endif
                                    </div>
                                    <div class="tourney-desc-left">
                                        {{$item}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-8">
                            <div class="widget-header">Maps</div>
                            <div class="tourney-maps">
                                @foreach($maps as $item)
                                    <div class="tourney-map">
                                        <div class="widget-title">
                                            {{$item->name}}
                                        </div>
                                        <div class="map">
                                            <img src="{{$item->url}}"
                                                 onerror="this.onerror=null;this.src='/images/nominimap.png';">
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('sidebar-right')
    <!--Banners-->
    @include('sidebar-widgets.banner')
    <!-- END Banners -->

    <!-- New Users-->
    @include('sidebar-widgets.new-users')
    <!-- END New Users-->

    <!-- Top Points Users-->
    @include('sidebar-widgets.top-pts-users')
    <!-- END New Users-->

    <!-- Top Rating Users-->
    @include('sidebar-widgets.top-rating-users')
    <!-- END New Users-->


    <!-- User's Replays-->
    @include('sidebar-widgets.users-replays')
    <!-- END User's Replays-->

    <!-- Gallery -->
    @include('sidebar-widgets.random-gallery')
    <!-- END Gallery -->
@endsection
