<form action="{{ route('login') }}" method="POST" class="login-form" id="login-form">
    @csrf
    <div>
        <input type="email" id="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
               name="email" value="{{ old('email') }}" placeholder="Введите почту" required autofocus>
        @if ($errors->has('email'))
            <span class="error">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="position-relative">
        <input type="password" name="password" id="password"
               class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" value=""
               placeholder="Введите пароль" required>
        @if ($errors->has('password'))
            <span class="error">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
        <button type="submit" class="btn-login btn-blue">Ok</button>
    </div>
</form>