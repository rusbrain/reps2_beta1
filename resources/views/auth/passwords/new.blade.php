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
            <h1>Регистрация:</h1>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-md-10">
                <form method="POST" action="{{ route('save_new_password') }}">
                    @csrf
                    <div class="form-group">
                        <label for="password">*Пароль:</label>
                        <input type="password" id="password" name="password" value=""
                               class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}">
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">*Подтвердите пароль:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" value=""
                               class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                        @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                        @endif
                    </div>
                    <input type="hidden" name="password_update_token" value="{{$update_email_token}}">
                    <div class="form-group">
                        <button type="submit" class="btn-blue btn-form">Отправить</button>
                    </div>
                </form>
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

