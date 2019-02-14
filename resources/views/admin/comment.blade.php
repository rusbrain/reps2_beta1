@if($data)
    @inject('general_helper', 'App\Services\GeneralViewHelper')

    @foreach($data->items() as $comment)
        <div class="item row">
            @if(isset($comment->user->avatar))
                <img class="img-circle img-bordered-sm" src="{{route('home').$comment->user->avatar->link}}" alt="User img">
            @else
                <img class="img-circle img-bordered-sm" src="{{route('home').'/dist/img/avatar.png'}}" alt="User img">
            @endif

            <p class="message">
                <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> {{$comment->created_at->format('h:m d-m-Y')}}</small>
                    {{$comment->user->name}}
                </a><a type="button" class="btn btn-default text-red"  title="Удалить запись" href="{{route('admin.comments.remove', ['id' => $comment->id])}}"><i class="fa fa-trash"></i></a>
                {!! $general_helper->oldContentFilter($comment->content) !!}
            </p>
        </div>
    @endforeach
@endif
