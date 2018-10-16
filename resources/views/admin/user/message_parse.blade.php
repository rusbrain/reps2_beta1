@if($messages->lastPage() > $messages->currentPage())
    <div class="text-center load-more-box">
        <span title="" class="badge bg-light-blue load-more" date-href="{{$messages->url($page??2)}}">Загрузить предыдущие сообщеня</span>
    </div>
@endif

@foreach(collect($messages->items())->sortBy('id') as $message)
    @if($message->user_id == Auth::id())
        <!-- Message to the right -->
        <div class="direct-chat-msg right">
            <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-right">{{$message->sender->name}}</span>
                <span class="direct-chat-timestamp pull-left">{{$message->created_at}}</span>
            </div>
            @else
                <div class="direct-chat-msg">
                    <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">{{$message->sender->name}}</span>
                        <span class="direct-chat-timestamp pull-right">{{$message->created_at}}</span>
                    </div>
                @endif
                <!-- /.direct-chat-info -->
                    <img class="direct-chat-img" src="{{route('home').($message->sender->avatar?$message->sender->avatar->link:'/dist/img/avatar.png')}}" alt="Message User Image"><!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        {{$message->message}}
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
                <!-- /.direct-chat-msg -->
        @endforeach
                <div class="scroll-to"></div>