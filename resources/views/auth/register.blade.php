@extends('layouts.site')

@section('content')
    <form method="POST" action="{{ route('registration') }}" name="register-form" class="register-form" id="register-form">
        @csrf
        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" required
                   autofocus>
            @if ($errors->has('name'))
                <div class="error">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="text" id="email" class="form-control" name="email" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
                <div class="error">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="country">Страна:</label>
            <div class="error-country"></div>
            <select name="country" size=1 id="country" class="form-control country">
                <option value="">Выберете страну</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
            </select>
            @if ($errors->has('country'))
                <div class="error">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input id="password" class="form-control" type="password" name="password" required>
            @if ($errors->has('email'))
                <div class="error">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="password_confirmation">Подтвердите пароль:</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation"
                   required>
            @if ($errors->has('password_confirmation'))
                <div class="error">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary form-control">Submit</button>
    </form>
@endsection()



