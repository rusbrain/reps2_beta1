@extends('admin.layouts.admin')

@section('css')
@endsection

@section('page_header')
    Темы форума
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.users.gallery')}}">Галерея</a></li>
    <li class="active">{{$gallery->id}}</li>
@endsection

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title text-blue">{{$gallery->comment}}</h3>
            </div>
            <div class="box-body">
                <div class="box-tools col-md-12">
                    <div class="post">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 text-center">
                                    <img class="img-bordered-sm" src="{{route('home').'/'.$gallery->file->link}}">
                                </div>
                            </div>
                            <br>
                        <br>
                        <div class="user-block">
                            @if(isset($gallery->user->avatar))
                                <img class="img-circle img-bordered-sm" src="{{route('home').$gallery->user->avatar->link}}" alt="User img">
                            @else
                                <img class="img-circle img-bordered-sm" src="{{route('home').'/dist/img/avatar.png'}}" alt="User img">
                            @endif
                            <span class="username">
                                <a href="{{route('admin.user.profile', ['id' => $gallery->user->id])}}">{{$gallery->user->name}}</a>
                            </span>
                            <span class="description">{{$gallery->created_at->format('h:m d-m-Y')}}</span>
                        </div>
                            <ul class="list-inline">
                                <li class="pull-right">
                                    <p  class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i>
                                        {{$gallery->comments_count}}</p></li>
                                <li class="pull-right">
                                    <p  class="link-black text-sm"><i class="fa fa-thumbs-o-down margin-r-5 text-red"></i>
                                        {{$gallery->negative_count}}</p></li>
                                <li class="pull-right">
                                    <p  class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5 text-green"></i>
                                        {{$gallery->positive_count}}</p></li>
                            </ul>
                            <br>
                        <div>
                                <div class="box-body chat" id="chat-box">
                                    <div class="box-footer">
                                        <form method="POST" action="{{route('admin.user.gallery.comment_send', ['id' => $gallery->id])}}" method="post">
                                            @csrf
                                            <div class="input-group">
                                                <input class="form-control" placeholder="Type message..." type="text" name="content" >

                                                <div class="input-group-btn">
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- chat item -->
                                    @foreach($gallery->comments as $comment)
                                        <div class="item row">
                                            <div class="row">
                                                <p class="message col-md-10 col-md-offset-1">
                                                    {{$comment->content}}
                                                </p>
                                                <a type="button" class="btn btn-default text-red"  title="Удалить запись" href="{{route('admin.forum.topic.comment.remove', ['id' => $comment->id])}}"><i class="fa fa-trash"></i></a>
                                            </div>
                                            <div class=" user-block">
                                                @if(isset($comment->user->avatar))
                                                    <img class="img-circle img-bordered-sm" src="{{route('home').$comment->user->avatar->link}}" alt="User img">
                                                @else
                                                    <img class="img-circle img-bordered-sm" src="{{route('home').'/dist/img/avatar.png'}}" alt="User img">
                                                @endif
                                                <span class="username">
                                                        <a href="{{route('admin.user.profile', ['id' => $comment->user->id])}}">{{$comment->user->name}}</a>
                                                    </span>
                                                <span class="description">{{$comment->created_at->format('h:m d-m-Y')}}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!-- /.item -->
                                </div>
                            @if($gallery->comments_count > 20)
                                @php
                                    $last_page = ($gallery->comments_count - ($gallery->comments_count%20))/20 + ($gallery->comments_count%20?1:0);
                                @endphp
                                <ul class="pagination pagination-sm no-margin pull-right">
                                    @for($i = 1; $i <= $last_page; $i++)
                                        <li><a href="{{route('admin.users.gallery.view', ['id' => $gallery->id, 'page' => $i])}}">{{$i}}</a></li>
                                    @endfor
                                </ul>
                            @endif
                                <!-- /.chat -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection