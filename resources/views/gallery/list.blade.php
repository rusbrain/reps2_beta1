@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php
    $countries = $general_helper->getCountries();
    if(Auth::user()){
        $gallery = $general_helper->getUserGallery(Auth::id());
    }
@endphp
@section('content')
    <div class="row">
        <div class="col-md-3 left-inner-gallery-sidebar">
            @foreach($gallery as $item)
                <a href="{{route('gallery.view',['id'=> $item->id])}}" class="user-gallery-images"
                   style="font-size: 12px; color: grey">
                    {{$item->file->title}}
                </a>
            @endforeach
        </div>
        <div class="col-md-9 border-gray">
            <div class="row">
                <div class="col">
                    <form action="{{route('gallery.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-header">
                                    <h3 class="box-title">Загрузить изображение:</h3>
                                    <!-- /. tools -->
                                </div>
                                <div class="form-group">
                                    <input type="file" id="image" name="image" class="filestyle form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group ">
                                    <label class="margin-right-15">Подпись:</label>
                                    <input type="text" class="form-control " value="{{old('comment')}}"
                                           placeholder="Подпись" name="comment">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <label for="for_adults">
                                        <input type="checkbox" name="for_adults" id="for_adults" class="flat-red"
                                               value="1">
                                        <span>18+</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col user-gallery-img-wrapper">
                    @foreach($photos as $photo)
                        <div class="img-wrapper">
                            <a href="{{route('gallery.view',['id'=>$photo->id])}}">
                                <img src="{{$photo->file->link}}" alt="">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            @php $data = $photos @endphp
            <div class="row margin-top-20">
                {{--                @include('pagination')--}}
            </div>
        </div>
    </div>
@endsection