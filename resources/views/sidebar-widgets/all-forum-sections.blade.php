@php
    $forum_sections = $general_helper->getAllForumSections();
    $section_icons = $general_helper->getSectionIcons();
@endphp

@if($forum_sections)
    <div class="widget-wrapper">
        <div class="widget-header">Темы форума</div>
        @foreach($forum_sections as $forum_section)
            <a href="{{route('forum.section.index',['name' => $forum_section->name])}}" class="widget-title">
                <img src="{{route('home').$section_icons[$forum_section->id]}}" alt="">
                {{$forum_section->title}}:
            </a>
            <div class="widget-forum-topics-wrapper">
                @if($forum_section->topics)
                    @foreach($forum_section->topics as $item => $topic)
                        <a href="{{route('forum.topic.index',['id'=>$topic->id])}}" class="widget-forum-topic">
                            <span>{!! $topic->title !!}</span>
                            <span class="widget-forum-topic-comments">({{$topic->comments_count}})</span>
                        </a>
                    @endforeach
                @else
                    <div class="widget-forum-topic">
                        В данной секции форума нет тем
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif