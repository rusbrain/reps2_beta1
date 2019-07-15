@php 
    $stream_headline = $general_helper->getStreamHeader();
@endphp
@if(!empty($stream_headline))   
    <div class="row">
        <div class="col-md-12">            
            <h1 class="section-title">
                <p class="header_link">
                    @foreach($stream_headline as $key => $link)
                    <a href="{{$link->url??"javascript: return false;"}}" >{{$link->title}}</a>
                    @endforeach
                </p>
                <p class="toggle-action">Hide</p>                    
            </h1> 
        </div>
    </div>
@endif