@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries();@endphp
<div class="col-md-3 sidebar-inner-profile">
    <div class="profile-sidebar-widget">
        <p class="profile-link">Список друзей</p>
        <div class="friend-list-wrapper w-100">
            @if(count($user->friends) > 0)
                @foreach($user->friends as $friend)
                    <div class="friend-wrapper">
                        <span class="flag-icon flag-icon-{{$friend->country_id ? mb_strtolower($countries[$friend->country_id]->code):'no'}}"></span>
                        <a href="{{route('user_profile',['id' => $friend->id])}}">{{$friend->name}}</a>
                    </div>
                @endforeach
            @else
                <p>Список пуст </p>
            @endif
        </div>
    </div>
    <div class="profile-sidebar-widget">
        <a href="" class="profile-link">В друзьях</a>
        <div class="friend-list-wrapper">
            @if(count($user->friendly) > 0)
                @foreach($user->friendly as $friend)
                    <div class="friend-wrapper">
                        <span class="flag-icon flag-icon-{{$friend->country_id ? mb_strtolower($countries[$friend->country_id]->code):'no'}}"></span>
                        <a href="{{route('user_profile',['id' => $friend->id])}}">{{$friend->name}}</a>
                    </div>
                @endforeach
            @else
                <p>Список пуст </p>
            @endif
        </div>
    </div>
</div>