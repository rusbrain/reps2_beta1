@php
    $replays = $general_helper->getLastGosuReplay();
    $rotw_replay = $general_helper->getLastRotwReplay()[0];
    $countries = $general_helper->getCountries();
    $count = 0;
@endphp
@if($replays)
    <div class="widget-wrapper">
        <div class="widget-header">Pеплеи</div>
        <div class="widget-replay row">
            <div class="widget-map col-md-4">
                <a href="{{route('replay.get',['id' => $rotw_replay->id])}}">
                    <img src="{{$rotw_replay->map->url}}" alt="">
                </a>
            </div>
            <div class="widget-replay-desc col-md-8">
                <div class="widget-replay-desc-row">
                    <span class="widget-replay-title"></span>
                    <a class="color-blue"
                        href="{{route('replay.get',['id' => $rotw_replay->id])}}">{{$rotw_replay->title}}</a>
                </div>
                <div class="widget-replay-desc-row">
                    <span class="widget-replay-title">Страны:</span>
                    <span>
                        @if($rotw_replay->first_country_id)
                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$rotw_replay->first_country_id]->code)}}"></span>
                        @else
                            <span>NO</span>
                        @endif
                        VS
                        @if($rotw_replay->second_country_id)
                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$rotw_replay->second_country_id]->code)}}"></span>
                        @else
                            <span>NO</span>
                        @endif
                    </span>
                </div>
                <div class="widget-replay-desc-row">
                    <span class="widget-replay-title">Матчап:</span>
                    <span>{{$rotw_replay->first_race}} vs {{$rotw_replay->second_race}}</span>
                </div>                   
            </div>
        </div>
        @foreach($replays as $replay)
            @if(($count % 2)==0)
                <div class="widget-replay row">
                @endif        
                <div class="widget-replay-sec col-md-6">
                    <div class="widget-replay-desc-row">
                        <span class="widget-replay-title"></span>
                        <a class="color-blue"
                           href="{{route('replay.get',['id' => $replay->id])}}">{{$replay->title}}</a>
                    </div>
                    <div class="widget-replay-desc-row">
                        <span class="widget-replay-title">Страны:</span>
                        <span>
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
                        </span>
                    </div>
                    <div class="widget-replay-desc-row">
                        <span class="widget-replay-title">Матчап:</span>
                        <span>{{$replay->first_race}} vs {{$replay->second_race}}</span>
                    </div>                   
                </div>
                @if(($count % 2)==1)
                </div>
                @endif  
         
            @php $count++; @endphp
        @endforeach
        <div class="justify-content-center display-flex gosu-btn">
            <a href="{{route('replay.gosus')}}" class="btn-empty margin-top-20 " type="submit">
                Другие госу реплеи
            </a>
        </div>
        <div class="justify-content-center display-flex gosu-btn">
            <a href="{{route('replay.users')}}" class="btn-empty margin-top-20 margin-bottom-20" type="submit">
                Пользовательские реплеи
            </a>
        </div>
    </div>
@endif