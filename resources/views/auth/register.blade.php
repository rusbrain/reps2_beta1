@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

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
                <li>
                    <a href="#" class="active">/ Регистрация</a>
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
                <form action="{{ route('registration') }}" class="register-form" id="register-form" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">*Имя:</label>
                        <input type="text" id="name" name="name" value="{{old('name')}}"
                               class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="text" id="email" name="email" value="{{old('email')}}"
                               class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}">
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="country">*Страна:</label>
                        <select name='country' id="country" size=1
                                class="custom-select {{ $errors->has('country') ? ' is-invalid' : '' }}">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}" {{$country->id == old('country') ? ' selected' : '' }}>{{$country->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('country'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('country') }}</strong>
                            </span>
                        @endif
                    </div>

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

                    <div class="form-group">
                        <button type="submit" class="btn-blue btn-form">Зарегистрироваться</button>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div><!-- close div /.content-box -->
@endsection()

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

