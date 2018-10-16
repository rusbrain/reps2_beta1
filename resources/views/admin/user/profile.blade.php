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
                        <li class="list-group-item">
                            <b>Положительные оценки</b> <a class="pull-right">{{$user->positive_count}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Отрицательные оценки</b> <a class="pull-right">{{$user->negative_count}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Записей на форуме</b> <a class="pull-right">{{$user->topics_count}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Пользовательских Replays</b> <a class="pull-right">{{$user->replay_count}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Gosu Replays</b> <a class="pull-right">{{$user->gosu_replay_count}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Изображений в галерее</b> <a class="pull-right">{{$user->user_galleries_count}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Комментариев на форуме</b> <a class="pull-right">{{$user->topic_comments_count}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Комментариев к Replays</b> <a class="pull-right">{{$user->replay_comments_count}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Комментариев в галерее</b> <a class="pull-right">{{$user->gallery_comments_count}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Загруженных файлов всего</b> <a class="pull-right">{{$user->files_count}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Ответов на опросы</b> <a class="pull-right">{{$user->answers_to_questions_count}}</a>
                        </li>
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
                        <strong><i class="fa fa-mouse-pointer margin-r-5"></i>Машь</strong>
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
                    <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
                    <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                    <li><a href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                                <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                                <span class="description">Shared publicly - 7:30 PM today</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>
                            <ul class="list-inline">
                                <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                                <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                                </li>
                                <li class="pull-right">
                                    <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                        (5)</a></li>
                            </ul>

                            <input class="form-control input-sm" type="text" placeholder="Type a comment">
                        </div>
                        <!-- /.post -->

                        <!-- Post -->
                        <div class="post clearfix">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                                <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                                <span class="description">Sent you a message - 3 days ago</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>

                            <form class="form-horizontal">
                                <div class="form-group margin-bottom-none">
                                    <div class="col-sm-9">
                                        <input class="form-control input-sm" placeholder="Response">
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.post -->

                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg" alt="User Image">
                                <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                                <span class="description">Posted 5 photos - 5 days ago</span>
                            </div>
                            <!-- /.user-block -->
                            <div class="row margin-bottom">
                                <div class="col-sm-6">
                                    <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <img class="img-responsive" src="../../dist/img/photo2.png" alt="Photo">
                                            <br>
                                            <img class="img-responsive" src="../../dist/img/photo3.jpg" alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-6">
                                            <img class="img-responsive" src="../../dist/img/photo4.jpg" alt="Photo">
                                            <br>
                                            <img class="img-responsive" src="../../dist/img/photo1.png" alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <ul class="list-inline">
                                <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                                <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                                </li>
                                <li class="pull-right">
                                    <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                                        (5)</a></li>
                            </ul>

                            <input class="form-control input-sm" type="text" placeholder="Type a comment">
                        </div>
                        <!-- /.post -->
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                        <!-- The timeline -->
                        <ul class="timeline timeline-inverse">
                            <!-- timeline time label -->
                            <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-envelope bg-blue"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                                    <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                    <div class="timeline-body">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                        quora plaxo ideeli hulu weebly balihoo...
                                    </div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-primary btn-xs">Read more</a>
                                        <a class="btn btn-danger btn-xs">Delete</a>
                                    </div>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-user bg-aqua"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                                    <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                                    </h3>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-comments bg-yellow"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                                    <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                    <div class="timeline-body">
                                        Take me to your leader!
                                        Switzerland is small and neutral!
                                        We are more like Germany, ambitious and misunderstood!
                                    </div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                                    </div>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            <!-- timeline time label -->
                            <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-camera bg-purple"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                                    <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                    <div class="timeline-body">
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                                    </div>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                        </ul>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputName" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                <div class="col-sm-10">
                                    <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                        </form>
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