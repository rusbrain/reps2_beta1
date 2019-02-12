@extends('admin.layouts.admin')

@section('css')
@endsection

@section('page_header')
    Темы форума
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>Главная панель</a></li>
    <li class="active">Темы форума</li>
@endsection

@section('content')
        <div class="col-md-12">
            <div class="box">
                <div class="load-wrapp">
                    <div class="load-3">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                </div>
                <div class="box-header with-border">
                    <h3 class="box-title">Поиск Тем</h3>
                </div>
                <div class="box-body">
                    <div class="box-tools col-md-12">
                        <form>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Поиск(Название, содержание):</label>
                                    <input type="text" class="form-control" name="text" placeholder="Enter ..." value="{{$request_data['text']??''}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Раздел:</label>
                                    <select class="form-control" style="width: 100%;" name="section_id">
                                        <option value="">Select...</option>
                                        @foreach($sections as $section)
                                            <option value="{{$section->id}}" @if(isset($request_data['section_id']) && $request_data['section_id'] == $section->id) selected @endif>{{$section->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Новости:</label>
                                    <select class="form-control" style="width: 100%;" name="news">
                                        <option value="">Select...</option>
                                        <option value="0" @if(isset($request_data['news']) && $request_data['news'] == '0') selected @endif>Нет</option>
                                        <option value="1" @if(isset($request_data['news']) && $request_data['news'] == '1') selected @endif>Да</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Одобрен:</label>
                                    <select class="form-control" style="width: 100%;" name="approved">
                                        <option value="">Select...</option>
                                        <option value="0" @if(isset($request_data['approved']) && $request_data['approved'] == '0') selected @endif>Нет</option>
                                        <option value="1" @if(isset($request_data['approved']) && $request_data['approved'] == '1') selected @endif>Да</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-md-offset-9">
                                    <label>Сортировать по:</label>
                                    <select class="form-control" style="width: 100%;" name="sort">
                                        <option value="">Select...</option>
                                        <option value="id" @if(isset($request_data['sort']) && $request_data['sort'] == 'id') selected @endif>ID</option>
                                        <option value="title" @if(isset($request_data['sort']) && $request_data['sort'] == 'title') selected @endif>Название</option>
                                        <option value="section_id" @if(isset($request_data['sort']) && $request_data['sort'] == 'section_id') selected @endif>Раздел</option>
                                        <option value="rating" @if(isset($request_data['sort']) && $request_data['sort'] == 'rating') selected @endif>Рейтинг</option>
                                        <option value="comments_count" @if(isset($request_data['sort']) && $request_data['sort'] == 'comments_count') selected @endif>Коментарии</option>
                                        <option value="reviews" @if(isset($request_data['sort']) && $request_data['sort'] == 'reviews') selected @endif>Просмотры</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Поиск</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Тем ({{$topics_count}})</h3>
                    <a class="btn btn-info" href="{{route('admin.forum.topic.add')}}">Создать</a>
                    <div class="box-tools pagination-content">
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 30px">ID</th>
                            <th>Название</th>
                            <th>Раздел</th>
                            <th>Автор</th>
                            <th>Рейтинг</th>
                            <th>Комментарии</th>
                            <th>Просмотры</th>
                            <th>Одобрена</th>
                            <th>Новость</th>

                            <th style="width: 220px">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="table-content">
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix pagination-content">
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
            $.get('{{route('admin.forum_topic.pagination')}}?page='+page, {!! json_encode($request_data) !!}, function (data) {
                $('.table-content').html(data.table);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();
            })
        }
    </script>
@endsection