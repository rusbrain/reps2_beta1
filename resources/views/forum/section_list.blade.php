@if($topics)
    <div class="col-md-12 section-info">
        <span>Темы:
            <span class="qty">{{$topics->total()}}</span>
        </span>
        <span>Ответов:
            <span class="qty"></span>
        </span>
    </div>
    @foreach($topics->items() as $topic)
        @if($topic->user)
            <div class="section-article">
                <div class="col-md-6">
                    <a href="{{route('forum.topic.index',['id' => $topic->id])}}" class="section-article-title">
                        {!! $topic->title !!}
                    </a>
                    <div class="section-article-info">
                        <a href="" class="section-article-view">
                            <img src="{{route('home')}}/images/icons/eye.png" alt="">
                            <span>{{$topic->reviews}}</span>
                        </a>
                        <a href="" class="section-article-comments">
                            <img src="{{route('home')}}/images/icons/message-square-empty.png" alt="">
                            <span>{{$topic->comments_count}}</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href="{{route('user_profile',['id' =>$topic->user->id])}}" class="section-article-author">
                        @if($topic->user->avatar)
                            <img src="{{$topic->user->avatar->link}}" class="user-avatar" alt="">
                        @else
                            <span class="logged-user-avatar">A</span>
                        @endif
                        <span class="name">{{$topic->user->name}}</span>
                    </a>
                </div>
                <div class="col-md-4 section-article-date">
                    <img src="{{route('home')}}/images/icons/clock.png" alt="">
                    <span>{{\Carbon\Carbon::parse($topic->created_at)->format('H:i d.m.Y')}}</span>
                    <a href="{{route('forum.topic.index',['id' => $topic->id])}}#comments">
                        <img src="{{route('home')}}/images/icons/message-square-blue.png" class="margin-left-15" alt="">
                    </a>
                </div>
            </div><!-- close div /.section-article -->
        @endif
    @endforeach
@else
    <div class="col-md-12 section-info">
        <h2>В данный момент в этом разделе нет активных тем</h2>
    </div>
@endif