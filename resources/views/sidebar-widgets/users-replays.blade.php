@php $last_user_replays = $general_helper->getLastUserReplay(); @endphp
<?php if ($last_user_replays) : ?>
<div class="widget-wrapper">
    <div class="widget-header">
        Пользовательские реплеи
    </div>
    <div class="widget-forum-topics-wrapper">
        @foreach($last_user_replays as $last_user_replay)
            <a href="{{route('replay.get',['id' => $last_user_replay->id])}}" class="widget-forum-topic">
                <span>{{$last_user_replay->title}}</span>
                <span class="widget-forum-topic-comments">{{$last_user_replay->comments_count}}</span>
            </a>
        @endforeach
        <div class="justify-content-center display-flex">
            <a href="{{route('replay.users')}}" class="btn-empty margin-top-10" >
                Ещё
            </a>
        </div>
    </div>
</div>
<?php endif; ?>