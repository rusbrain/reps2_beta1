@extends('layouts.site')
@section('content')
    <div class="">
        <div class="row">
            <div class="page-title w-100">Список Ваших друзей</div>
            <div class="col-12">
                @if($friends->count() > 0)
                    <div class="row ignored-user-header">
                        <div class="col-md-1">#</div>
                        <div class="col-md-2">name</div>
                        <div class="col-md-4">email</div>
                        <div class="col-md-3">Дата</div>

                        <div class="col-md-2">action</div>
                    </div>
                    @foreach($friends as $k => $item)
                        <div class="row ignored-user">
                            <div class="col-md-1">{{$k}}</div>
                            <div class="col-md-2">
                                <a href="{{route('user_profile',['id'=>$item->id])}}">{{$item->name}}</a>
                            </div>
                            <div class="col-md-4">{{$item->email}}</div>
                            <div class="col-md-3">{{$item->created_at}}</div>
                            <div class="col-md-2 ">
                                <a class="error" href="{{route('user.remove_friend',['id' => $item->id])}}"
                                   title="удалить из друзей"><i class="far fa-trash-alt"></i></a>
                                <a class="primery" title="написать сообщение"
                                   href="{{route('user.messages',['id' => $item->id])}}">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="">В данный момент список пуст</p>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="page-title w-100">Вас добавили в друзья</div>
            <div class="col-12">
                @if($friendly->count() > 0)
                    <div class="row ignored-user-header">
                        <div class="col-md-1">#</div>
                        <div class="col-md-2">name</div>
                        <div class="col-md-4">email</div>
                        <div class="col-md-3">Дата</div>
                        <div class="col-md-2">action</div>
                    </div>
                    @foreach($friendly as $k => $item)
                        <div class="row ignored-user">
                            <div class="col-md-1">{{$k}}</div>
                            <div class="col-md-2">
                                <a href="{{route('user_profile',['id'=>$item->id])}}">{{$item->name}}</a>
                            </div>
                            <div class="col-md-4">{{$item->email}}</div>
                            <div class="col-md-3">{{$item->created_at}}</div>
                            <div class="col-md-2 ">
                                <a class="success" href="{{route('user.add_friend',['id' => $item->id])}}"
                                   title="Добавить в друзья"><i class="fas fa-plus-circle"></i></a>
                                <a class="primary" title="написать сообщение"
                                   href="{{route('user.messages',['id' => $item->id])}}">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="">В данный момент список пуст</p>
                @endif
            </div>
        </div>
    </div>
@endsection
