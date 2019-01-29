@php
    $general_forum_sections = $general_helper->getGeneralSectionsForum();
@endphp
@if($general_forum_sections)
    <div class="widget-wrapper">
        <div class="widget-header">Основные темы форума</div>
        @foreach($general_forum_sections as $section)
            <a href="{{route('forum.section.index',['name' => $section->name])}}" class="widget-title">
                <img src="images/icons/icon_columns.png" alt="">
                {{$section->title}}:
            </a>
            <div class="widget-forum-topics-wrapper">
                @foreach($section->topics as $item => $topic)
                <a href="{{route('forum.topic.index',['id'=>$topic->id])}}" class="widget-forum-topic">
                    <span>{{$topic->title}}</span>
                    <span class="widget-forum-topic-comments">({{$topic->comments_count}})</span>
                </a>
                @endforeach
            </div>
        @endforeach
    </div>
@endif