@inject('general_helper', 'App\Services\GeneralViewHelper')
@php
    $countries = $general_helper->getCountries();
@endphp

@if($tournaments->total() > 0)
    @foreach($tournaments as  $tournament)

        <div class="user-tournament-wrapper">
            <div class="col-md-12 user-tournament-header">
                <div class="tourney_title text-bold">
                    <a href="{{route('tournament.get',['id' => $tournament->id])}}"> {{$tournament->name}} </a>
                </div>
                @if(!empty($tournament->admin_user))
                    <div class="replay-author">
                        @if($tournament->admin_user->avatar)
                            <a href="{{route('user_profile',['id' => $tournament->admin_user->id])}}">
                                <img src="{{$tournament->admin_user->avatar->link}}" class="user-avatar" alt="">
                            </a>
                        @else
                            <a href="{{route('user_profile',['id' => $tournament->admin_user->id])}}"
                               class="logged-user-avatar no-header">A</a>
                        @endif
                        <div>
                            <a href="{{route('user_profile',['id' => $tournament->admin_user->id])}}">{{$tournament->admin_user->name}}</a>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-12 user-tournament-info">
                <div class="tournament-place">
                    Место:
                    <span class="place"> {{$tournament->place}}</span>
                </div>

                <div class="article-creating-date">
                    <img src="{{route('home')}}/images/icons/clock.png" alt="">
                    Начальное время: <br/>
                    {{\Carbon\Carbon::parse($tournament->start_time)->format('H:i d.m.Y')}}
                </div>
                <div class="status">
                    <span>{{App\TourneyList::$status[$tournament->status]}}</span>
                </div>
                <div class="players">
                    <span>{{$tournament->checkin_players_count .'('. $tournament->players_count .')'}}</span>
                </div>
            </div>

        </div><!-- close div /.user-tournament-wrapper -->

    @endforeach
@else
    <div class="user-tournament-wrapper">
        <p class="list-empty">Hет турниров</p>
    </div>
@endif
