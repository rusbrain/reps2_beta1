<div class="content-box user-account-widget">
    <div class="user-account-widget-title">Список друзей</div>
    <div class="widget-new-user">
        @if(count($user->friends) > 0)
            @foreach($user->friends as $friend)
                <a href="{{route('user_profile',['id' => $friend->id])}}">
                    @if($friend->country_id)
                        <span class="flag-icon flag-icon-{{mb_strtolower($countries[$friend->country_id]->code)}}"></span>
                    @else
                        <span>NO</span>
                    @endif
                    <span class="flag-icon flag-icon-kr"></span>
                    <span>{{$friend->name}}</span>
                </a>
            @endforeach
        @else
            <p class="text-center">Список пуст</p>
        @endif
        {{--<div class="justify-content-center display-flex">--}}
            {{--@if(Auth::id() == $user->id)--}}
                {{--<a href="{{route('user.friends_list')}}" class="btn-empty margin-top-20" type="submit">--}}
                    {{--Ещё--}}
                {{--</a>--}}
            {{--@endif--}}
        {{--</div>--}}
    </div>
</div><!-- close div /.content-box -->