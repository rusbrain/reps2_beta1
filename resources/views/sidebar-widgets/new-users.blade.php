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
                    @if($new_user->country_id)
                        <span class="flag-icon flag-icon-{{mb_strtolower($countries[$new_user->country_id]->code)}}"></span>
                    @else
                        <span class="flag-icon"></span>
                    @endif
                    <span>{{$new_user->name}}</span>
                </a>
            </div>
        @endforeach
    </div>
@endif
