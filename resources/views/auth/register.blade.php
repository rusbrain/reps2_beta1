@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('css')
    <!--JS plugin Select2 - autocomplete -->
    <link rel="stylesheet" href="{{route('home')}}/css/select2.min.css"/>
@endsection

<script src='https://www.google.com/recaptcha/api.js'></script>
<!--JS plugin Select2 - autocomplete -->
<link rel="stylesheet" href="{{route('home')}}/css/select2.min.css"/>

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
                                class="form-select-2 custom-select {{ $errors->has('country') ? ' is-invalid' : '' }}">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}" {{$country->id == old('country') ? ' selected' : '' }}>
                                    {{$country->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('country'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('country') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="race" id="race">*Раса:</label>
                        <select class="custom-select {{ $errors->has('race') ? ' is-invalid' : '' }}"
                                id="race" name="race">
                            @foreach(\App\Replay::$races as $race)
                                <option value="{{$race}}" {{$race == old('race')?' selected':''}}>
                                    {{$race}}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('race'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('race') }}</strong>
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
                        <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"></div>
                        @if ($errors->has('g-recaptcha-response'))
                        <span class="invalid-feedback" style="display: block;">{{ $errors->first('g-recaptcha-response') }}</span>
                        <!-- end if -->
                        @endif
                        <span class="invalid-feedback" style="display: none;">
                            Complete the reCAPTCHA to submit the form
                        </span>
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
    <!--JS plugin Select2 - autocomplete -->
    <script src="{{route('home')}}/js/select2.full.min.js"></script>

    <script>
        $(function () {
            if($('.form-select-2').length > 0){
                $('.form-select-2').select2({

                });
            }
        });
    </script>
@endsection

