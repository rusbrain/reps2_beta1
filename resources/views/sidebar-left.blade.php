<div class="sidebar-left">
    @if($general_helper->getLastForum())
        <div class="sidebar-widget">
            <div class="sidebar-widget-title">Последние темы форума</div>
            <div class="sidebar-widget-content">
                @foreach($general_helper->getLastForum() as $forum)
                    <div class="sidebar-widget-forum-section">
                        <div class="forum-section-title">
                            <a href="{{route('forum.section.index',['name' => $forum->name])}}">{{$forum->title}}:</a>
                        </div>
                        <div class="forum-section-content">
                            @foreach($forum->topics as $item => $topic)
                                <div class="topic-wrapper">
                                    <p class="topic-title">
                                        <a href="{{route('forum.topic.index',['id'=>$topic->id])}}"><span>{{$topic->title}}</span> <span>({{$topic->comments_count}})</span></a>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>