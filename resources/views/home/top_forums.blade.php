@inject('general_helper', 'App\Services\GeneralViewHelper')
@if($popular_forum_topics)
    <div class="content-box">
        <div class="row">
            <div class="col-md-12">
                <h1 class="content-box-title">Популярные форумы</h1>
            </div>
            <div class="col-md-6 margin-top-20">
                @php $t=0; @endphp
                @foreach($popular_forum_topics as $forum)
                    @if($t == 0)
                        <a href="{{route('forum.topic.index',['id'=>$forum->id])}}">
                            @if($forum->preview_image)
                                <img src="{{$forum->preview_image->link ?? '/forum-topic-image-1-big.png'}}"
                                     class="content-box-topic-img"
                                     alt="">
                            @endif
                        </a>
                        <div class="content-box-topic-desc padding-left-15 margin-bottom-10">
                            <a href="{{route('forum.topic.index',['id'=>$forum->id])}}">
                                <h2 class="margin-bottom-10">{!! $forum->title ?? 'Название темы' !!}</h2>
                            </a>
                            <p class="content-box-topic-extract">
                                {!! $general_helper->oldContentFilter($forum->preview_content ?? mb_substr($forum->content,0,200,'UTF-8').' ...')!!}
                            </p>
                            <div class="content-box-topic-view">
                                <span>{{$forum->reviews ?? '0'}} просмотров</span>
                                <a href="{{route('forum.topic.index',['id'=>$forum->id])}}">
                                    <img src="images/icons/arrow-right.png" alt="">
                                </a>
                            </div>
                        </div>
                    @endif
                    @php $t++; @endphp
                @endforeach
            </div>
            <div class="col-md-6 margin-top-20">
                @php $ft=0; @endphp
                @foreach($popular_forum_topics as $forum)
                    @if($ft > 0)
                        <div class="row content-box-topic-row">
                            <div class="col-md-4">
                                <a href="{{route('forum.topic.index',['id'=>$forum->id])}}" class="в">
                                    <img src="{{$forum->preview_image->link ??'/images/forum-topic-image-1-big.png'}}" alt="">
                                </a>
                            </div>
                            <div class="col-md-8 padding-left-0">
                                <a class="padding-right-15 display-block" href="{{route('forum.topic.index',['id'=>$forum->id])}}">
                                    <h2>{!! $forum->title ?? 'Название темы' !!}</h2>
                                </a>
                                <div class="content-box-topic-view">{{$forum->reviews ?? '0'}} просмотров</div>
                            </div>
                        </div>
                    @endif
                    @php $ft++; @endphp
                @endforeach
            </div>
        </div>
    </div><!-- close div /.content-box -->
@endif