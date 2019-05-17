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
                    <a href="#" class="active">/ Получение ссылки для восстановление пароля</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->
    <div class="content-box">
        <div class="col-md-12 section-title margin-bottom-15">
            <h1>Получение ссылки для восстановление пароля:</h1>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-md-10">
                <form method="GET" action="{{route('get_update_password')}}">
                    @csrf
                    <div class="form-group">
                        <label for="email">*E-Mail:</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" required>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

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
