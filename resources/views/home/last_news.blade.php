@inject('general_helper', 'App\Services\GeneralViewHelper')
@if($last_news)
    <div class="content-box">
        <div class="row">
            <div class="col-md-12">
                <h1 class="content-box-title">Последние новости</h1>
            </div>
            <div class="col-md-6 margin-top-20">
                @php $i=0; @endphp
                @foreach($last_news as $forum)
                    @if($i==0)
                        <a href="{{route('forum.topic.index',['id'=>$forum->id])}}">
                            @if($forum->preview_image)
                                <img src="{{$forum->preview_image->link ?? '/images/logo.png'}}"
                                     class="content-box-topic-img"
                                     alt="">
                            @endif
                        </a>
                        <div class="content-box-topic-desc padding-left-15 margin-bottom-10">
                            <a href="{{route('forum.topic.index',['id'=>$forum->id])}}">
                                <h2 class="margin-bottom-10">{!! $forum->title??'название форума' !!}</h2>
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
                    @php $i++; @endphp
                @endforeach
            </div>
            <div class="col-md-6 margin-top-20">
                @php $j=0; @endphp
                @foreach($last_news as $forum)
                    @if($j > 0)
                        <div class="row content-box-topic-row">
                            <div class="col-md-4">
                                <a href="{{route('forum.topic.index',['id'=>$forum->id])}}">
                                    <img src="{{$forum->preview_image->link ??'/images/banner.png'}}" alt="">
                                </a>
                            </div>
                            <div class="col-md-8 padding-left-0">
                                <a href="{{route('forum.topic.index',['id'=>$forum->id])}}"
                                   class="padding-right-15 display-block">
                                    <h2>{!! $forum->title ?? 'название форума' !!}</h2>
                                </a>
                                <div class="content-box-topic-view">{{$forum->reviews ?? '0'}} просмотров</div>
                            </div>
                        </div>
                    @endif
                    @php $j++; @endphp
                @endforeach
            </div>
        </div>
    </div><!-- close div /.content-box -->
@endif