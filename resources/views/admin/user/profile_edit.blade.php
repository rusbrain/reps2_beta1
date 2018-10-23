@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
    <link rel="stylesheet" href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@endsection

@section('page_header')
    Профиль {{$user->name}}
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.users')}}">Пользователи</a></li>
    <li class="active">Профиль {{$user->name}}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$user->name}}</h3>
                </div>
                <div class="box-body">
                    <form action="{{route('admin.user.profile.save', ['id' => $user->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o margin-r-5"></i></span>
                                    <input type="email" class="form-control" placeholder="Email" disabled value="{{$user->email}}">
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user margin-r-5"></i></span>
                                    <input type="text" name="name" class="form-control" placeholder="Имя пользователя" value="{{old('name')??$user->name}}">
                                </div>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback text-red" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                                <br>
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-birthday-cake"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datepicker" name="birthday" value="{{old('birthday')??($user->birthday??'')}}">
                                    </div>
                                    @if ($errors->has('birthday'))
                                        <span class="invalid-feedback  text-red" role="alert">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                                @endif
                                    <!-- /.input group -->
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-chrome margin-r-5"></i></span>
                                    <input type="text" name="homepage" class="form-control" placeholder="Домашняя страница" value="{{old('homepage')??$user->homepage}}">
                                </div>
                                @if ($errors->has('homepage'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('homepage') }}</strong>
                                    </span>
                                @endif
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-columns margin-r-5"></i></span>
                                    <input type="text" name="isq" class="form-control" placeholder="ISQ" value="{{old('isq')??$user->isq}}">
                                </div>
                                @if ($errors->has('isq'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('isq') }}</strong>
                                    </span>
                                @endif
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-skype margin-r-5"></i></span>
                                    <input type="text" name="skype" class="form-control" placeholder="Skype" value="{{old('skype')??$user->skype}}">

                                </div>
                                @if ($errors->has('skype'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('skype') }}</strong>
                                    </span>
                                @endif
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-vk margin-r-5"></i></span>
                                    <input type="text" name="vk_link" class="form-control" placeholder="Вконтакте" value="{{old('vk_link')??$user->vk_link}}">

                                </div>
                                @if ($errors->has('vk_link'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('vk_link') }}</strong>
                                    </span>
                                @endif
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-facebook-official margin-r-5"></i></span>
                                    <input type="text" name="fb_link" class="form-control" placeholder="Facebook" value="{{old('fb_link')??$user->fb_link}}">

                                </div>
                                @if ($errors->has('fb_link'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('fb_link') }}</strong>
                                    </span>
                                @endif
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-mouse-pointer margin-r-5"></i></span>
                                    <input type="text" name="mouse" class="form-control" placeholder="Мышь" value="{{old('mouse')??$user->mouse}}">

                                </div>
                                @if ($errors->has('mouse'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('mouse') }}</strong>
                                    </span>
                                @endif
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-keyboard-o margin-r-5"></i></span>
                                    <input type="text" name="keyboard" class="form-control" placeholder="Кавиатура" value="{{old('keyboard')??$user->keyboard}}">

                                </div>
                                @if ($errors->has('keyboard'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('keyboard') }}</strong>
                                    </span>
                                @endif
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-headphones margin-r-5"></i></span>
                                    <input type="text" name="headphone" class="form-control" placeholder="Наушники" value="{{old('headphone')??$user->headphone}}">

                                </div>
                                @if ($errors->has('headphone'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('headphone') }}</strong>
                                    </span>
                                @endif
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-object-ungroup margin-r-5"></i></span>
                                    <input type="text" name="mousepad" class="form-control" placeholder="Коврик" value="{{old('mousepad')??$user->mousepad}}">

                                </div>
                                @if ($errors->has('mousepad'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('mousepad') }}</strong>
                                    </span>
                                @endif
                                <br>
                                <div class="form-group">
                                    <label>Роль</label>
                                    <select class="form-control" name="user_role_id" @if(!$admin_helper->admin()) disabled @endif>
                                        <option @if(!$user->user_role_id) selected @endif>Пользователь</option>
                                        @foreach($admin_helper->getUserRole() as $role)
                                            <option value="{{$role->id}}" @if($user->user_role_id == $role->id) selected @endif>{{$role->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Страна</label>
                                    <select class="form-control" name="country_id">
                                        @foreach($admin_helper->getCountries() as $country)
                                            <option value="{{$country->id}}" @if($user->country_id == $country->id) selected @endif>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('country'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                @endif
                                <br>
                            </div>
                            <div class="col-md-6">
                                <img class="img-responsive" src="{{route('home').($user->avatar->link??'/dist/img/avatar.png')}}" alt="Photo">
                                <br>
                                <br>
                                <br>
                                <div class="form-group">
                                    <label for="exampleInputFile">Загрузить новый аватар</label>
                                    <input type="file" id="exampleInputFile" name="avatar">
                                </div>
                                @if ($errors->has('avatar'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Обновить</button>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{route('home')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    //Date picker
    <script>
        $('#datepicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
        });
    </script>
@endsection