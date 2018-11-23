@if($data->lastPage() > 1)
    <ul class="pagination pagination-sm no-margin pull-right">
        <li><a href="{{$data->appends($request_data)->previousPageUrl()}}">&laquo;</a></li>
        @if($data->lastPage() > 7)
            @if($data->currentPage() <= 3)
                @for($i = 1; $i <= ($data->currentPage()+1 > 3?$data->currentPage()+1:3); $i++)
                    <li @if($data->currentPage() == $i) class="active"@endif><a href="{{$data->appends($request_data)->url($i)/*route('admin.users').'?'.$data->pageName().'='.$i*/}}">{{$i}}</a></li>
                @endfor
            @else
                <li><a href="{{$data->appends($request_data)->url(1)}}">1</a></li>
                <li><a href="{{$data->appends($request_data)->url($data->currentPage()-2)}}">...</a></li>
                <li><a href="{{$data->appends($request_data)->url($data->currentPage()-1)}}">{{$data->currentPage()-1}}</a></li>
                <li class="active"><a href="{{$data->appends($request_data)->url($data->currentPage())}}">{{$data->currentPage()}}</a></li>
                @if($data->currentPage() != $data->lastPage())
                    <li><a href="{{$data->appends($request_data)->url($data->currentPage()+1)}}">{{$data->currentPage()+1}}</a></li>
                @endif
            @endif
                @if(($data->lastPage()-$data->currentPage()>2))
                    <li><a href="{{$data->appends($request_data)->url($data->currentPage()+2)}}">...</a></li>
                @endif
                @if(($data->lastPage()-$data->currentPage())>1)
                    <li><a href="{{$data->appends($request_data)->url($data->lastPage())}}">{{$data->lastPage()}}</a></li>
                @endif
        @else
            @for($i = 1; $i <= $data->lastPage(); $i++)
                <li @if($data->currentPage() == $i) class="active"@endif><a href="{{$data->appends($request_data)->url($i)}}">{{$i}}</a></li>
            @endfor
        @endif
    <li><a href="{{$data->appends($request_data)->nextPageUrl()}}">&raquo;</a></li>
    </ul>
@endif