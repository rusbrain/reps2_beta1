@inject('general_helper', 'App\Services\GeneralViewHelper')
<div class="row">
    <div class="col-12 home-last-forum-type">ФОРУМЫ</div>
    <div class="col-md-6">
        <a href="{{route('forum.topic.index',['id'=>$forum->id])}}" class="content-box-forum-img-wrapper">
            <img src="{{$forum->preview_image->link ??'/images/forum-topic-image-1-big.png'}}"
                 class="content-box-forum-img" alt="">
        </a>
    </div>
    <div class="col-md-6">
        <div class="content-box-topic-desc padding-top-10 margin-bottom-15">
            <a href="{{route('forum.topic.index',['id'=>$forum->id])}}">
                <h2 class="margin-bottom-10">{!! $forum->title ?? 'название темы' !!}</h2>
            </a>
            <p class="content-box-topic-extract">
                {!! $general_helper->closeAllTags($general_helper->oldContentFilter($forum->preview_content ?? mb_substr($forum->content,0,200,'UTF-8').' ...'))!!}
            </p>
            <div class="content-box-topic-view">
                <span>{{$forum->reviews ?? '0'}} просмотров</span>
                <a href="{{route('forum.topic.index',['id'=>$forum->id])}}">
                    <img src="images/icons/arrow-right.png" alt="">
                </a>
            </div>
        </div>
    </div>
</div>