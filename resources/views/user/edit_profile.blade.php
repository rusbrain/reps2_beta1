@extends('layouts.site')

@section('content')
    <div>
        <div class="page-title">Редактирование профайла пользователя</div>
        <form method="POST" action="{{ route('save_profile') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" id="name" class="form-control" name="name" value="{{old('name')??$user->name}}"
                       required>
            </div>
            <div class="form-group">
                <label for="homepage">Домашняя страница:</label>
                <input type="url" id="homepage" class="form-control" name="homepage"
                       value="{{old('homepage')??$user->homepage}}">
            </div>
            <div class="form-group">
                <label for="vk_link">Вконтакте:</label>
                <input type="url" id="vk_link" class="form-control" name="vk_link"
                       value="{{old('vk_link')??$user->vk_link}}">
            </div>
            <div class="form-group">
                <label for="fb_link">Facebook:</label>
                <input type="url" id="fb_link" class="form-control" name="fb_link"
                       value="{{old('fb_link')??$user->fb_link}}">
            </div>
            <div class="form-group">
                <label for="isq">ISQ:</label>
                <input type="text" id="isq" class="form-control" name="isq"
                       value="{{old('isq')??$user->isq}}">
            </div>
            <div class="form-group">
                <label for="skype">Skype:</label>
                <input type="text" id="skype" class="form-control" name="skype"
                       value="{{old('skype')??$user->skype}}">
            </div>
            <div class="form-group">
                <label for="signature">Подпись:</label>
                <textarea name="signature" id="signature" class="form-control" col="10">
                    {{old('signature')??$user->signature}}</textarea>
            </div>
            <div class="form-group">
                <label for="mouse">Мышь:</label>
                <input type="text" id="mouse" class="form-control" name="mouse"
                       value="{{old('mouse')??$user->mouse}}">
            </div>
            <div class="form-group">
                <label for="keyboard">Клавиатура:</label>
                <input type="text" id="keyboard" class="form-control" name="keyboard"
                       value="{{old('keyboard')??$user->keyboard}}">
            </div>
            <div class="form-group">
                <label for="headphone">Наушники:</label>
                <input type="text" id="headphone" class="form-control" name="headphone"
                       value="{{old('headphone')??$user->headphone}}">
            </div>
            <div class="form-group">
                <label for="mousepad">Коврик:</label>
                <input type="text" id="mousepad" class="form-control" name="mousepad"
                       value="{{old('mousepad')??$user->mousepad}}">
            </div>
            <div class="form-group">
                <label for="birthday">Дата рождения:</label>
                <input type="date" id="birthday" class="form-control" name="birthday"
                       value="{{old('birthday')??$user->birthday}}">
            </div>
            <div class="form-group">
                <label for="view_signs">Просматривать подписи на форуме:</label>
                <input type="checkbox" id="view_signs" class="" name="view_signs"
                       value="1" @if((old('view_signs')??$user->view_signs)) checked @endif >
            </div>
            <div class="form-group">
                <label for="view_avatars">Просматривать аватары на форуме:</label>
                <input type="checkbox" id="view_avatars" class="" name="view_avatars"
                       value="1" @if((old('view_avatars')??$user->view_avatars)) checked @endif >
            </div>

            <div class="form-group">
                <label for="avatar">Аватар:</label><br>
                @if($user->avatar())
                    <img class="img-responsive profile-avatar" src="{{$user->avatar->link}}" alt="">
                @endif

                <input type="file" id="avatar" class="form-control-file filestyle" placeholder="Выберете изображение" name="avatar">
            </div>

            <div class="form-group">
                <label for="country">Страна:</label>
                <select name='country' id="country" size=1 class="form-control">
                    @foreach($countries as $country)
                        <option @if(( $user->country_id == $country->id)) selected @endif
                        value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ok</button>
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
    </div>
    <script>
        /**ckeditor for User profile editing*/
        $(function () {
            CKEDITOR.replace( 'signature' );
        });
    </script>
@endsection