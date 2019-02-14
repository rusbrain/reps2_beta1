@extends('admin.layouts.admin')

@section('css')
@endsection

@section('page_header')
    Темы форума
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.forum_topic')}}">Темы Форума</a></li>
    <li class="active">{{$topic->title}}</li>
@endsection

@section('content')
    @inject('general_helper', 'App\Services\GeneralViewHelper')

    <div class="col-md-10 col-md-offset-1">
        <div class="load-wrapp">
            <div class="load-3">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">{{$topic->section->title}} / {{$topic->title}}</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                        @if($topic->preview_file_id)
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 text-center">
                                    <img class="img-bordered-sm" src="{{route('home').$topic->preview_image->link}}" alt="user image">
                                </div>
                            </div>
                            <br>
                        @endif
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <p>
                                    {!! $general_helper->oldContentFilter($topic->preview_content) !!}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <p>
                                    {!! $general_helper->oldContentFilter($topic->content) !!}
                                </p>
                            </div>
                        </div>
                        <br>
                        <div class="user-block">
                            @if(isset($topic->user->avatar))
                                <img class="img-circle img-bordered-sm" src="{{route('home').$topic->user->avatar->link}}" alt="User img">
                            @else
                                <img class="img-circle img-bordered-sm" src="{{route('home').'/dist/img/avatar.png'}}" alt="User img">
                            @endif
                            <span class="username">
                                <a href="{{route('admin.user.profile', ['id' => $topic->user->id])}}">{{$topic->user->name}}</a>
                            </span>
                            <span class="description">{{$topic->created_at->format('h:m d-m-Y')}}</span>
                        </div>
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
                            <br>
                        <div>
                                <div class="box-body chat" id="chat-box">
                                    <div class="box-footer">
                                        <form method="POST" action="{{route('admin.forum.topic.comment_send', ['id' => $topic->id])}}" method="post">
                                            @csrf
                                            <div class="input-group">
                                                <input class="form-control" placeholder="Type message..." type="text" name="content" >

                                                <div class="input-group-btn">
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="table-content"></div>
                                </div>
                            <div class="box-footer clearfix pagination-content">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script>
        $(function () {
            getUsers(1);
            $('.pagination-content').on('click', '.pagination-push', function () {
                $('.load-wrapp').show();
                let page = $(this).data('to-page');
                getUsers(page);
            })
        });

        function getUsers(page) {
            $.get('{{route('admin.comments', ['object_name' => 'topic', 'id' => $topic->id])}}?page='+page, {}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection