@php
    $replays = $general_helper->getLastGosuReplay();
    $countries = $general_helper->getCountries();
@endphp
@if($replays)
    <div class="widget-wrapper">
        <div class="widget-header">Госу реплеи</div>
        @foreach($replays as $replay)
            <div class="widget-replay row">
                <div class="widget-map col-md-4">
                    <a href="{{route('replay.get',['id' => $replay->id])}}">
                        <img src="/{{$replay->map->url}}" alt="">
                    </a>
                </div>
                <div class="widget-replay-desc col-md-8">
                    <div class="widget-replay-desc-row">
                        <span class="widget-replay-title">Название:</span>
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
                    <div class="widget-replay-desc-row">
                        <span class="widget-replay-title">Тип:</span>
                        <span>{{$general_helper->getReplayTypes()[$replay->type_id]->name}}</span>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="justify-content-center display-flex">
            <a href="{{route('replay.gosus')}}" class="btn-empty margin-top-20" type="submit">
                Ещё
            </a>
        </div>
    </div>
@endif