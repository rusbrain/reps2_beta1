@inject('general_helper', 'App\Services\GeneralViewHelper')
@if($comments)
    <div class="accordion user-posts" id="user-posts">
        @php $s = 0 @endphp
        @foreach($comments as $comment_objects)
            <div class="card">
                <div class="card-header" id="heading_post_id_{{$s}}">
                    <a class="user-section-title {{$s != 0 ? 'collapsed' : ''}}" data-toggle="collapse"
                       data-target="#post_id_{{$s}}" aria-expanded="{{$s != 0 ? 'false' : 'true'}}"
                       aria-controls="post_id_{{$s}}">
                        {{$comment_objects['title']}}
                        <span class="icon_collapse {{$s == 0 ? 'open' : 'close'}}"></span>
                    </a>
                </div>
                @if(!empty($comment_objects['comments']))
                    <div id="post_id_{{$s}}" class="collapse {{$s == 0 ? 'show' : ''}} user-section-post-wrapper"
                         aria-labelledby="heading_post_id_{{$s}}"
                         data-parent="#user-posts">
                        @php $relation = $comment_objects['relation'] @endphp
                        @foreach($comment_objects['comments'] as $comment)
                            <div class="card-body">
                                <div class="user-post-info">
                                    <div class="display-flex align-items-center">
                                        <a href="{{route($comment_objects['route'],['id'=>$comment->$relation->id])}}"
                                           class="margin-left-10">{{$comment->title}}</a>
                                    </div>
                                    <div class="display-flex align-items-center">
                                        <img src="{{route('home')}}/images/icons/eye.png" class="mr-1" alt="">
                                        <span>{{\Carbon\Carbon::parse($comment->created_at)->format('H:i d.m.Y')}}</span>
                                    </div>
                                </div>
                                <div class="user-post-content">
                                    {!! $general_helper->oldContentFilter($comment->content)!!}
                                </div>
                            </div><!-- close div /.card-body -->
                        @endforeach
                    </div><!-- close div /.user-section-post-wrapper -->
                @else
                    <div id="post_id_{{$s}}" class="collapse {{$s == 0 ? 'show' : ''}} user-section-post-wrapper"
                         aria-labelledby="heading_post_id_{{$s}}"
                         data-parent="#user-posts">
                        <div class="card-body">
                            Список пуст
                        </div><!--close div /.card-body-->
                    </div>
                @endif
            </div>
            @php $s++; @endphp
        @endforeach
    </div>
@else
    <div class="col-md-12">
        <div class="text-center padding-top-bottom-10">Список пуст</div>
    </div>
@endif