<html>
<body>
<form method="POST" action="{{ route('save_profile') }}" enctype="multipart/form-data">
    @csrf
    Имя: <input id="name" type="text" name="name" required value="{{old('name')??$user->name}}"><br><br>
    Домашняя страница: <input id="homepage" type="url" name="homepage"  value="{{old('homepage')??$user->homepage}}"><br><br>
    Вконтакте: <input id="vk_link" type="url" name="vk_link"  value="{{old('vk_link')??$user->vk_link}}"><br><br>
    Facebook: <input id="fb_link" type="url" name="fb_link"  value="{{old('fb_link')??$user->fb_link}}"><br><br>
    ISQ: <input id="isq" type="text" name="isq"  value="{{old('isq')??$user->isq}}"><br><br>
    Skype: <input id="skype" type="text" name="skype"  value="{{old('skype')??$user->skype}}"><br><br>
    Подпись: <textarea id="signature" type="text" name="signature" >{{old('signature')??$user->signature}}</textarea><br><br>
    Мышь: <input id="mouse" type="text" name="mouse"  value="{{old('mouse')??$user->mouse}}"><br><br>
    Клавиатура: <input id="keyboard" type="text" name="keyboard"  value="{{old('keyboard')??$user->keyboard}}"><br><br>
    Наушники: <input id="headphone" type="text" name="headphone"  value="{{old('headphone')??$user->headphone}}"><br><br>
    Коврик: <input id="mousepad" type="text" name="mousepad"  value="{{old('mousepad')??$user->mousepad}}"><br><br>
    Дата рождения: <input id="birthday" type="date" name="birthday"  value="{{old('birthday')??$user->birthday}}"><br><br>
    Просматривать подписи на форуме: <input id="view_signs" type="checkbox" name="view_signs"  value="1" @if((old('view_signs')??$user->view_signs)) checked @endif><br><br>
    Просматривать аватары на форуме: <input id="view_avatars" type="checkbox" name="view_avatars"  value="1" @if((old('view_avatars')??$user->view_avatars)) checked @endif><br><br>
    Аватар: <input id="avatar" type="file" name="avatar" ><br><br>
    Страна: <select name='country' size=1  value="{{old('country')??$user->country_id}}">
        @foreach($countries as $country)
            <option value="{{$country->id}}">{{$country->name}}</option>
        @endforeach
    </select><br><br>

    <button type="submit" class="btn btn-primary">
        Ok
    </button>

    <div style="color: red">
        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
        @endif
        @if ($errors->has('homepage'))
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('homepage') }}</strong>
                                    </span>
        @endif
        @if ($errors->has('vk_link'))
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('vk_link') }}</strong>
                                    </span>
        @endif
        @if ($errors->has('fb_link'))
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fb_link') }}</strong>
                                    </span>
        @endif
        @if ($errors->has('isq'))
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('isq') }}</strong>
                                    </span>
        @endif
        @if ($errors->has('skype'))
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('skype') }}</strong>
                                    </span>
        @endif
        @if ($errors->has('signature'))
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('signature') }}</strong>
                                    </span>
        @endif
        @if ($errors->has('mouse'))
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mouse') }}</strong>
                                    </span>
        @endif
        @if ($errors->has('keyboard'))
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('keyboard') }}</strong>
                                    </span>
        @endif
        @if ($errors->has('headphone'))
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('headphone') }}</strong>
                                    </span>
        @endif
        @if ($errors->has('mousepad'))
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mousepad') }}</strong>
                                    </span>
        @endif
        @if ($errors->has('birthday'))
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('birthday') }}</strong>
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