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
                        <a href="{{route('user_profile',['id' => $user->id])}}">/ Мой Аккаунт</a>
                    </li>
                @endif
                <li>
                    <a href="" class="active">/ Репутация</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Информация о пользователе {{$user->name}}</div>
        </div>
        <div class="user-info">
            <div class="col-md-4">
                <div class="user-avatar-wrapper">
                    @if($user->avatar)
                        <a href="{{route('user_profile',['id' => $user->id])}}">
                            <img src="{{$user->avatar->link}}" alt="Аватар">
                        </a>
                    @else
                        <a href="{{route('user_profile',['id' => $user->id])}}"
                           class="">
                            <img src="{{route('home')}}/images/avatars/avatar-big.png" alt="Аватар">
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-md-8">
                <h2>{{$user->name}}</h2>

                <!-- if online displays this -->
                <div class="color-green text-bold margin-bottom-20 display-none">online</div>
                <!-- if INACTIVE displays this -->
                <div class="user-last-online">{{$user->activity_at}}</div>

                <div class="user-info-row">
                    <span>Имя:</span>
                    <a href="" class="color-blue text-medium">{{$user->name}}</a>
                </div>
                <div class="user-info-row">
                    <span>Страна:</span>
                    @if($user->country_id)
                        <span class="flag-icon margin-right-5 flag-icon-{{mb_strtolower($countries[$user->country_id]->code)}}"></span>
                        <span>{{$countries[$user->country_id]->name}}</span>
                    @else
                        <span>не указано</span>
                    @endif
                </div>
                <div class="user-info-row">
                    <span>Репутация:</span>
                    <span class="color-blue text-medium">{{$user->rating}} кг</span>
                </div>
            </div>
        </div>
    </div><!-- close div /.content-box -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>История репутации участника {{$user->name}}</div>
            <div class="user-reputation-qty">
                <span class="reputation-vote-up"></span>
                <span class="reputation-qty">{{$user->positive_count}}</span>
                <span class="reputation-vote-down"></span>
                <span class="reputation-qty">{{$user->negative_count}}</span>
            </div>
        </div>
        @if($list)
            @foreach($list as $item)
                <div class="user-reputation-vote-row">
                    <div class="user-reputation-vote-info">
                        <div>
                            <a href="{{route('user_profile',['id' => $item->sender->id])}}">{{$item->sender->name}}</a>
                            @if($item->sender->country_id)
                                <span class="flag-icon flag-icon-{{mb_strtolower($countries[$item->sender->country_id]->code)}}"></span>
                            @else
                                <span></span>
                            @endif
                            <span>{{$general_helper->getUserStatus($item->sender->score)}} {{$item->sender->score . 'pts'}} </span>
                            <span>|</span>
                            <a href="{{route('user.get_rating', ['id' => $item->sender->id])}}">{{$item->sender->rating}}
                                кг</a>
                        </div>
                        <div>
                            <img src="{{route('home')}}/images/icons/eye.png" alt="">
                            <span>{{$item->created_at}}</span>
                        </div>
                    </div>
                    <div class="user-reputation-vote-content">
                        <div class="col-md-11">
                            <a href="" class="target-vote-link">
                                <span>#1</span>
                                Нужно добавить связь коммента с объектом комментирования
                            </a>
                            <div>{!! $general_helper->oldContentFilter($item->comment) !!}</div>
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
            <div>Комментарии отсутствуют</div>
        @endif
    </div><!-- close div /.content-box -->

    <!--Pagination-->
    @php  $data = $list @endphp
    @include('pagination')
    <!--END Pagination-->
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



