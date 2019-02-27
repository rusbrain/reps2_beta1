@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries();@endphp

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
        <p class="list-empty">Список реплеев пуст</p>
    </div>
@endif