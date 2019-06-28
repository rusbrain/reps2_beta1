@inject('general_helper', 'App\Services\GeneralViewHelper')
@php 
    $countries = $general_helper->getCountries();
    $n = 0;
@endphp

<div>
    <a href="{{route('stream.create')}}" class="btn-blue create-theme-btn">Создать</a>
</div>

@if(!empty($streams))
    @foreach($streams as $my_stream)  
    <div class="content-box">    
        @if($n == 0)  
            <div class="col-md-12 section-title">
                <h1>Мои Cтрим</h1>
            </div>         
        @endif
        <div class="col-md-12 mystream-wrapper">               
            <div class="stream-title">
                <h2>{!! $my_stream->title !!}</h2> 
                <div> 
                    @if($my_stream->country_id)
                        <span class="flag-icon flag-icon-{{mb_strtolower($countries[$my_stream->country_id]->code)}}"></span>
                    @else
                        <span class="flag-icon"></span>
                    @endif

                    @if($my_stream->race)
                        <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons[$my_stream->race]}}" alt="">
                    @else
                        <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons['All']}}" alt="">
                    @endif
                </div>
                <a href="{{$general_helper->UrlFilter($my_stream->stream_url)}}" target="_blank">
                    {{$general_helper->UrlFilter($my_stream->stream_url)}}
                </a>
            </div>                
            
            <div class="mystream-info">
                @if($my_stream->user->avatar)
                    <a href="{{route('user_profile',['id' => $my_stream->user->id])}}">
                        <img src="{{$my_stream->user->avatar->link}}" class="margin-right-10" alt="">
                    </a>
                @else
                    <a href="{{route('user_profile',['id' => $my_stream->user->id])}}"
                        class="logged-user-avatar">A</a>
                @endif
                <a href="{{route('user_profile',['id' => $my_stream->user->id])}}"
                    class="margin-right-30">{{$my_stream->user->name}}</a>           
            </div>
            <div class="mystream-content">
                {!! $general_helper->closeAllTags($general_helper->oldContentFilter(mb_substr($my_stream->content,0,250,'UTF-8').' ...'))!!}
            </div>
            <div class="mystream-footer">                    
                <div>
                    <span class="stream_id">#{{$my_stream->id}}</span>
                    <span class="approved">Подтвердить: {!! $my_stream->approved ? __('<span class="confirmed">да</span>') : __('<span class="not_confirmed">нет</span>') !!}</span>
                </div>
                <a href="{{route('stream.edit', ['id' => $my_stream->id])}}" class="user-theme-edit">
                    <img src="{{route('home')}}/images/icons/svg/edit_icon.svg" alt="">
                    <span>Редактировать</span>
                </a>
            </div>
        </div><!-- close div /.mystream-wrapper -->   
    </div> 
    @php $n++; @endphp    
    @endforeach
@else
    <div class="content-box"> 
        <div class="col-md-12 section-title">
            <h1>Мои Cтрим</h1>
        </div>   
        <div class="col-md-12 mystream-wrapper">        
            <h1>Hет стрим</h1>
        </div>
    </div>
@endif
