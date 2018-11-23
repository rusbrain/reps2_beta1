<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">{{$question->question}}</h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <ul class="list-unstyled">
                    <li>{{$question->question}}:
                        <ul>
                            @foreach($question->answers as $answer)
                                <li>{{$answer->answer}} ({{$answer->user_answers_count}} ответов)</li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>