<div class="left-inner-forum-sidebar">
    @if($general_helper->getAllForumSections())
        @foreach($general_helper->getAllForumSections() as $forum)
            <div class="sidebar-widget">
                <div class="sidebar-widget-title">
                    <a href="{{route('forum.section.index',['name' => $forum->name])}}">{{$forum->title}}:</a>
                </div>
                <div class="sidebar-widget-content">
                    <div class="sidebar-widget-forum-section">
                        <div class="forum-section-content">
                            @foreach($forum->topics as $item => $topic)
                                <div class="topic-wrapper">
                                    <p class="topic-title">
                                        <a href="{{route('forum.topic.index',['id'=>$topic->id])}}">
                                            <span>{{$topic->title}}</span>
                                            <span>({{$topic->comments_count}})</span>
                                        </a>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    @endif
</div>