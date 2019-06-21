@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries();@endphp

@section('sidebar-left')
    <!-- All Forum Topics -->
    @include('sidebar-widgets.search-replay-form')
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
                    <a href="" class="active">/ {!! $title !!}</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>{!! $title !!}</div>
        </div>
        <!--  REPLAY LIST -->
        <div id="ajax_section_replays_list"
            @if($replay_type == 'search')
             data-path="{{route('replay.search.paginate').'?'.$request}}">
            @else
             data-path="{{(isset($type) && $type) ? route('replay.'.$replay_type.'_type.paginate', ['type' => $type]).'?'.$request : route('replay.'.$replay_type.'.paginate').'?'.$request}}">
            @endif
            <div class="load-wrapp">
                <img src="/images/loader.gif" alt="">
            </div>
        </div>
        <!-- END REPLAY LIST -->
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

    <!-- Top Points Users-->
    @include('sidebar-widgets.top-pts-users')
    <!-- END New Users-->

    <!-- Top Rating Users-->
    @include('sidebar-widgets.top-rating-users')
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
            var container = $('#ajax_section_replays_list');
            var path = container.attr('data-path');
            var body = $("html, body");

            $.get(path + '&page=' + page, {}, function (data) {
                container.html(data.replays);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();

                /**move to top of page*/
                moveToTop(body);
            });
        }
    </script>
@endsection