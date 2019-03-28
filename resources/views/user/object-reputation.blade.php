@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')

@section('sidebar-left')
    @include('sidebar-widgets.votes')
    @include('sidebar-widgets.gosu-replays')
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
                    <a href="{{route('user_profile',['id' => Auth::id()])}}">/ Мой Аккаунт</a>
                </li>
                <li>
                    <a href="" class="active">/ Репутация</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box object-reputation">
        <div class="col-md-12 section-title">
            <div>Информация:</div>
        </div>
        <div class="user-post-info">
            <div class="display-flex align-items-center">
                <a href="{{route($route,['id'=>$object->id])}}"
                   class="margin-left-10">{{$object->title??$object->comment}}</a>
            </div>
            <div class="display-flex align-items-center">
                <img src="{{route('home')}}/images/icons/eye.png" class="mr-1" alt="">
                <span>{{\Carbon\Carbon::parse($object->created_at)->format('H:i d.m.Y')}}</span>
                <a href="{{route($route,['id'=>$object->id])}}"
                   class="link-to-post margin-left-15">#{{$object->id}}</a>
            </div>
        </div>
        <div class="user-info">
            <div class="user-post-content w-100">
                @if($object->preview_content || $object->content)
                    {!! $general_helper->oldContentFilter($object->preview_content ?? mb_substr($object->content,0,100,'UTF-8').' ...')!!}
                @else
                @endif
                <div class="user-post-content-footer">
                    <div>
                        @if($object->reviews)
                            <img src="{{route('home')}}/images/icons/eye.png"
                                 class="margin-right-5" alt="">
                            <span class="margin-right-20">{{$object->reviews}}</span>
                        @endif
                        <img src="{{route('home')}}/images/icons/message-square-empty.png"
                             class="margin-right-5" alt="">
                        <span>{{$object->comments_count}}</span>
                    </div>
                    <div>
                        <a href="{{route($route,['id'=>$object->id])}}#comments">
                            <img src="{{route('home')}}/images/icons/message-square-blue.png"
                                 alt="" class="margin-right-15">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>История репутации</div>
            <div class="user-reputation-qty">
                <span class="reputation-vote-up"></span>
                <span class="reputation-qty">{{$object->positive_count}}</span>
                <span class="reputation-vote-down"></span>
                <span class="reputation-qty">{{$object->negative_count}}</span>
            </div>
        </div>
        <!--  CONTENT -->
        <div id="ajax_topic_reputation" data-path="{{route($pagination_path,['id' => $object->id])}}">
            <div class="load-wrapp">
                <img src="/images/loader.gif" alt="">
            </div>
        </div>
        <!-- END CONTENT -->
    </div><!-- close div /.content-box -->

    <!--  PAGINATION -->
    <div class="pagination-content"></div>
    <!-- END  PAGINATION -->
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

@section('js')
    <script>
        $(function () {
            getSections(1);
            $('.pagination-content').on('click', '.page-link', function (e) {
                e.preventDefault();
                $('.load-wrapp').show();
                var page = $(this).attr('data-page');
                getSections(page);
            })
        });
        function getSections(page) {
            var container = $('#ajax_topic_reputation');
            var body = $("html, body");
            var path = container.attr('data-path');

            $.get(path + '?page=' + page, {}, function (data) {
                container.html(data.list);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();

                /**move to top of page*/
                moveToTop(body);
            });
        }
    </script>
@endsection