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

                @if($general_helper->isOnline($user))
                    <!-- if online displays this -->
                    <div class="color-green text-bold margin-bottom-20">online</div>
                @else
                    <!-- if INACTIVE displays this -->
                    <div class="user-last-online">{{$user->activity_at}}</div>
                @endif

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

        <!--  CONTENT -->
        <div id="ajax_topic_reputation" >
            <div class="load-wrapp">
                <img src="/images/loader.gif" alt="">
            </div>
        </div>
    </div><!-- close div /.content-box -->

    <!--  PAGINATION -->
    <div class="pagination-content"></div>
    <!-- END  PAGINATION -->

@endsection

@section('sidebar-right')
    <!--Banners-->
    @include('sidebar-widgets.banner')
    <!-- END Banners -->

    <!-- New Users-->
    @include('sidebar-widgets.new-users')
    <!-- END New Users-->

    <!-- Top Points Users-->
    @include('sidebar-widgets.top-pts-users')
    <!-- END New Users-->

    <!-- Top Rating Users-->
    @include('sidebar-widgets.top-rating-users')
    <!-- END New Users-->


    <!-- User's Replays-->
    @include('sidebar-widgets.users-replays')
    <!-- END User's Replays-->

    <!-- Gallery -->
    @include('sidebar-widgets.random-gallery')
    <!-- END Gallery -->
@endsection

@section('js')
    <script>
        $(function () {
            getSections(1);
            $('.pagination-content').on('click', '.page-link', function (e) {
                e.preventDefault();
                $('.load-wrapp').show();
                var page = $(this).attr('data-page');
                getSections(page);
            })
        });
        function getSections(page) {
            var container = $('#ajax_topic_reputation');
            var body = $("html, body");

            $.get('{{route('user.paginate',['id' => $user->id])}}' + '?page=' + page, {}, function (data) {
                container.html(data.list);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();

                /**move to top of page*/
                moveToTop(body);
            });
        }
    </script>
@endsection


