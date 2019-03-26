@if($data)
    @if($data->lastPage() > 1)
        <ul class="pagination pagination-sm no-margin pull-right">
            <li class="pagination-push" data-to-page="{{$data->currentPage()>1?$data->currentPage()-1:1}}"><a href="#">&laquo;</a></li>
            @if($data->lastPage() > 7)
                @if($data->currentPage() <= 3)
                    @for($i = 1; $i <= ($data->currentPage()+1 > 3?$data->currentPage()+1:3); $i++)
                        <li @if($data->currentPage() == $i) class = "active" @else class="pagination-push" data-to-page="{{$i}}" @endif ><a href="#">{{$i}}</a></li>
                    @endfor
                @else
                    <li class="pagination-push"  data-to-page="{{1}}" ><a href="#">1</a></li>
                    <li class="pagination-push"  data-to-page="{{$data->currentPage()-2}}" ><a href="#">...</a></li>
                    <li class="pagination-push"  data-to-page="{{$data->currentPage()-1}}" ><a href="#">{{$data->currentPage()-1}}</a></li>
                    <li class="active"><a href="#">{{$data->currentPage()}}</a></li>
                    @if($data->currentPage() != $data->lastPage())
                        <li class="pagination-push" data-to-page="{{$data->currentPage()+1}}"><a href="#">{{$data->currentPage()+1}}</a></li>
                    @endif
                @endif
                    @if(($data->lastPage()-$data->currentPage()>2))
                        <li class="pagination-push" data-to-page="{{$data->currentPage()+2}}"><a href="#">...</a></li>
                    @endif
                    @if(($data->lastPage()-$data->currentPage())>1)
                        <li class="pagination-push" data-to-page="{{$data->lastPage()}}"><a href="#">{{$data->lastPage()}}</a></li>
                    @endif
            @else
                @for($i = 1; $i <= $data->lastPage(); $i++)
                    <li @if($data->currentPage() == $i) class="active" @else class="pagination-push" data-to-page="{{$i}}"@endif><a href="#">{{$i}}</a></li>
                @endfor
            @endif
            <li class="pagination-push" data-to-page="{{$data->currentPage()<$data->lastPage()?$data->currentPage()+1:$data->lastPage()}}" ><a href="#">&raquo;</a></li>
        </ul>
    @endif
@endif