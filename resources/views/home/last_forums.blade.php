@inject('general_helper', 'App\Services\GeneralViewHelper')
@if($news)
    @php $n = 0; @endphp
    @foreach($news as $single_news)
        <div class="content-box">
            @if($n == 0)
                <div class="col-md-12 section-title">
                    <h1>Последние Новости</h1>
                </div>
            @endif
            <div class="col-md-12 news-wrapper">
                @if($single_news->preview_image)
                    <a href="{{route('forum.topic.index',['id' => $single_news->id])}}">
                        <img src="{{$single_news->preview_image->link ?? route('home').'/images/logo.png'}}"
                             class="" alt="">
                    </a>
                @endif
                <a href="{{route('forum.topic.index',['id' => $single_news->id])}}">
                    <h2>{!! $single_news->title !!}</h2>
                </a>
                <div class="news-info">
                    @if($single_news->user->avatar)
                        <a href="{{route('user_profile',['id' => $single_news->user->id])}}">
                            <img src="{{$single_news->user->avatar->link}}" class="margin-right-10" alt="">
                        </a>
                    @else
                        <a href="{{route('user_profile',['id' => $single_news->user->id])}}"
                           class="logged-user-avatar">A</a>
                    @endif
                    <a href="{{route('user_profile',['id' => $single_news->user->id])}}"
                       class="margin-right-30">{{$single_news->user->name}}</a>
                    <img src="{{route('home')}}/images/icons/clock.png" class="margin-right-5" alt="created at">
                    <span>{{\Carbon\Carbon::parse($single_news->created_at)->format('H:i d.m.Y')}}</span>
                </div>
                <div class="news-content">
                    @php                        
                        $preview_content_text =  str_replace(array("\n","\r","\t"), "", strip_tags ($single_news->preview_content ));
                        $preview_content = mb_substr($preview_content_text,0,250,'utf-8').' ...';                    

                        $full_content_text = str_replace(array("\n","\r","\t"), "", strip_tags ($single_news->content ));
                        $full_content = mb_substr($full_content_text,0,250,'utf-8').' ...';                  
                    @endphp
                    {!! $general_helper->closeAllTags(
                        $general_helper->oldContentFilter(
                        str_replace($preview_content_text, $preview_content, $single_news->preview_content) ??
                        str_replace($full_content_text, $full_content, $single_news->content).' ...')
                        )
                    !!}
                    <a href="{{route('forum.topic.index',['id' => $single_news->id])}}" class="read-more-link">
                        <img src="{{route('home')}}/images/icons/arrow-right.png" alt="">
                    </a>
                </div>
                <div class="news-footer">
                    <div>
                        <img src="{{route('home')}}/images/icons/eye.png" class="margin-right-5" alt="">
                        <span class="margin-right-5">{{$single_news->reviews ?? '0'}}</span>
                        <span class="margin-right-30">просмотров</span>

                        <img src="{{route('home')}}/images/icons/message-square-empty.png" class="margin-right-5"
                             alt="">
                        <span>{{$single_news->comments_count}}</span>
                    </div>
                    <div>
                        #{{$single_news->id}}
                    </div>
                </div>
            </div><!-- close div /.news-wrapper -->
        </div><!-- close div /.content-box -->
        @php $n++; @endphp
    @endforeach
@else
    <h1> В данный момент новостей нет</h1>
@endif