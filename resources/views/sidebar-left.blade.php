<div class="sidebar-left">
{{--        {{dd($last_forum)}}--}}
    @if($last_forum)
        <div class="sidebar-widget">
            <div class="sidebar-widget-title">Последние темы форума</div>
            <div class="sidebar-widget-content">
                @foreach($last_forum as $forum)
                    <a href="{{route('forum.section.index',['name' => $forum->name])}}">{{$forum->title}}</a>
                @endforeach
            </div>
        </div>
    @endif
</div>