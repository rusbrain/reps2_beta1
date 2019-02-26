<!--Comments-->
@if($comments->total() > 0)
    <!-- COMMENTS PAGINATION TOP-->
    <div class="pagination-content"></div>
    <!-- END COMMENTS PAGINATION TOP-->

    <!-- COMMENTS CONTENT -->
    <div id="ajax_section_comments">
        <div class="load-wrapp">
            <img src="/images/loader.gif" alt="">
        </div>
    </div>
    <!-- END COMMENTS CONTENT -->

    <!-- COMMENTS PAGINATION BOTTOM -->
    <div class="pagination-content"></div>
    <!-- END COMMENTS PAGINATION BOTTOM-->
@else
    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Комментарии:</div>
        </div>
        <div class="col-md-12 comment-content-wrapper">
            <div class="comment-content">
                Комментарии отсутствуют
            </div>
        </div>
    </div>
@endif
<!--END Comments-->

@section('js')
    <script>
        $(function () {
            getSections(1);
            $('.pagination-content').on('click', '.page-link', function (e) {
                e.preventDefault();
                $('.load-wrapp').show();
                var page = $(this).attr('data-page');
                getSections(page);
            })
        });

        function getSections(page) {
            var container = $('#ajax_section_comments');
            $.get('{{route('comments.pagination',['object' => $object, 'id' => $id])}}' +
                '?page=' + page, {}, function (data) {
                container.html(data.comments);
                $('.pagination-content').html(data.pagination);
                $('.load-wrapp').hide();

                /**move to top of comments*/
                // moveToTop(container);
            })
        }
    </script>
@endsection