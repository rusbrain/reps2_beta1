<html>
<body>
<form method="POST" action="{{ route('save_new_password') }}">
    @csrf
<input type="hidden" name="password_update_token" value="{{$update_email_token}}">
    New Password: <input id="password" type="password" name="password" required>
    Confirm Password: <input id="password_confirmation" type="password" name="password_confirmation" required>
    <button type="submit" class="btn btn-primary">
        Log In
    </button>
    @if ($errors->has('password'))
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
    @endif
    @if ($errors->has('password_update_token'))
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_update_token') }}</strong>
                                    </span>
    @endif
</form>
</body>
</html>