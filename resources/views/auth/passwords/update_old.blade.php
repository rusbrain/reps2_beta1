@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('sidebar-left')
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
                <li>
                    <a href="#" class="active">/ Восстановление пароля</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->
    <div class="content-box">
        <div class="col-md-12 section-title margin-bottom-15">
            <h1>Восстановление пароля</h1>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-md-10">
                <h2 class="password-recovering">На указаный Вами email было отправлено письмо
                    для восстановления пароля</h2>
                <p class="text-bold text-center">Email: <span class="color-red">{{$email}}</span></p>
                <a href="/" class="btn-blue btn-form margin-top-20 margin-bottom-20">Вернутся на Главную</a>
            </div>
            <div class="col"></div>
        </div>
    </div><!-- close div /.content-box -->
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