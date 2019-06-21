@php
    $top_pts_users = $general_helper->getTopPtsUsers();
    $countries = $general_helper->getCountries();
@endphp
@if(!empty($top_pts_users))
    <div class="widget-wrapper">
        <div class="widget-header">Top pts пользователи</div>
        @foreach($top_pts_users as $top_user)
            <div class="widget-new-user">
                <a href="{{route('user_profile',['id'=>$top_user->id])}}">
                    <span class="color-blue">{{$top_user->points}} pts</span>
                    @if($top_user->country_id)
                        <span class="flag-icon flag-icon-{{mb_strtolower($countries[$top_user->country_id]->code)}}"></span>
                    @else
                        <span class="flag-icon"></span>
                    @endif
                    @if($top_user->race)
                        <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons[$top_user->race]}}" alt="">
                    @else
                        <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons['All']}}" alt="">
                    @endif
                    <span class="overflow-hidden">{{$top_user->name}}</span>
                </a>
            </div>
        @endforeach
    </div>
@endif