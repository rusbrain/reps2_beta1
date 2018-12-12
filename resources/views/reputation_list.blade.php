@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php $countries = $general_helper->getCountries();@endphp
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title row">Информация о пользователе {{$user->name}}</div>
            <div class="info-wrapper">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="info-title col-4">Имя:</div>
                            <div class="info-title col-8">{{$user->name}}</div>
                        </div>
                        <div class="row">
                            <div class="info-title col-4">Страна:</div>
                            <div class="info-title col-8">
                                @if($user->country_id)
                                    <span class="flag-icon flag-icon-{{mb_strtolower($countries[$user->country_id]->code)}}"></span>
                                    <span>{{$countries[$user->country_id]->name}}</span>
                                @else
                                    <span>не указано</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="info-title col-4">Репутация:</div>
                            <div class="info-title col-8">{{$user->rating}}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if($user->view_avatars == 1)
                            @if($user->avatar)
                                <img class="img-responsive " src="{{$user->avatar->link??''}}" alt="Аватар">
                            @else
                                <span class="text-center">Аватар отсутствует</span>
                            @endif

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="page-title row"> История репутации участника {{$user->name}}:
                [+{{$user->positive_count}}/-{{$user->negative_count}}]
            </div>
            <div class="reputation-history row">
                @if($list)
                    @foreach($list as $item)
                        <div class="w-100">
                            <div class="reputation-title col-md-12">
                                # - {{$item->created_at}}
                            </div>
                            <div class="reputation-comment-wrapper">
                                <div class="reputation-comment col-md-9">{!! $item->comment !!}</div>
                                <div class="reputation-comment col-md-3">
                                    @if($item->rating == 1)
                                        <i class="fas fa-thumbs-up positive"></i>
                                    @else
                                        <i class="fas fa-thumbs-down negative"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div>Комментарии отсутствуют</div>
                @endif
            </div>
        </div>
    </div>
@endsection