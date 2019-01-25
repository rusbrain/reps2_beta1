<!--Comments-->
@if($comments->total() > 0)
    @foreach($comments as $item => $comment)
        <div class="content-box">
            @php $item++; @endphp
            @if($item == 1)
                <div class="col-md-12 section-title">
                    <div>Комментарии:</div>
                </div>
            @endif
            <div class="comment-wrapper">
                <div class="col-md-12 comment-header">
                    <div>
                        @if($comment->user->avatar)
                            <a href="{{route('user_profile',['id' => $comment->user->id])}}">
                                <img src="{{$comment->user->avatar->link}}" class="user-avatar" alt="">
                            </a>
                        @else
                            <a href="{{route('user_profile',['id' => $comment->user->id])}}"
                               class="logged-user-avatar no-header">A</a>
                        @endif
                        <div class="user-nickname">
                            <a href="{{route('user_profile',['id' => $comment->user->id])}}">{{$comment->user->name}}</a>
                            <a href="" class="user-menu-link"></a>
                            <div class="user-menu">
                                <a href="{{route('user.add_friend',['id'=>$comment->user->id])}}">Добавить в друзья</a>
                                <a href="{{route('user.messages',['id' => $comment->user->id])}}">Сообщение</a>
                                <a href="{{route('user.set_ignore',['id'=>$comment->user->id])}}">Игнор-лист</a>
                            </div>
                        </div>
                        <div class="user-role">
                            @if($comment->user->user_role_id != 0)
                                {{$comment->user->role->title . ' | '}}
                                {{$general_helper->getUserStatus($comment->user->score)}} {{$comment->user->score . ' pts | '}}
                            @else
                                {{$general_helper->getUserStatus($comment->user->score)}} {{$comment->user->score . ' pts | '}}
                            @endif
                        </div>
                        <div>
                            <a href="{{route('user.get_rating', ['id' => $comment->user->id])}}"
                               class="user-rating"> {{$comment->user->rating}} кг</a>
                        </div>
                    </div>
                    <div class="comment-creating-date">
                        <img src="{{route('home')}}/images/icons/clock-white.png" alt="">
                        {{$comment->created_at}}
                        <span class="comment-id">#{{$item}}</span>
                    </div>
                </div>
                <div class="col-md-12 comment-content-wrapper">
                    <div class="comment-content">
                        {!! $general_helper->oldContentFilter($comment->content) !!}
                    </div>
                    <div class="comment-footer">
                        <div class="quote">
                            <img src="{{route('home')}}/images/icons/frame.png" alt="">
                            Цитировать
                        </div>
                        <div class="comment-rating">
                            <a href="" class="positive-vote">
                                <img src="{{route('home')}}/images/icons/thumbs-up.png" alt="">
                                <span>{{$comment->positive_count}}</span>
                            </a>
                            <a href="" class="negative-vote">
                                <img src="{{route('home')}}/images/icons/thumbs-down.png" alt="">
                                <span>{{$comment->negative_count}}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- close div /.comment-wrapper-->
        </div><!-- close div /.content-box-->
    @endforeach

    <!-- COMMENTS PAGINATION -->
    @php  $data = $comments @endphp
    @include('pagination')
    <!-- END COMMENTS PAGINATION -->

@else
    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Комментарии:</div>
        </div>
        <div class="col-md-12 comment-content-wrapper">
            <div class="comment-content">
                Комментарии отсутствуют
            </div>
        </div>
    </div>
@endif
<!--END Comments-->