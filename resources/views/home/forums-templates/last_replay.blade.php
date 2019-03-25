@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries();@endphp
<div class="col-12 home-last-forum-type">Реплеи</div>
<div class="col-md-12 section-title home-page">
    <div class="replay-home-title">
        <a href="{{route('replay.get',['id'=>$replay->id])}}" class="color-blue">{{$replay->title}}</a>
    </div>

    <div class="author-info">
        <a href="{{route('user_profile',['id' => $replay->user->id])}}">
            {{$replay->user->name. ' | '}}
        </a>
        <div>
            <a href="{{route('replay.get',['id'=>$replay->id])}}">
                <img src="images/icons/arrow-right.png" alt="">
            </a>
        </div>
    </div>
</div>
<div class="user-replay-wrapper">
    <div class="col-md-12 user-replay-header">
        <div class="user-nickname text-bold replay-header-content">
            <a href="{{route('replay.get',['id'=>$replay->id])}}">{!! $replay->content !!}</a>
        </div>
        <div class="info">
            <a href="#comments">
                <img src="{{route('home')}}/images/icons/message-square-white.png" alt="">
                {{$replay->comments_count}}
            </a>
            <a href="#">
                <img src="{{route('home')}}/images/icons/clock-white.png" alt="">
                {{\Carbon\Carbon::parse($replay->created_at)->format('H:i d.m.Y')}}
            </a>
        </div>
    </div>
    <div class="replay-content">
        <div class="col-md-8">
            <div>
                <div class="replay-desc-right">Страны:</div>
                <div class="replay-desc-left">
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
            </div>
            <div>
                <div class="replay-desc-right">Матчап:</div>
                <div class="replay-desc-left">{{$replay->first_race}} vs {{$replay->second_race}}</div>
            </div>
            <div>
                <div class="replay-desc-right">Локации:</div>
                <div class="replay-desc-left">
                            <span>
                                @if($replay->first_location && $replay->first_location != 0)
                                    {{$replay->first_location}}
                                @else
                                    no
                                @endif
                            </span>
                    vs
                    <span>
                                @if($replay->second_location && $replay->second_location != 0)
                            {{$replay->second_location}}
                        @else
                            no
                        @endif
                            </span>
                </div>
            </div>
            <div>
                <div class="replay-desc-right">Длительность:</div>
                <div class="replay-desc-left">{{$replay->length??'не указано'}}</div>
            </div>
            <div>
                <div class="replay-desc-right">Чемпионат:</div>
                <div class="replay-desc-left">{{$replay->championship??'не указано'}}</div>
            </div>
            <div>
                <div class="replay-desc-right">Версия:</div>
                <div class="replay-desc-left">{{$replay->game_version->version??'не указано'}}</div>
            </div>
            <div>
                <div class="replay-desc-right">Рейтинг при создании:</div>
                <div class="replay-desc-left">{{$replay->creating_rate??'0'}}</div>
            </div>
            <div>
                <div class="replay-desc-right">Рейтинг:</div>
                <div class="replay-desc-left">{{$replay->rating??'0'}}</div>
            </div>
            <div>
                <div class="replay-desc-right">Юзер Рейтинг:</div>
                <div class="replay-desc-left">({{$replay->user_rating??'0'}})</div>
            </div>
            @if(Auth::id() == $replay->user->id)
                <a href="{{route('replay.edit', ['id' => $replay->id])}}" class="user-theme-edit">
                    <img src="{{route('home')}}/images/icons/svg/edit_icon.svg" alt="">
                    <span>Редактировать</span>
                </a>
            @endif
        </div>
        <div class="col-md-4 position-relative">
            <div>{{$replay->map->name??'не указано'}}</div>
            @if(isset($replay->map->url))
                <img src="{{route('home')}}/{{$replay->map->url}}" class="replay-map"
                     alt="{{$replay->map->name??'не указано'}}">
            @else
                <div class="replay-map-empty">
                    Не указано
                </div>
            @endif
            <div class="replay-download">
                @if(!is_null($replay->file_id))
                    <img src="{{route('home')}}/images/icons/download-blue.png" alt="">
                    <a href="{{route('replay.download', ['id' => $replay->id])}}" class="">Скачать</a>
                    <span>({{$replay->downloaded??0}})</span>
                @else
                    <a href="{{route('replay.get',['id'=>$replay->id])}}">
                        Видео реплай
                    </a>
                @endif
            </div>
        </div>
    </div>
</div><!-- close div /.user-replay-wrapper -->