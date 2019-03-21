@inject('general_helper', 'App\Services\GeneralViewHelper')
<div class="content-box padding-left-15 padding-right-15">
    <div class="row">
        <h1 class="content-box-title w-100">Последние форумы</h1>
    </div>
    @if($last_forum)
        @foreach($last_forum as $type => $forums)
            @if(!empty($forums))
                @foreach($forums as $forum)
                    @if($type == 'forums')
                        @include('home.forums-templates.last_forum', ['forum' => $forum])
                    @elseif($type == 'galleries')
                        @include('home.forums-templates.last_gallery', ['photo' => $forum])
                    @elseif($type == 'replays')
                        @include('home.forums-templates.last_replay', ['replay' => $forum])
                    @endif
                @endforeach
            @endif
        @endforeach
    @else
        <div class="row">
            <div class="col-md-12">
                Список пуст
            </div>
        </div>
    @endif
</div><!-- close div /.content-box -->