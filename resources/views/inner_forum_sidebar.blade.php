@php
    $forum_sections = $general_helper->getAllForumSections();
@endphp
<div class="left-inner-forum-sidebar">

    @if($forum_sections)
        @foreach($forum_sections as $forum_section)
            <div class="sidebar-widget">
                <div class="sidebar-widget-title">
                    <a href="{{route('forum.section.index',['name' => $forum_section->name])}}">
                        {{$forum_section->title}}:</a>
                </div>
                <div class="sidebar-widget-content">
                    <div class="sidebar-widget-forum-section">
                        <div class="forum-section-content">

                            @if($forum_section->topics)
                                @foreach($forum_section->topics as $item => $topic)
                                    <div class="topic-wrapper">
                                        <p class="topic-title">
                                            <a href="{{route('forum.topic.index',['id'=>$topic->id])}}">
                                                <span>{!! $topic->title !!}</span>
                                                <span>({{$topic->comments_count}})</span>
                                            </a>
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <div class="topic-wrapper">
                                    <p class="topic-title">
                                        В данной секции форума нет тем
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    @endif
</div>