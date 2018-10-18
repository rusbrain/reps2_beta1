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
    <li>
        <div class="row">
            <div class="col-md-5">
                <img src="{{route('home').(($sender->avatar?$sender->avatar->link:'/dist/img/avatar.png'))}}" alt="User Image" >
            </div>
            <div class="col-md-6 text-left">
                <a class="users-list-name" href="{{route('admin.user.messages', ['id' => $sender->id])}}">{{$sender->name}}</a>
                <span class="users-list-date">{{$date}}</span>
                @if($contact->new_messages)<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="{{$contact->new_messages}} New Messages">Новые сообщения: {{$contact->new_messages}}</span>@endif
            </div>
        </div>
    </li>
    @endif
@endforeach