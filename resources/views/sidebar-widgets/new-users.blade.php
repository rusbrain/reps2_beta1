@php
    $new_users = $general_helper->getNewUsers();
    $countries = $general_helper->getCountries();
@endphp
@if(!empty($new_users))
    <div class="widget-wrapper">
        <div class="widget-header">Новые пользователи</div>
        @foreach($new_users as $new_user)
            <div class="widget-new-user">
                <a href="{{route('user_profile',['id'=>$new_user->id])}}">
                    <span class="color-blue">#{{$new_user->id}}</span>
                    @if($new_user->country_id)
                        <span class="flag-icon flag-icon-{{mb_strtolower($countries[$new_user->country_id]->code)}}"></span>
                    @else
                        <span class="flag-icon"></span>
                    @endif
                    @if($new_user->race)
                        <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons[$new_user->race]}}" alt="">
                    @else
                        <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons['All']}}" alt="">
                    @endif
                    <span class="overflow-hidden">{{$new_user->name}}</span>
                </a>
            </div>
        @endforeach
    </div>
@endif