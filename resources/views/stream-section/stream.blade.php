
<div class="stream_view">
   
    @if(!empty($stream))
        <div class="widget-wrapper">
            <div class="widget-header">
                @if(isset($stream->country))
                    <span class="flag-icon flag-icon-{{mb_strtolower($stream->country->code)}}"></span>
                @else
                    <span class="flag-icon"></span>
                @endif
                @if(isset($stream->race))
                    <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons[$stream->race]}}" alt="">
                @else
                    <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons['All']}}" alt="">
                @endif
                <span class="color-white">{{$stream->title}}</span>
                <a href="#" class="list_menu" click="menu_toggle(event, 'open')"></a>
            </div>                  
        </div>
        <div class="ifram_container">
            {!! $stream->stream_url !!}
        </div>
    @endif
    
</div>