 @extends('admin.layouts.admin')
 @inject('general_helper', 'App\Services\GeneralViewHelper')
 <?php
 $countries = $general_helper->getCountries();
 $races = \App\Replay::$races;
 $extraSmiles = $general_helper->getextraSmiles();
 ?>
@section('css')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
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
            <div class="load-wrapp">
                <div class="load-3">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
            </div>
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
                                                <textarea id="comment_content" class="form-control" placeholder="Type comment..." type="text" name="content" rows="5" cols="80">
                                                </textarea>

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
@endsection

@section('js')
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.xhtml.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/languages/ru.js"></script>

    <script src="{{route('home')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{route('home')}}/plugins/iCheck/icheck.min.js"></script>

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
            $.get('{{route('admin.comments', ['object_name' => 'gallery', 'id' => $gallery->id])}}?page='+page, {}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();
            })
        }


        $('#datepicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        });

        $(function () {
            addCountries();
            addRaces();
            addUpload();

            if ($('#comment_content').length > 0) {
                var comment_content = document.getElementById('comment_content');
                var extraSmiles = <?php echo json_encode($extraSmiles) ?>;
                sceditor.create(comment_content, {
                    format: 'xhtml',
                    style: '{{route("home")}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route("home")}}' + '/images/',
                    locale: 'ru',
                    toolbar: 'bold,italic,underline|' +
                        'left,center,right,justify|' +
                        'font,size,color,removeformat|' +
                        'source,quote,code|' +
                        'image,link,unlink|' +
                        'emoticon|' +
                        'date,time|' +
                        'countries|'+
                        'races|'+
                        'img|' +
                        'upload',
                    emoticons: {
                        // Emoticons to be included in the dropdown
                        dropdown: getAllSmiles(extraSmiles),
                        // Emoticons to be included in the more section
                        more: getMoreSmiles()
                    }
                });
            }
        });
    </script>
@endsection
