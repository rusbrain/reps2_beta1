@inject('general_helper', 'App\Services\GeneralViewHelper')
@php @endphp

<div class="content-box">       
    <div class="col-md-12 section-title">
        <h1>Мои Cтрим</h1>
    </div>
       
    @if($streams)
        @php $n = 0; @endphp
        @foreach($streams as $my_stream)
        
            <div class="col-md-12 mystream-wrapper">               
                <div class="stream-title">
                    <h2>{!! $my_stream->title !!}</h2>  
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
        
            @php $n++; @endphp
        @endforeach
    @else
        <h1> Hет стрим</h1>
    @endif
</div><!-- close div /.content-box -->