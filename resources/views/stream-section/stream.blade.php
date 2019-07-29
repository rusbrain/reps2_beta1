
@inject('general_helper', 'App\Services\GeneralViewHelper')
@php
    $stream_type = '';
    $channel = '';
    $url = $general_helper->UrlFilter($stream->stream_url);
    $parts = $general_helper->parse_stream_url( $url);
    $host = $parts['host'];
    if($host == 'player.twitch.tv') {
        $stream_type = 'twitch';        
        parse_str($parts['query'], $query);               
        $channel = $query['channel'];
    }
@endphp
<div class="stream_view">
   
    @if(!empty($stream))
        <div class="widget-wrapper">
            <div class="widget-header">                
                <a href="#" class="chat_button" data-tip="Chatroom" onclick="chatroom_toggle(event, $(this))"></a>               
                @if(isset($stream->country))
                    <span class="flag-icon flag-icon-{{mb_strtolower($stream->country->code)}}"></span>
                @else
                    <span class="flag-icon"></span>
                @endif
                @if(isset($stream->race))
                    <img class="margin-left-5" src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons[$stream->race]}}" alt="">
                @else
                    <img class="margin-left-5" src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons['All']}}" alt="">
                @endif
                <span class="color-white">{{$stream->title}}</span>
                <a href="#" class="theatre_mode" data-tip="Theatre Mode" onclick="theatre_mode(event, $(this))" ></a>
                <a href="#" class="list_menu" data-tip="Streams List" onclick="menu_toggle(event, $(this))"></a>
            </div>                  
        </div>
        <div class="ifram_container">
            @if($stream_type == 'twitch')
            <div class="twitch_chat active">
                <div class="twitch_chat_header">Twitch Chat
                    <a href="#" class="button" onclick="twitch_chatroom_toggle(event, $(this))"></a>
                </div>
                <iframe frameborder="0"
                    scrolling="no"
                    id="{{$channel}}"
                    src="https://www.twitch.tv/embed/{{$channel}}/chat?darkpopout"
                    height="500"
                    width="300">
                </iframe>
            </div>
            @endif
            {!! $stream->stream_url !!}
        </div>
    @else 
        <div class="no-stream">
            Там нет cтрим
        </div>
    @endif    
</div>