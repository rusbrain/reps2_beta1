@extends('admin.layouts.admin')

@section('css')
<link rel="stylesheet" href="{{route('home')}}/bower_components/select2/dist/css/select2.min.css">
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
    {{--{{dd($user)}}--}}
    <div class="row">
        <div class="col-lg-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    @if(isset($user->avatar))
                        <img class="profile-user-img img-responsive img-circle" src="{{route('home').$user->avatar->link}}" alt="User profile picture">
                    @else
                        <img class="profile-user-img img-responsive img-circle" src="{{route('home').'/dist/img/avatar.png'}}" alt="User profile picture">
                    @endif

                    <h3 class="profile-username text-center">{{$user->name}}</h3>

                    <p class="text-muted text-center">
                        @if($user->user_role_id)
                            {{$user->role->title}}
                        @else
                            Пользователь
                        @endif
                    </p>
                    <p class="text-muted text-center">
                        На сайте с {{$user->created_at->format('d-m-Y')}}
                    </p>

                    <ul class="list-group list-group-unbordered">
                        @if($user->positive_count)
                            <li class="list-group-item">
                                <b>Положительные оценки</b> <a class="pull-right">{{$user->positive_count}}</a>
                            </li>
                        @endif
                        @if($user->negative_count)
                            <li class="list-group-item">
                                <b>Отрицательные оценки</b> <a class="pull-right">{{$user->negative_count}}</a>
                            </li>
                        @endif
                        @if($user->topics_count)
                            <li class="list-group-item">
                                <b>Записей на форуме</b> <a class="pull-right">{{$user->topics_count}}</a>
                            </li>
                        @endif
                        @if($user->replay_count)
                            <li class="list-group-item">
                                <b>Пользовательских Replays</b> <a class="pull-right">{{$user->replay_count}}</a>
                            </li>
                        @endif
                        @if($user->gosu_replay_count)
                            <li class="list-group-item">
                                <b>Gosu Replays</b> <a class="pull-right">{{$user->gosu_replay_count}}</a>
                            </li>
                        @endif
                        @if($user->user_galleries_count)
                            <li class="list-group-item">
                                <b>Изображений в галерее</b> <a class="pull-right">{{$user->user_galleries_count}}</a>
                            </li>
                        @endif
                        @if($user->topic_comments_count)
                        <li class="list-group-item">
                            <b>Комментариев на форуме</b> <a class="pull-right">{{$user->topic_comments_count}}</a>
                        </li>
                        @endif
                        @if($user->replay_comments_count)
                            <li class="list-group-item">
                                <b>Комментариев к Replays</b> <a class="pull-right">{{$user->replay_comments_count}}</a>
                            </li>
                        @endif
                        @if($user->gallery_comments_count)
                            <li class="list-group-item">
                                <b>Комментариев в галерее</b> <a class="pull-right">{{$user->gallery_comments_count}}</a>
                            </li>
                        @endif
                        @if($user->files_count)
                            <li class="list-group-item">
                                <b>Загруженных файлов всего</b> <a class="pull-right">{{$user->files_count}}</a>
                            </li>
                        @endif
                        @if($user->answers_to_questions_count)
                            <li class="list-group-item">
                                <b>Ответов на опросы</b> <a class="pull-right">{{$user->answers_to_questions_count}}</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.box -->
        <div class="col-lg-3">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Данные пользователя</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-user margin-r-5"></i> ID пользователя</strong>
                    <p class="text-muted">
                        {{$user->id}}
                    </p>
                    <hr>
                    <strong><i class="fa fa-envelope-o margin-r-5"></i>Email</strong>
                    <p class="text-muted">{{$user->email}}
                        @if($user->email_verified_at)
                            <i class="fa fa-check margin-r-5 text-green"></i>
                        @else
                            <i class="fa fa-clock-o margin-r-5 text-red"></i>
                        @endif
                    </p>
                    <hr>
                    @if($user->country)
                        <strong><i class="fa fa-map-marker margin-r-5"></i>Страна</strong>
                        <p class="text-muted">{{$user->country->name}}</p>
                        <hr>
                    @endif
                    @if($user->birthday)
                        <strong><i class="fa fa-birthday-cake margin-r-5"></i>День рождения</strong>
                        <p class="text-muted">{{$user->birthday}}</p>
                        <hr>
                    @endif
                    @if($user->homepage)
                        <strong><i class="fa fa-chrome margin-r-5"></i>Домашняя страница</strong>
                        <p class="text-muted">{{$user->homepage}}</p>
                        <hr>
                    @endif
                    @if($user->isq)
                        <strong><i class="fa fa-columns margin-r-5"></i>ISQ</strong>
                        <p class="text-muted">{{$user->isq}}</p>
                        <hr>
                    @endif
                    @if($user->skype)
                        <strong><i class="fa fa-skype margin-r-5"></i>Skype</strong>
                        <p class="text-muted">{{$user->skype}}</p>
                        <hr>
                    @endif
                    @if($user->vk_link)
                        <strong><i class="fa fa-vk margin-r-5"></i>Вконтакте</strong>
                        <p class="text-muted">{{$user->vk_link}}</p>
                        <hr>
                    @endif
                    @if($user->fb_link)
                        <strong><i class="fa fa-facebook-official margin-r-5"></i>Facebook</strong>
                        <p class="text-muted">{{$user->fb_link}}</p>
                        <hr>
                    @endif
                    @if($user->mouse)
                        <strong><i class="fa fa-mouse-pointer margin-r-5"></i>Мышь</strong>
                        <p class="text-muted">{{$user->mouse}}</p>
                        <hr>
                    @endif
                    @if($user->keyboard)
                        <strong><i class="fa fa-keyboard-o margin-r-5"></i>Кавиатура</strong>
                        <p class="text-muted">{{$user->keyboard}}</p>
                        <hr>
                    @endif
                    @if($user->headphone)
                        <strong><i class="fa fa-headphones margin-r-5"></i>Наушники</strong>
                        <p class="text-muted">{{$user->headphone}}</p>
                        <hr>
                    @endif
                    @if($user->mousepad)
                        <strong><i class="fa fa-object-ungroup margin-r-5"></i>Коврик</strong>
                        <p class="text-muted">{{$user->mousepad}}</p>
                        <hr>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-lg-6">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">Последние публикации</a></li>
                    <li><a href="#friends" data-toggle="tab">Друзья</a></li>
                    <li><a href="#voting" data-toggle="tab">Голосование</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <div class="row">
                            @if($user->topics->count())
                                <div class="col-md-{{$user->replays->count()?'6':'12'}}">
                                    <h3 class="text-blue"> <a href="{{route('admin.user.topic', ['id'=>$user->id])}}">Форум</a></h3>
                                    @foreach($user->topics as $topic)
                                        {{--{{dd($topic)}}--}}
                                        <div class="post">
                                            <div class="user-block">
                                                <span class="username">
                                                    <a href="{{route('forum.topic.index', ['id'=>$topic->id])}}">{{$topic->section->title}} >> {{$topic->title}}</a>
                                                </span>
                                                <span class="description">{{$topic->created_at->format('h:m d.m.y')}}</span>
                                            </div>
                                            @if($topic->preview_image)
                                                <img class="img-responsive" src="{{route('home').$topic->preview_image->link}}" alt="Photo">
                                            @endif
                                            <!-- /.user-block -->
                                            <p>
                                                @if($topic->preview_content)
                                                    {{$topic->preview_content}}
                                                @else
                                                    {{mb_strimwidth($topic->content,0,1000, '...')}}
                                                @endif
                                            </p>
                                            <ul class="list-inline">
                                                <li class="pull-right">
                                                    <p  class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i>
                                                        {{$topic->comments_count}}</p></li>
                                                <li class="pull-right">
                                                    <p  class="link-black text-sm"><i class="fa fa-thumbs-o-down margin-r-5 text-red"></i>
                                                        {{$topic->negative_count}}</p></li>
                                                <li class="pull-right">
                                                    <p  class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5 text-green"></i>
                                                        {{$topic->positive_count}}</p></li>
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if($user->replays->count())
                                <div class="col-md-{{$user->topics->count()?'6':'12'}}">
                                    <h3 class="text-blue"><a href="{{route('admin.user.replay', ['id'=>$user->id])}}">Replay</a></h3>
                                    @foreach($user->replays as $replay)
                                        <div class="post">
                                            <div class="user-block">
                                                <span class="username">
                                                    <a href="{{route('replay.get', ['id'=>$replay->id])}}">{{$replay->user_replay?"Пользовательский":"Gosu"}} Replay >> {{$replay->title}}({{$replay->type->name}})</a>
                                                </span>
                                                <span class="description">{{$replay->created_at->format('h:m d.m.y')}}</span>
                                            </div>
                                            <div class="row">
                                                @if($replay->map)
                                                    <div class="col-md-4">
                                                        <img class="img-responsive" src="{{route('home').'/'.$replay->map->url}}" alt="Photo">
                                                    </div>
                                                @endif
                                        <!--     /.user-block -->
                                                <div class="col-md-{{$replay->map != null ?'8':'12'}}">
                                                    <p>
                                                        <b>Страны:</b> {{$replay->first_country->name??"NO"}} vs {{$replay->second_country->name??"NO"}} <br>
                                                        <b>Матчап:</b> {{$replay->first_race??"NO"}} vs {{$replay->second_race??"NO"}} <br>
                                                        <b>Локации:</b> {{$replay->first_location??"NO"}} vs {{$replay->second_location??"NO"}} <br>
                                                        <b>Длительность:</b> {{$replay->length}} <br>
                                                        <b>Чемпионат:</b> {{$replay->championship}} <br>
                                                        <b>Версия:</b> {{$replay->game_version}} <br>
                                                        <b>Рейтинг:</b> {{$replay->evaluation}} <br>
                                                        <b>Юзер Рейтинг:</b> {{$replay->user_rating}} <br>
                                                        {{mb_strimwidth($replay->content,0,1000, '...')}}
                                                    </p>
                                                </div>
                                            </div>
                                            <ul class="list-inline">
                                                <li class="pull-right">
                                                    <p  class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i>
                                                        {{$replay->comments_count}}</p></li>
                                                <li class="pull-right">
                                                    <p  class="link-black text-sm"><i class="fa fa-thumbs-o-down margin-r-5 text-red"></i>
                                                        {{$replay->negative_count}}</p></li>
                                                <li class="pull-right">
                                                    <p  class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5 text-green"></i>
                                                        {{$replay->positive_count}}</p></li>
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if($user->user_galleries->count())
                                <div class="col-md-12">
                                    <h3 class="text-blue"><a href="{{route('gallery.list_user', ['id'=>$user->id])}}">Галерея</a></h3>
                                    <div class="post">
                                        <!-- /.user-block -->
                                        <div class="row margin-bottom">
                                            @php $i = 0; @endphp
                                            @foreach($user->user_galleries as $user_galleries)
                                                @php $i++; @endphp
                                                <div class="col-sm-4">
                                                    <a href="{{route('gallery.view', ['id' => $user_galleries->id])}}"><img class="img-responsive" src="{{route('home').'/'.$user_galleries->file->link}}" alt="Photo"></a>
                                                </div>
                                                @if($i%3 == 0) <div class="row" style="margin: 30px"></div>@endif
                                            @endforeach
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="friends">
                        <!-- The timeline -->
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="text-blue">{{$user->name}} дружит с:</h3>
                                <table class="table table-condensed">
                                    <thead>
                                    <tr>
                                        <th style="width: 30px">ID</th>
                                        <th style="width: 50px">Аватар</th>
                                        <th>Имя</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->user_friends as $friend)
                                        <tr>
                                            <td>{{$friend->friend_user->id}}</td>
                                            <td>
                                                <img class="direct-chat-img" src="{{route('home').($friend->friend_user->avatar?$friend->friend_user->avatar->link:'/dist/img/avatar.png')}}" alt="Аватар пользователя"><!-- /.direct-chat-img -->
                                            </td>
                                            <td><a href="{{route('admin.user.profile', ['id' => $friend->friend_user->id])}}">{{$friend->friend_user->name}}</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h3 class="text-blue">Дружат с {{$user->name}}:</h3>
                                <table class="table table-condensed">
                                    <thead>
                                    <tr>
                                        <th style="width: 30px">ID</th>
                                        <th style="width: 50px">Аватар</th>
                                        <th>Имя</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->user_friendly as $friend)
                                        <tr>
                                            <td>{{$friend->user->id}}</td>
                                            <td>
                                                <img class="direct-chat-img" src="{{route('home').($friend->user->avatar?$friend->user->avatar->link:'/dist/img/avatar.png')}}" alt="Аватар пользователя"><!-- /.direct-chat-img -->
                                            </td>
                                            <td><a href="{{route('admin.user.profile', ['id' => $friend->user->id])}}">{{$friend->user->name}}</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="voting">
                        <!-- The timeline -->
                        <table class="table table-condensed">
                        <thead>
                        <tr>
                            <th style="width: 30px">ID</th>
                            <th>Вопрос</th>
                            <th>Выбраный ответ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->answers_to_questions as $answers_to_questions)
                            <tr>
                                <td>{{$answers_to_questions->question->id}}</td>
                                <td>
                                    <a href="#">{{$answers_to_questions->question->question}}</a>
                                </td>
                                <td>{{$answers_to_questions->question->answers->where('id', $answers_to_questions->answer_id)->first()->answer}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>

                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    </div>
@endsection

@section('js')

@endsection