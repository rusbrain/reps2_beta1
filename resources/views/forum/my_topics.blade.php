@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('sidebar-left')
    <!-- All Forum Topics -->
    @include('sidebar-widgets.all-forum-sections')
    <!-- END All Forum Topics -->
@endsection

@section('content')

    <!-- Breadcrumbs -->
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li>
                    <a href="/">Главная</a>
                </li>
                <li>
                    <a href="{{route('user_profile',['id' =>Auth::id()])}}">/ Мой Аккаунт</a>
                </li>
                <li>
                    <a href="#" class="active">/ Мои темы</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    @if(Auth::user())
        <div>
            <a href="{{route('forum.topic.create')}}" class="btn-blue create-theme-btn">Создать тему</a>
        </div>
    @endif

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Мои темы</div>
        </div>

        @if($topics)
            <div class="accordion user-posts" id="user-posts">
                @php $s = 0 @endphp
                @foreach($topics as $section)
                    <div class="card">
                        <div class="card-header" id="heading_post_id_{{$s}}">
                            <a class="user-section-title {{$s != 0 ? 'collapsed' : ''}}" data-toggle="collapse"
                               data-target="#post_id_{{$s}}" aria-expanded="{{$s != 0 ? 'false' : 'true'}}"
                               aria-controls="post_id_{{$s}}">
                                {{$section->title}}
                                <span class="icon_collapse {{$s == 0 ? 'open' : 'close'}}"></span>
                            </a>
                        </div>
                        @if($section->topics)
                            <div id="post_id_{{$s}}"
                                 class="collapse {{$s == 0 ? 'show' : ''}} user-section-post-wrapper"
                                 aria-labelledby="heading_post_id_{{$s}}"
                                 data-parent="#user-posts">
                                @foreach($section->topics as $topic)
                                    <div class="card-body">
                                        <div class="user-post-info">
                                            <div class="display-flex align-items-center">
                                                <a href="{{route('forum.section.index', ['name' => $section->name])}}"
                                                   class="margin-right-10">{{$section->title}} </a>
                                                <span> | </span>
                                                <a href="{{route('forum.topic.index',['id'=>$topic->id])}}"
                                                   class="margin-left-10">{{$topic->title}}</a>
                                            </div>
                                            <div class="display-flex align-items-center">
                                                <img src="{{route('home')}}/images/icons/eye.png" class="mr-1" alt="">
                                                <span>{{\Carbon\Carbon::parse($topic->created_at)->format('H:i d.m.Y')}}</span>
                                                <a href="{{route('forum.topic.index',['id'=>$topic->id])}}"
                                                   class="link-to-post margin-left-15">#{{$topic->id}}</a>
                                            </div>
                                        </div>
                                        <div class="user-post-content">
                                            {!! $general_helper->oldContentFilter($topic->preview_content ?? mb_substr($topic->content,0,100,'UTF-8').' ...')!!}
                                            <div class="user-post-content-footer">
                                                <div>
                                                    <img src="{{route('home')}}/images/icons/eye.png"
                                                         class="margin-right-5" alt="">
                                                    <span class="margin-right-20">{{$topic->reviews}}</span>
                                                    <img src="{{route('home')}}/images/icons/message-square-empty.png"
                                                         class="margin-right-5" alt="">
                                                    <span>{{$topic->comments_count}}</span>
                                                </div>
                                                <div>
                                                    <a href="{{route('forum.topic.index',['id'=>$topic->id])}}#comments">
                                                        <img src="{{route('home')}}/images/icons/message-square-blue.png"
                                                             alt="" class="margin-right-15">
                                                    </a>
                                                    @if($general_helper->checkForumEdit($topic))
                                                        <a href="{{route('forum.topic.edit',['id'=>$topic->id])}}"
                                                           class="user-theme-edit">
                                                            <img src="{{route('home')}}/images/icons/svg/edit_icon.svg"
                                                                 alt="">
                                                            <span>Редактировать</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- close div /.card-body -->
                                @endforeach
                            </div><!-- close div /.user-section-post-wrapper -->
                        @else
                            <div id="post_id_{{$s}}" class="collapse show user-section-post-wrapper"
                                 aria-labelledby="heading_post_id_{{$s}}"
                                 data-parent="#user-posts">
                                <div class="card-body">
                                    Список пуст
                                </div><!--close div /.card-body-->
                            </div>
                        @endif
                    </div>
                    @php $s++; @endphp
                @endforeach
            </div>
        @else
            <div class="col-md-12">
                <div class="text-center padding-top-bottom-10">Список пуст</div>
            </div>
        @endif
    </div><!-- close div /.content-box -->
@endsection

@section('sidebar-right')
    <!--Banners-->
    @include('sidebar-widgets.banner')
    <!-- END Banners -->

    <!-- New Users-->
    @include('sidebar-widgets.new-users')
    <!-- END New Users-->

    <!-- User's Replays-->
    @include('sidebar-widgets.users-replays')
    <!-- END User's Replays-->

    <!-- Gallery -->
    @include('sidebar-widgets.random-gallery')
    <!-- END Gallery -->
@endsection