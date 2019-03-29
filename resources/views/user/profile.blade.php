@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries();@endphp

@section('sidebar-left')
    @include('sidebar-widgets.votes')

    @include('sidebar-widgets.gosu-replays')
@endsection
@section('content')
    <!-- Breadcrumbs -->
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/">Главная</a>
                </li>
                @if(Auth::id() == $user->id)
                    <li>
                        <a href="" class="active">/ Мой Аккаунт</a>
                    </li>
                @else
                    <li>
                        <a href="#" class="active">/ {{$user->name}}</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="user-account-info-wrapper">
            <div class="col-md-4">
                @if($user->avatar)
                    <img src="{{$user->avatar->link}}" class="user-account-avatar" alt="Аватар">
                @else
                    <img src="/images/avatars/avatar-big.png" class="user-account-avatar" alt="Аватар">
                @endif
                <div class="user-account-action-bar">
                    @if(Auth::id() != $user->id)
                        <a href="{{route('user.messages',['id' => $user->id])}}" title="Отправить сообщение">
                            <img src="/images/icons/send_message.png" alt="">
                        </a>
                        <a href="{{route('user.add_friend',['id'=>$user->id])}}" title="Добавить в друзья">
                            <img src="/images/icons/add_friend.png" alt="">
                        </a>
                        <a href="{{route('user.set_ignore',['id'=>$user->id])}}" title="Добавить в игнор">
                            <img src="/images/icons/remove_user.png" alt="">
                        </a>
                    @else
                        <a href="{{route('user.messages_all')}}" title="Мои сообщения">
                            <img src="/images/icons/send_message.png" alt="">
                        </a>
                        <a href="{{route('user.friends_list')}}" title="Мои друзья">
                            <img src="/images/icons/add_friend.png" alt="">
                        </a>
                        <a href="{{route('user.ignore_list')}}" title="Игнор лист">
                            <img src="/images/icons/remove_user.png" alt="">
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-md-8">
                <h2>{{$user->name}}</h2>

            @if($general_helper->isOnline($user))
                <!-- if online displays this -->
                <div class="color-green text-bold margin-bottom-20">online</div>
            @else
                <!-- if INACTIVE displays this -->
                <div class="user-last-online">{{$user->activity_at}}</div>
            @endif

                <div class="user-account-info-row">
                    <span>Статус:</span>
                    <span>{{$general_helper->getUserStatus($user->points)}}
                        <span class="text-bold">{{$user->points}}</span> pts
                    </span>
                </div>
                <div class="user-account-info-row">
                    <span>ДР:</span>
                    <span>{{$user->birthday}}</span>
                </div>
                <div class="user-account-info-row">
                    <span>Страна:</span>
                    @if($user->country_id)
                        <span>{{$countries[$user->country_id]->name}}</span>
                    @else
                        <span>Не указано</span>
                    @endif
                </div>
                <div class="user-account-info-row">
                    <span>Репутация:</span>
                    <a href="{{route('user.get_rating', ['id' => $user->id])}}">{{$user->rating}} кг</a>
                </div>
            </div>
        </div>
    </div><!-- close div /.content-box -->

    <div class="row">
        <div class="col-md-4">
            <!-- FRIEND LIST -->
        @include('user.profile-partials.profile-friend-list')
        <!-- END FRIEND LIST -->

            <!-- FRIENDLY LIST -->
        @include('user.profile-partials.profile-friendly-list')
        <!-- END FRIENDLY LIST -->
        </div><!-- close div /.col-md-4 -->

        <div class="col-md-8">
            <!-- PROFILE INFO -->
        @include('user.profile-partials.profile-info')
        <!-- END PROFILE INFO -->

            <!-- PROFILE ARMORY -->
        @include('user.profile-partials.profile-armory')
        <!-- END PROFILE ARMORY -->

            <!-- PROFILE CONTACTS -->
        @include('user.profile-partials.profile-contacts')
        <!-- END PROFILE CONTACTS -->

        </div><!-- close div /.col-md-8 -->
    </div><!-- close div /.row -->
@endsection

@section('sidebar-right')
    <!--Banners-->
    @include('sidebar-widgets.banner')
    <!-- END Banners -->

    <!-- New Users-->
    @include('sidebar-widgets.new-users')
    <!-- END New Users-->

    <!-- User's Replays-->
    @include('sidebar-widgets.users-replays')
    <!-- END User's Replays-->

    <!-- Gallery -->
    @include('sidebar-widgets.random-gallery')
    <!-- END Gallery -->
@endsection