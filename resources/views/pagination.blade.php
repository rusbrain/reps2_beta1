@if($data->lastPage() > 1)
    <nav class="pagination-wrapper">
        <ul class="pagination ">
            <li class="page-item">
                <a class="page-link" href="{{$data->previousPageUrl()}}"
                   data-page="{{$data->currentPage()>1?$data->currentPage()-1:1}}">&laquo;</a>
            </li>
            @if($data->lastPage() > 7)
                @if($data->currentPage() <= 3)
                    @for($i = 1; $i <= ($data->currentPage()+1 > 3?$data->currentPage()+1:3); $i++)
                        <li class="page-item">
                            <a class="page-link @if($data->currentPage() == $i) active @endif"
                               href="{{$data->url($i)}}" data-page="{{$i}}">{{$i}}</a>
                        </li>
                    @endfor
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{$data->url(1)}}" data-page="1">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{$data->url($data->currentPage()-2)}}"
                           data-page="{{$data->currentPage()-2}}">...</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link"
                           href="{{$data->url($data->currentPage()-1)}}"
                           data-page="{{$data->currentPage()-1}}">{{$data->currentPage()-1}}</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link active"
                           href="{{$data->url($data->currentPage())}}"
                           data-page="{{$data->currentPage()}}">{{$data->currentPage()}}</a>
                    </li>
                    @if($data->currentPage() != $data->lastPage())
                        <li>
                            <a class="page-link"
                               href="{{$data->url($data->currentPage()+1)}}"
                               data-page="{{$data->currentPage()+1}}"
                            >{{$data->currentPage()+1}}</a>
                        </li>
                    @endif
                @endif
                @if(($data->lastPage()-$data->currentPage()>2))
                    <li class="page-item">
                        <a class="page-link"
                           href="{{$data->url($data->currentPage()+2)}}"
                           data-page="{{$data->currentPage()+2}}">...</a>
                    </li>
                @endif
                @if(($data->lastPage()-$data->currentPage())>1)
                    <li class="page-item">
                        <a class="page-link"
                           href="{{$data->url($data->lastPage())}}"
                           data-page="{{$data->lastPage()}}">{{$data->lastPage()}}</a>
                    </li>
                @endif
            @else
                @for($i = 1; $i <= $data->lastPage(); $i++)
                    <li class="page-item">
                        <a class="page-link @if($data->currentPage() == $i) active @endif"
                           href="{{$data->url($i)}}"
                           data-page="{{$i}}">{{$i}}</a>
                    </li>
                @endfor
            @endif
            <li class="page-item">
                <a class="page-link"
                   href="{{$data->nextPageUrl()}}"
                   data-page="{{$data->currentPage()<$data->lastPage()?$data->currentPage()+1:$data->lastPage()}}">&raquo;</a>
            </li>
        </ul>
    </nav><!-- close div /.pagination-wrapper -->
@endif