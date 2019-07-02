@php 
    $stream_headline = $general_helper->getStreamHeader();
@endphp
@if(!empty($stream_headline))
    <div class="row">
        <div class="col-md-12">
            <h1 class="section-title">
                <a href="{{$stream_headline->url??"javascript: return false;"}}" >{{$stream_headline->title}}</a>
                <p class="toggle-action">Hide</p>
            </h1>            
        </div>
    </div>
@endif