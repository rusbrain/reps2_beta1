@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries();@endphp

@if($replays->total() > 0)
    @foreach($replays as $item => $replay)
        <div class="user-replay-wrapper">
            <div class="col-md-12 user-replay-header">
                <div class="user-nickname text-bold">
                    <a href="{{route('replay.get',['id' => $replay->id])}}"> {{$replay->title}} </a>
                </div>

                <div class="replay-author">
                    @if($replay->user->avatar)
                        <a href="{{route('user_profile',['id' => $replay->user->id])}}">
                            <img src="{{$replay->user->avatar->link}}" class="user-avatar" alt="">
                        </a>
                    @else
                        <a href="{{route('user_profile',['id' => $replay->user->id])}}"
                           class="logged-user-avatar no-header">A</a>
                    @endif
                    <div>
                        <a href="{{route('user_profile',['id' => $replay->user->id])}}">{{$replay->user->name}}</a>
                    </div>
                </div>

                <div class="info">
                    <a href="{{route('replay.get',['id' => $replay->id])}}#comments">
                        <img src="{{route('home')}}/images/icons/message-square-white.png" alt="">
                        ({{$replay->comments_count}})
                    </a>

                    @if(!is_null($replay->file_id))
                        <a href="{{route('replay.download', ['id' => $replay->id])}}">
                            <img src="{{route('home')}}/images/icons/download.png" alt="">
                            {{$replay->downloaded}}
                        </a>
                    @else
                        <span>Видео реплай</span>
                    @endif
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
                @if(Auth::id() == $replay->user->id)
                    <div class="reputation-button-wrapper">
                        @if(!\App\Replay::isApproved($replay->approved))
                            <div class="error margin-right-10 text-bold">
                                Не подтвержден
                            </div>
                        @endif
                        <div class="user-reputation-qty">
                            <span class="reputation-vote-up bg-blue"></span>
                            <span class="reputation-qty">{{$replay->positive_count}}</span>
                            <span class="reputation-vote-down bg-gray"></span>
                            <span class="reputation-qty">{{$replay->negative_count}}</span>
                        </div>
                        <a href="{{route('replay.get_rating', ['id' => $replay->id])}}" class="btn-blue">
                            рейтинг лист
                        </a>
                    </div>
                @endif
            </div>
        </div><!-- close div /.user-replay-wrapper -->
    @endforeach
@else
    <div class="user-replay-wrapper">
        <p class="list-empty">Список реплеев пуст</p>
    </div>
@endif