<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{$question->name}}</h3>
    </div>
    <div class="box-body">
        <form action="{{route('admin.question.save', ['id' => $question->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="">Вопрос</span>
                        <input type="text" class="form-control" placeholder="Имя роли" name="question" value="{{old('question')??$question->question}}">
                    </div>
                    <br>
                    <div class="input-group col-md-12">
                        <span class="">Ответы:</span>
                        @foreach($question->answers as $answer)
                            <div class="row" id="answer-{{$answer->id}}">
                                <div class="col-md-10">
                                    <input type="text" name="old_answers[{{$answer->id}}]" class="form-control" placeholder="Вариант ответа" value="{{$answer->answer}}">
                                </div>
                                <div class="col-md-2">
                                    <h4>
                                        <i class="fa fa-minus text-red remove_input" data-answer="answer-{{$answer->id}}"></i>
                                    </h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="input-group col-md-12" id="question-{{$question->id}}">
                        <span class="">Добавить ответы:</span>
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="text" name="new_answers[]" class="form-control" placeholder="Вариант ответа">
                                </div>
                                <div class="col-md-2">
                                    <h4>
                                        <i class="fa fa-plus text-green add_input" data-question="question-{{$question->id}}"></i>
                                    </h4>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Обновить</button>
            </div>
        </form>
    </div>
    <!-- /.box-body -->
</div>