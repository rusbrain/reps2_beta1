@extends('admin.layouts.admin')

@section('css')
@endsection

@section('page_header')
    Replay
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.replay')}}">Replays</a></li>
    <li class="active">{{$replay->title}}</li>
@endsection

@section('content')
    {{--{{dd($replay)}}--}}
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="load-wrapp">
                <div class="load-3">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
            </div>
            <div class="box-header with-border">
                <h3 class="box-title text-blue">{{$replay->user_replay?"Пользовательский Replay":"Gosu Replay"}} / {{$replay->title}}</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <img class="img-bordered-sm"
                                     src="{{route('home')."/".($replay->map->url??"/dist/img/default-50x50.gif")}}" alt="map">

                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-5">
                                            Название:
                                        </div>
                                        <div class="col-md-7">
                                            <a href="{{route('replay.get', ['id' => $replay->id])}}">
                                                {{$replay->title}}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            Страны:
                                        </div>
                                        <div class="col-md-7">
                                            {{($replay->first_country->name??"Нет")}} vs {{($replay->second_country->name??"Нет")}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            Расы:
                                        </div>
                                        <div class="col-md-7">
                                            {{$replay->first_race}} vs {{$replay->second_race}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            Тип:
                                        </div>
                                        <div class="col-md-7">
                                            {{$replay->type->title}} ({{$replay->type->name}})
                                        </div>
                                    </div>                                  
                                    <div class="row">
                                        <div class="col-md-5">
                                            Локация:
                                        </div>
                                        <div class="col-md-7">
                                            {{$replay->first_location??"-"}} vs {{$replay->second_location??"-"}}
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-md-5">
                                            Оценка пользователей:
                                        </div>
                                        <div class="col-md-7">
                                            <a type="button" title="Править профиль пользователя"  data-toggle="modal" data-target="#modal-default_{{$replay->id}}"
                                               href="{{route('admin.replay.user_rating', ['id' => $replay->id])}}">
                                                {{$replay->user_rating}} ({{$replay->user_rating_count}})
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            Подтвержден:
                                        </div>
                                        <div class="col-md-7">
                                            {!! $replay->approved?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-clock-o text-red"></i>' !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            Файл:
                                        </div>
                                        <div class="col-md-7">
                                            <a href="{{route('replay.download', ['id'=>$replay->id])}}">Скачать Replay</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            Коментарий:
                                        </div>
                                        <div class="col-md-7">
                                            {!! $replay->content !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                @if($replay->video_iframe)
                                    <div class="video-link-wrapper">
                                        {!! $replay->video_iframe !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="user-block">
                            @if(isset($replay->user->avatar))
                                <img class="img-circle img-bordered-sm" src="{{route('home').$replay->user->avatar->link}}" alt="User img">
                            @else
                                <img class="img-circle img-bordered-sm" src="{{route('home').'/dist/img/avatar.png'}}" alt="User img">
                            @endif
                            <span class="username">
                                <a href="{{route('admin.user.profile', ['id' => $replay->user->id])}}">{{$replay->user->name}}</a>
                            </span>
                            <span class="description">{{$replay->created_at->format('h:m d-m-Y')}}</span>
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
                        <br>
                        <div>
                            <div class="box-body chat" id="chat-box">
                                <div class="box-footer">
                                    <form method="POST" action="{{route('admin.replay.comment_send', ['id' => $replay->id])}}" method="post">
                                        @csrf
                                        <div class="input-group">
                                            <input class="form-control" placeholder="Type comment..." type="text" name="content" >

                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- chat item -->
                                <div class="table-content"></div>
                                <!-- /.item -->
                            </div>
                            <div class="box-footer clearfix pagination-content">
                            <!-- /.chat -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-default_{{$replay->id}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Default Modal</h4>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('js')
    <script>
        $(function () {
            getUsers(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                var page = $(this).data('to-page');
                getUsers(page);
            })
        });

        function getUsers(page) {
            $.get('{{route('admin.comments', ['object_name' => 'replay', 'id' => $replay->id])}}?page='+page, {}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection