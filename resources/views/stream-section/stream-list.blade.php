
@php 
    $streams_list = $general_helper->getStreams();
    $countries = $general_helper->getCountries();
@endphp
@if(!empty($streams_list))
    <div class="widget-wrapper">
        <div class="widget-header">Streams list <p class="close_menu"></p></div>
            <div class="streams_list">
            @foreach($streams_list as $stream)
                <div class="widget-stream-lists">
                    <a href="#"  data-id="{{$stream->id}}">
                        @if($stream->country_id)
                            <span class="flag-icon flag-icon-{{mb_strtolower($countries[$stream->country_id]->code)}}"></span>
                        @else
                            <span class="flag-icon"></span>
                        @endif
                        @if($stream->race)
                            <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons[$stream->race]}}" alt="">
                        @else
                            <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons['All']}}" alt="">
                        @endif
                        <span class="color-blue">{{$stream->title}}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
