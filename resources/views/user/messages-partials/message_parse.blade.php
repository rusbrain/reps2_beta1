@if($messages->lastPage() > $messages->currentPage())
    <div class="text-center load-more-box">
        <span class="btn-blue load-more"
              date-href="{{route('user.message_load',['dialog_id' => $dialog_id, 'page' => $page??2])}}">Загрузить предыдущие сообщеня</span>

    </div>
@endif

@foreach(collect($messages->items())->sortBy('id') as $message)
    @if($message->user_id == Auth::id())
        <div class="user-messages-row my-message">
            <div class="message-wrapper">
                <div class="message-content">
                    {!! $message->message !!}
                    <img src="{{route('home')}}/images/polygon-green.png" alt="">
                </div>
                <div class="message-create">
                    <span>{{$message->created_at}}</span>
                </div>
            </div>
            <div>
                <div class="user-name">{{$message->sender->name}}</div>
                <img src="{{route('home').($message->sender->avatar?$message->sender->avatar->link:'/dist/img/avatar.png')}}"
                     class="user-avatar-image" alt="">
            </div>
        </div><!--close div /.user-messages-row .my-message-->
    @else
        <div class="user-messages-row user-message">
            <div>
                <div class="user-name">{{$message->sender->name}}</div>
                <img src="{{route('home').($message->sender->avatar?$message->sender->avatar->link:'/dist/img/avatar04.png')}}"
                     class="user-avatar-image" alt="">
            </div>
            <div class="message-wrapper">
                <div class="message-content">
                    {!! $message->message !!}
                    <img src="{{route('home')}}/images/polygon.png" alt="">
                </div>
                <div class="message-create">
                    <span>{{$message->created_at}}</span>
                </div>
            </div>
        </div><!--close div /.user-messages-row .user-message-->
    @endif
@endforeach
<div class="scroll-to"></div>