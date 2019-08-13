@php  
    $countries = $general_helper->getCountries();
    $upcoming_tournaments = $general_helper->getUpcomingTournaments();
@endphp

<div class="widget-wrapper">
    <div class="widget-header">Предстоящие турниры</div>
    {{-- Rotw Replays --}}
    @foreach($upcoming_tournaments as $tournament)
        <div class="widget-tournament row">
            <div class="widget-map col-lg-4">
                @if(!empty($tournament->logo_link))
                <a href="{{route('tournament.get',['id' => $tournament->id])}}">
                    <img src="{{$tournament->logo_link}}" />
                </a>
                @endif
            </div>
            <div class="widget-tournament-desc col-lg-8">
                <div class="widget-tournament-desc-row">
                    <span class="widget-tournament-title"></span>
                    <a class="color-blue"
                        href="{{route('tournament.get',['id' => $tournament->id])}}">{{$tournament->name}}</a>
                </div>
                <div class="widget-tournament-desc-row">               
                    <span>Place: {{$tournament->place}} </span>
                </div>
            </div>
        </div>
    @endforeach

    <div class="justify-content-center display-flex ">
        <a href="{{route('tournament.all')}}" class="btn-empty margin-top-20 " type="submit">
            Bсе турниры
        </a>
    </div>
</div>

