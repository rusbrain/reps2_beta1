@inject('general_helper', 'App\Services\GeneralViewHelper')
@foreach($comments as $item => $comment)
    <div class="content-box">
        @if($item == 0)
            <div class="col-md-12 section-title" id="comments">
                <div>Комментарии:</div>
                @if(Auth::user())
                    <div class="move-to-add-comment">
                        <img src="{{route('home')}}/images/icons/arrow-right-white.png" alt="">
                        <span>Добавить коментарий</span>
                    </div>
                @endif
            </div>
        @endif
        <div class="comment-wrapper">
            @if($comment->user != null)
                @if(\App\IgnoreUser::i_ignore($comment->user->id))
                    <div class="col-md-12 text-center padding-15">Комментарий скрыт</div>
                @else
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
                                <a href="" class="user-menu-link @if(!Auth::user()) display-none @endif"></a>
                                <div class="user-menu">
                                    <a href="{{route('user.add_friend',['id'=>$comment->user->id])}}">Добавить в друзья</a>
                                    <a href="{{route('user.messages',['id' => $comment->user->id])}}">Сообщение</a>
                                    <a href="{{route('user.set_ignore',['id'=>$comment->user->id])}}">Игнор-лист</a>
                                </div>
                            </div>
                            <div class="">
                                @php
                                    $countries = $general_helper->getCountries();
                                @endphp

                                {{-- <span class="color-blue">#{{$comment->user->id}}</span> --}}
                                @if($comment->user->country_id)
                                   <span class="flag-icon flag-icon-{{mb_strtolower($countries[$comment->user->country_id]->code)}}"></span>
                                @else
                                   <span class="flag-icon"></span>
                                @endif

                                @if($comment->user->race)
                                   <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons[$comment->user->race]}}" alt="">
                                @else
                                   <img class="margin-left-5" src="{{route('home')}}/images/smiles/{{\App\Replay::$race_icons['All']}}" alt="">
                                @endif
                                {{-- <span>{{$comment->user->name}}</span> --}}
                                
                            </div>
                            
                            <div>
                                {{$comment->user->points . ' pts | '}}
                            </div>
                            <div>
                                <a href="{{route('user.get_rating', ['id' => $comment->user->id])}}"
                                class="user-rating"> {{$comment->user->rating}} кг</a>
                            </div>
                        </div>
                        <div class="comment-creating-date">
                            <img src="{{route('home')}}/images/icons/clock-white.png" alt="">
                            {{$comment->created_at}}
                            <span class="comment-id" id=""></span>
                        </div>
                    </div>
                    <div class="col-md-12 comment-content-wrapper">
                        {{-- <div class="commnet-edit">
                            {{$comment->edit_user_id}}
                        </div> --}}
                        <div class="comment-content">
                            {!! $general_helper->oldContentFilter($comment->content) !!}
                        </div>
                        <div class="comment-footer">
                            <div class="quote">
                                <img src="{{route('home')}}/images/icons/frame.png" alt=""
                                    data-user="{{$comment->user->name}}"
                                    data-id="">
                                <span>Цитировать</span>
                            </div>
                            <div class="comment-rating">
                                <a href="#vote-modal" class="positive-vote vote-replay-up" data-toggle="modal"
                                data-rating="1" data-route="{{route('comment.set_rating',['id' => $comment->id])}}">
                                    <img src="{{route('home')}}/images/icons/thumbs-up.png" alt="">
                                    <span id="positive-vote">{{$comment->positive_count}}</span>
                                </a>
                                <a href="#vote-modal" class="negative-vote vote-replay-down" data-toggle="modal"
                                data-rating="-1" data-route="{{route('comment.set_rating',['id' => $comment->id])}}">
                                    <img src="{{route('home')}}/images/icons/thumbs-down.png" alt="">
                                    <span id="negative-vote">{{$comment->negative_count}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div><!-- close div /.comment-wrapper-->
    </div><!-- close div /.content-box-->
    @php $item++; @endphp
@endforeach