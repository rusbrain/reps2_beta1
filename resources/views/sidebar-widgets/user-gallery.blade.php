<!-- User Gallery widget -->
@php
    if(Auth::user()){
            $gallery = $general_helper->getUserGallery(Auth::id());
        }
@endphp
@if($gallery)
<div class="widget-wrapper user-gallery-widget">
    <div class="widget-title">
        Галерея Miroslav
    </div>
    <div class="widget-forum-topics-wrapper">
        @foreach($gallery as $item)
            <div class="widget-forum-topic">
                <img src="images/icons/image_icon.png" alt="">
                <a href="{{route('gallery.view',['id'=> $item->id])}}" class="user-gallery-widget-link">
                    {{$item->file->title}}
                    <span class="color-blue">{{Auth::user()->name}}</span>
                </a>
            </div>
        @endforeach

        <!--Pagination-->
        <nav class="pagination-wrapper">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link active" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">11</a></li>
                <li class="page-item"><a class="page-link" href="#">12</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!--END Pagination-->
    </div>
</div>
@endif
<!-- END User Gallery widget -->