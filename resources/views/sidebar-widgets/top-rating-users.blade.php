@php
    $top_rating_users = $general_helper->getTopRatingUsers();
    $countries = $general_helper->getCountries();
@endphp
@if(!empty($top_rating_users))
    <div class="widget-wrapper">
        <div class="widget-header">Top кг пользователи</div>
        @foreach($top_rating_users as $top_rating_user)
            <div class="widget-new-user">
                <a href="{{route('user_profile',['id'=>$top_rating_user->id])}}">
                    <span class="color-blue">#{{$top_rating_user->id}}</span>
                    @if($top_rating_user->country_id)
                        <span class="flag-icon flag-icon-{{mb_strtolower($countries[$top_rating_user->country_id]->code)}}"></span>
                    @else
                        <span class="flag-icon"></span>
                    @endif
                    @if($top_rating_user->race)
                        <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons[$top_rating_user->race]}}" alt="">
                    @else
                        <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons['All']}}" alt="">
                    @endif
                    <span class="overflow-hidden">{{$top_rating_user->name}}</span>
                </a>
            </div>
        @endforeach
    </div>
@endif