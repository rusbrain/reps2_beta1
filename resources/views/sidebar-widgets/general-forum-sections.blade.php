@php
    // $general_forum_sections = $general_helper->getGeneralSectionsForum();
    $recent_forums = $general_helper->getRecentForums();
    // dd($recent_forums);
   
@endphp
@if($recent_forums)
    <div class="widget-wrapper">
        <div class="widget-header">Последние темы</div>
        @foreach($recent_forums as $topic)
            <div class="widget-forum-topics-wrapper">
                <a href="{{route('forum.topic.index',['id'=>$topic->id])}}" class="widget-forum-topic margin-bottom-0">
                    <span>{!! $topic->title !!}</span>
                    <span class="widget-forum-topic-comments">({{$topic->comments_count}})</span>
                </a>                
            </div>
        @endforeach
    </div>
@endif