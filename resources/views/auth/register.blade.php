<html>
<body>
<form method="POST" action="{{ route('registration') }}">
    @csrf
    Имя: <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus><br>
    Пароль: <input id="password" type="password" name="password" required><br>
    Подтвердите пароль: <input id="password_confirmation" type="password" name="password_confirmation" required><br>
    E-mail: <input id="email" type="text" name="email" value="{{ old('email') }}" required><br>
    Страна: <select name='country' size=1>
    @foreach($countries as $country)
        <option value="{{$country->id}}">{{$country->name}}</option>
    @endforeach
    </select><br>
    <button type="submit" class="btn btn-primary">
        Ok
    </button>
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

</body>
</html>