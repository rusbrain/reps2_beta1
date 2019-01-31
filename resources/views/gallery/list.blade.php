@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('sidebar-left')
    <!-- User Gallery widget -->
    @include('sidebar-widgets.user-gallery',['user' => Auth::user(),'gallery' => $general_helper->getUserGallery(Auth::id())])
    <!-- END User Gallery widget -->
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
                    <a href="{{route('user_profile',['id' =>Auth::id()])}}">/ Мой Аккаунт</a>
                </li>
                <li>
                    <a href="" class="active">/ Галерея</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END Breadcrumbs -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Загрузить изображение:</div>
        </div>
        <div class="col-md-12">
            <form action="{{route('gallery.store')}}" class="user-gallery-form" enctype="multipart/form-data"
                  id="user-gallery-form" method="POST">
                @csrf
                <div class="form-group">
                    <input type="file" id="image" class="form-control-file image" name="image">
                </div>
                <div class="form-group">
                    <label for="comment">Подпись:</label>
                    <input type="text" id="comment"
                           class="form-control {{ $errors->has('comment') ? ' is-invalid' : '' }}"
                           name="comment" value="{{old('comment')}}">
                    @if ($errors->has('comment'))
                        <span class="invalid-feedback">
                                <strong>{{ $errors->first('comment') }}</strong>
                            </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="for_adults" class="display-flex align-items-center">
                        <input type="checkbox" name="for_adults" id="for_adults"
                               class="margin-right-5 {{ $errors->has('for_adults') ? ' is-invalid' : '' }}"
                               value="1" @if(old('for_adults')) checked @endif>
                        <span>18+</span>
                        @if ($errors->has('for_adults'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('for_adults') }}</strong>
                            </span>
                        @endif
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-blue btn-form">Добавить</button>
                </div>
            </form>
        </div>
    </div><!-- close div /.content-box -->

    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Галерея</div>
        </div>
        <div class="col-md-12">
            <div class="user-gallery-wrapper masonry " data-columns>
                @foreach($photos as $photo)
                    <div class="img-wrapper">
                        <a href="{{route('gallery.view',['id'=>$photo->id])}}">
                            <img src="{{$photo->file->link}}" alt="">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div><!-- close div /.content-box -->

    <!--  PAGINATION -->
    @php  $data = $photos @endphp
    @include('pagination')
    <!-- END  PAGINATION -->

@endsection

@section('sidebar-right')
    <!--Banners-->
    @include('sidebar-widgets.banner')
    <!-- END Banners -->

    <!-- New Users-->
    @include('sidebar-widgets.new-users')
    <!-- END New Users-->

    <!-- User's Replays-->
    @include('sidebar-widgets.users-replays')
    <!-- END User's Replays-->

    <!-- Gallery -->
    @include('sidebar-widgets.random-gallery')
    <!-- END Gallery -->
@endsection