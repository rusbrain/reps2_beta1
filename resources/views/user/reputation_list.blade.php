@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries();@endphp

@if($list && count($list)>0)
    @foreach($list as $item)
        <div class="user-reputation-vote-row">
            <div class="user-reputation-vote-info">
                <div>
                    @if($item->sender)
                    <a href="{{route('user_profile',['id' => $item->sender->id])}}">{{$item->sender->name}}</a>
                    {{-- <div class="">                        --}}
                        @if($item->sender->country_id)
                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$item->sender->country_id]->code)}}"></span>
                        @else
                            <span class="flag-icon"></span>
                        @endif
    
                        @if($item->sender->race)
                            <img class="margin-left-5" src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons[$item->sender->race]}}" alt="">
                        @else
                            <img class="margin-left-5" src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons['All']}}" alt="">
                        @endif                        
                    {{-- </div> --}}

                    <span> {{$item->sender->points . 'pts'}} </span>
                    <span>|</span>
                    <a href="{{route('user.get_rating', ['id' => $item->sender->id])}}">{{$item->sender->rating}}
                        кг</a>
                    @endif
                </div>
                <div>
                    <img src="{{route('home')}}/images/icons/eye.png" alt="">
                    <span>{{$item->created_at}}</span>
                </div>
            </div>
            <div class="user-reputation-vote-content">
                <div class="col-md-11">
                    @if($item->sender && \App\IgnoreUser::i_ignore($item->sender->id))
                        <div class="padding-15 text-center">Комментарий скрыт</div>
                    @else
                        <div>{!! $general_helper->oldContentFilter($item->comment) !!}</div>
                    @endif
                </div>
                <div class="col-md-1">
                    @if($item->rating == 1)
                        <span class="reputation-vote-up"></span>
                    @else
                        <span class="reputation-vote-down"></span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="padding-15 text-center">История репутации пуста</div>
@endif
