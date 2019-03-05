<div class="widget-wrapper user-message-widget">
    <div class="widget-title">
        <span>Мои переписки</span>
        @if($all_new_messages)
            <span class="qty-messages">{{$all_new_messages}}</span>
        @endif
    </div>
    <div class="messages-wrapper">
        @foreach($contacts as $contact)
            @php
                $diff = Carbon\Carbon::now()->diffAsCarbonInterval($contact->messages_last);
                $date = "";
                $sender = false;

                if ($contact->messages_last){
                    $date = $contact->messages_last->format('Y/m/d H:m:s');

                    if ($diff->d == 0 && $diff->y == 0 && $diff->m == 0){
                        if ($diff->h > 0){
                            $date = "$diff->h часов назад";
                        } elseif($diff->i > 0){
                            $date = "$diff->i минут назад";
                        } elseif($diff->s > 0){
                            $date = "$diff->s секунд назад";
                        }
                    }
                }

                foreach ($contact->senders as $item){
                    if ($item->id != Auth::id()){
                        $sender = $item;
                    }
                }
            @endphp

            @if($sender)
                <div class="widget-forum-topics-wrapper">
                    <div class="widget-forum-topic">
                        @if($sender->avatar)
                            <a href="{{route('user.messages', ['id' => $sender->id])}}">
                                <img src="{{(($sender->avatar?$sender->avatar->link:'/dist/img/avatar.png'))}}"
                                     alt="User Avatar">
                            </a>
                        @else
                            <a href="{{route('user_profile',['id' => $sender->id])}}"
                               class="logged-user-avatar no-header">A</a>
                        @endif
                        <div>
                            <div>
                                <a href="{{route('user.messages', ['id' => $sender->id])}}"
                                   class="user-name">{{$sender->name}}</a>
                                @if($contact->new_messages)
                                    <span class="qty-messages">{{$contact->new_messages}}</span>
                                @endif

                            </div>
                            <div class="message-create">
                                <span>{{$date}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div><!-- close div /.user-messages-widget-->
