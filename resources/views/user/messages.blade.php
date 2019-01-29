@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('sidebar-left')
    <!-- User messages widget -->
    @include('sidebar-widgets.user-messages',['all_new_messages'=>collect($contacts->items())->sum('new_messages'),'contacts' => $contacts])
    <!-- END User Messages widget -->
@endsection

@section('content')
    <!-- Breadcrumbs -->
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/">Главная</a>
                </li>
                <li>
                    <a href="{{route('user_profile',['id' =>Auth::id()])}}">/ Мой Аккаунт</a>
                </li>
                <li>
                    <a href="" class="active">/ Мои сообщения</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Мои сообщения</div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="user-messages-info">
                    <img src="{{route('home')}}/images/avatars/photo-container.png" alt="">
                    <a href="{{route('user_profile',['id' =>$user->id])}}" class="user-name">{{$user->name}}</a>

                    <!-- if online displays this -->
                    <span class="user-online-status">online</span>
                    <!-- if INACTIVE displays this -->
                    <div class="user-last-online">{{$user->activity_at}}</div>

                </div>
            </div>
            <!-- CHAT MESSAGES -->
            <div class="messages-wrapper messages-box">
                @include('user.messages-partials.message_parse')
            </div>
            <!--END CHAT MESSAGES -->
        </div>

        <!-- ADD MESSAGE FORM -->
        <div class="col-md-12">
            @include('user.messages-partials.add-message-form')
        </div>
        <!-- END ADD MESSAGE FORM -->
    </div>
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