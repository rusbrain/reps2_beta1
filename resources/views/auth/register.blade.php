@extends('layouts.site')

@section('header')
    @include('header-registration')
@endsection

@section('navigation')
    @include('navigation')
@endsection

@section('sidebar-left')
    @include('sidebar-left')
@endsection

@section('content')
    <div class="col-md-6 content-center">
        <form method="POST" action="{{ route('registration') }}" name="register-form" class="register-form" id="register-form">
            @csrf
            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" required
                       autofocus>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="text" id="email" class="form-control" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="country">Страна:</label>
                <div class="error-country"></div>
                <select name="country" size=1 id="country" class="form-control country">
                    @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="password">Пароль:</label>
                <input id="password" class="form-control" type="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Подтвердите пароль:</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation"
                       required>
            </div>

            <button type="submit" class="btn btn-primary form-control">Submit</button>
            <div style="color: red">
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                @endif
                @if ($errors->has('country'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                @endif
            </div>
        </form>
    </div>
@endsection()

@section('sidebar-right')
    @include('sidebar-right')
@endsection

@section('footer')
    @include('footer')
@endsection