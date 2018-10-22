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
                    <h3 class="box-title">Тем ({{$data->total()}})</h3>
                    <a class="btn btn-info" href="{{route('admin.forum.topic.add')}}">Создать</a>
                    <div class="box-tools">
                        @include('admin.user.pagination')
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
                        <tbody>
                        @foreach($data->items() as $topic)
                            <tr>
                                <td>{{$topic->id}}</td>
                                <td><a href="{{route('forum.topic.index', ['id' => $topic->id])}}">{{$topic->title}}</a></td>
                                <td><a href="{{route('admin.forum_topic', ['section_id' => $topic->section->id])}}">{{$topic->section->title}}</a></td>
                                <td>
                                    <a href="{{route('admin.user.profile', ['id' => $topic->user->id])}}">{{$topic->user->name}}</a>
                                </td>

                                <td>
                                    <i class="fa fa-thumbs-o-up margin-r-5 text-green"></i>{{$topic->positive_count}} /
                                    <i class="fa fa-thumbs-o-down margin-r-5 text-red"></i>{{$topic->negative_count}}
                                    - ({{$topic->rating}})
                                </td>
                                <td>{{$topic->comments_count}}</td>
                                <td>{{$topic->reviews}}</td>
                                <td>{!! $topic->approved?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-ban text-red"></i>' !!}</td>
                                <td>{!! $topic->news?'<i class="fa fa-newspaper-o text-blue"></i>':'<i class="fa  fa-newspaper-o text-gray"></i>' !!}</td>
                                <td>
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-default text-aqua"  title="Просмотреть запись" href="{{route('admin.forum.topic.get', ['id' => $topic->id])}}"><i class="fa fa-eye"></i></a>
                                        <a type="button" class="btn btn-default text-orange"  title="Править запись"  href="{{route('admin.forum.topic.edit', ['id' => $topic->id])}}"><i class="fa fa-edit"></i></a>
                                        @if(!$topic->approved)
                                            <a type="button" class="btn btn-default text-green" title="Одобрить запись" href="{{route('admin.forum.topic.approve', ['id' => $topic->id])}}"><i class="fa fa-check"></i></a>
                                        @else
                                            <a type="button" class="btn btn-default text-red"  title="Заблокировать запись" href="{{route('admin.forum.topic.unapprove', ['id' => $topic->id])}}"><i class="fa fa-ban"></i></a>
                                        @endif
                                        @if(!$topic->news)
                                            <a type="button" class="btn btn-default text-blue" title="Сделать новостью" href="{{route('admin.forum.topic.news', ['id' => $topic->id])}}"><i class="fa fa-newspaper-o"></i></a>
                                        @else
                                            <a type="button" class="btn btn-default text-grey"  title="Убрать из новостей" href="{{route('admin.forum.topic.not_news', ['id' => $topic->id])}}"><i class="fa fa-newspaper-o"></i></a>
                                        @endif
                                        <a type="button" class="btn btn-default text-red"  title="Удалить запись" href="{{route('admin.forum.topic.remove', ['id' => $topic->id])}}"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    @include('admin.user.pagination')
                </div>
            </div>
        </div>
@endsection

@section('js')

@endsection