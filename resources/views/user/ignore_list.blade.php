@extends('layouts.site')
@section('content')
    <div class="">
        <div class="row">
            <div class="page-title w-100">Список заигнорированых пользователей</div>
            <div class="col-12">
                @if($users->count() > 0)
                    <div class="row ignored-user-header">
                        <div class="col-md-1">#</div>
                        <div class="col-md-2">name</div>
                        <div class="col-md-4">email</div>
                        <div class="col-md-3">Дата</div>
                        <div class="col-md-2">action</div>
                    </div>
                    @foreach($users as $k => $item)
                        <div class="row ignored-user">
                            <div class="col-md-1">{{$k}}</div>
                            <div class="col-md-2">{{$item->ignored_user->name}}</div>
                            <div class="col-md-4">{{$item->ignored_user->email}}</div>
                            <div class="col-md-3">{{$item->created_at}}</div>
                            <div class="col-md-2 ">
                                <a class="error" href="{{route('user.set_not_ignore',['id' => $item->ignored_user_id])}}"
                                   title="удалить из игнор листа"><i class="far fa-trash-alt"></i></a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="">Ваш игнор лист пуст</p>
                @endif
            </div>
        </div>
    </div>
@endsection