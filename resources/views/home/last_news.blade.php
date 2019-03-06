@inject('general_helper', 'App\Services\GeneralViewHelper')
@if($last_news)
    <div class="content-box">
        <div class="row">
            <div class="col-md-12">
                <h1 class="content-box-title">Последние новости</h1>
            </div>
            @foreach($last_news as $news)
                <div class="col-md-6 margin-top-20">
                    <a href="{{route('forum.topic.index',['id'=>$news->id])}}"  class="">
                        @if($news->preview_image)
                            <img src="{{$news->preview_image->link ?? '/images/logo.png'}}"
                                 class="content-box-topic-img"
                                 alt="">
                        @endif
                    </a>
                    <div class="content-box-topic-desc padding-left-15 margin-bottom-10">
                        <a href="{{route('forum.topic.index',['id'=>$news->id])}}" class="content-box-news-title">
                            <h2 class="margin-bottom-5">{!! $news->title??'название форума' !!}</h2>
                        </a>
                        <div class="content-box-topic-extract-news">
                            {!!$general_helper->closeAllTags($general_helper->oldContentFilter(mb_substr($news->preview_content,0,200,'UTF-8').' ...' ?? mb_substr($news->content,0,200,'UTF-8').' ...'))!!}
                        </div>
                        <div class="content-box-topic-view display-block">
                            <span>{{$news->reviews ?? '0'}} просмотров</span>
                            <a href="{{route('forum.topic.index',['id'=>$news->id])}}">
                                <img src="images/icons/arrow-right.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div><!-- close div /.content-box -->
@endif