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
            </div>
            <div class="col-md-12 user-tournament-info">
                <div class="tournament-place">
                    Место:
                    <span class="place"> {{$tournament->place}}</span>
                </div>
                
                <div class="article-creating-date">
                    <img src="{{route('home')}}/images/icons/clock.png" alt="">
                    {{\Carbon\Carbon::parse($tournament->start_time)->format('H:i d.m.Y')}}
                </div>
                <div class="status">
                    <span>{{App\TourneyList::$status[$tournament->status]}}</span>
                </div>
                <div class="players">
                    <span>{{$tournament->checkin_players_count .'('. $tournament->players_count .')'}}</span>
                </div>
                
                
                    {{-- <span>{{$tournament->win_player->user->name}}</span> --}}
                {{-- <div>
                    @if($tournament->first_country_id)
                        <span class="flag-icon flag-icon-{{mb_strtolower($countries[$tournament->first_country_id]->code)}}"></span>
                    @else
                        <span>NO</span>
                    @endif
                    VS
                    @if($tournament->second_country_id)
                        <span class="flag-icon flag-icon-{{mb_strtolower($countries[$tournament->second_country_id]->code)}}"></span>
                    @else
                        <span>NO</span>
                    @endif
                </div>
                <div class="race">
                    {{$tournament->first_race}} vs {{$tournament->second_race}}
                </div> --}}
                
                {{-- <div class="user-tournament-map">
                    Карта:
                    <span>{{($tournament->map)?$tournament->map->name:'не указано'}}</span>
                </div>
                <div class="user-tournament-rating">
                    <img src="{{route('home')}}/images/icons/icon_rate_blue.png" alt="">
                    {{$tournament->rating}}
                </div> --}}
            </div>
            
        </div><!-- close div /.user-tournament-wrapper -->
    
    @endforeach
@else
    <div class="user-tournament-wrapper">
        <p class="list-empty">Hет турниров</p>
    </div>
@endif