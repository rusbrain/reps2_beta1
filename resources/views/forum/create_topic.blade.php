@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="content-center">
                <div class="page-title w-100">Создание поста</div>
                <div class="edit-topic-form">
                    <form method="post" action="{{route('forum.topic.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="section_id">Раздел:</label>
                                    <select class="form-control" id="section_id" name="section_id">
                                        @foreach($sections as $section)
                                            <option value="{{$section->id}}"
                                                    {{$section->id == old('section_id')?'selected':''}}>
                                                {{$section->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('section_id'))
                                        <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('section_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="box-title">Название:</label>
                                <input type="text" name="title" class="form-control" placeholder="Название..."
                                       value="{{old('title')}}">
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-header">
                                    <label class="box-title">Превью:</label>
                                </div>
                                <img class="img-responsive"
                                     src="{{route('home').('/dist/img/default-50x50.gif')}}"
                                     alt="Photo">
                                <br>
                                <div class="form-group">
                                    <label for="exampleInputFile">Загрузить картинку</label>
                                    <input type="file" id="preview_img" class="form-control filestyle"
                                           name="preview_img">
                                </div>
                                @if ($errors->has('preview_img'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('preview_img') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="preview_content" class="preview_content">Сокращенное содержание:</label>
                                    <textarea id="preview_content"
                                              class="form-control" name="preview_content"
                                              rows="5">{!! old('preview_content') !!}</textarea>
                                </div>
                                @if ($errors->has('preview_content'))
                                    <span class="invalid-feedback text-red" role="alert">
                                        <strong>{{ $errors->first('preview_content') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content" class="box-title">Содержание:</label>
                                    <textarea id="content"
                                              class="form-control" name="content"
                                              rows="10">{!! old('content') !!}</textarea>
                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Date -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="datepicker" class="box-title">Опубликовать с:</label>
                                    <div class="input-group date">
                                        <i class="fa fa-calendar"></i>
                                        <input type="date" name="start_on" class="form-control pull-right"
                                               id="datepicker" value="{{old('start_on')}}">
                                        @if ($errors->has('start_on'))
                                            <span class="invalid-feedback text-red" role="alert">
                                                <strong>{{ $errors->first('start_on') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-11">
                                <br>
                                <button type="submit" class="btn btn-primary form-control">
                                    Сохранить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        /**ckeditor*/
        $(function () {
            CKEDITOR.replace( 'content' );
        });

        /**ckeditor*/
        $(function () {
            CKEDITOR.replace( 'preview_content' );
        });
    </script>
@endsection