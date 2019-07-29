
@extends('admin.layouts.admin')

@section('css')
    <link rel="stylesheet"
          href="{{route('home')}}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{route('home')}}/plugins/iCheck/all.css">

    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection

@section('page_header')
    Добавить в свою изображение
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li><a href="{{route('admin.chat.pictures')}}">Chat</a></li>
    <li class="active">изображение</li>
@endsection

@section('content')

<div class="col-md-10 col-md-offset-1">

    <div class="box ">
        <div class="box-header with-border">
            <h3 class="box-title">Добавить в свою изображение</h3>
        </div>
        <div class="box-body">
            <div class="box-tools col-md-12">
                <div class="post">
                    <form action="{{route('admin.chat.pictures.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="row col-md-12">
                                <div class="col-md-4">
                                    <div class="box-header">
                                        <h3 class="box-title">Загрузить изображение:</h3>
                                        <!-- /. tools -->
                                    </div>
                                    <div class="form-group">
                                        <input type="file" id="image" name="image" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}">
                                    </div>
                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="">Kатегория</span>
                                        <select class="form-control select2" name="category">
                                            <option value=''>Select Category</oteanion>
                                            @foreach ($categories as $category)
                                                <option value='{{$category}}'>{{$category}}</option>                                             
                                            @endforeach
                                        </select>                
                                    </div> 
                                    @if ($errors->has('category'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif        
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="">Персонажи</span>
                                        <input type="text" class="form-control" placeholder="Персонажи" name="charactor" value="{{old('charactor')}}" > 
                                                
                                    </div>
                                    @if ($errors->has('charactor'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('charactor') }}</strong>
                                        </span>
                                    @endif 
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="">Подпись</span>
                                        <input type="text" class="form-control" placeholder="Подпись" name="comment" value='{{old('comment')}}'> 
                                    </div>
                                    @if ($errors->has('comment'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('comment') }}</strong>
                                        </span>
                                    @endif         
                                </div>
                                
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</div>
@endsection


@section('js')
    <!-- FastClick -->
    <script src="{{route('home')}}/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{route('home')}}/dist/js/demo.js"></script>

    <!--SCEditor -  WYSIWYG BBCode editor -->
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.xhtml.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/languages/ru.js"></script>

    <script src="{{route('home')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="{{route('home')}}/plugins/iCheck/icheck.min.js"></script>
@endsection
   