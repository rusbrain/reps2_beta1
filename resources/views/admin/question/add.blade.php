<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Создать новый опрос</h3>
    </div>
    <div class="box-body">
        <form action="{{route('admin.question.create')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="">Вопрос</span>
                        <input type="text" class="form-control" placeholder="Имя роли" name="question" value="{{old('question')}}">
                    </div>
                    <br>
                    <div class="input-group col-md-12" id="question-create">
                        <span class="">Варианты ответов:</span>
                        <div class="row">
                            <div class="col-md-10">
                                <input type="text" name="new_answers[]" class="form-control" placeholder="Вариант ответа">
                            </div>
                            <div class="col-md-2">
                                <h4>
                                    <i class="fa fa-plus text-green add_input" data-question="question-create"></i>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="input-group col-md-12" id="question-create">
                        <label>
                            <input type="checkbox" name="is_active" class="flat-red" {{old('approved')?'checked':''}} value="1">
                            Активный
                        </label><br>
                        <label>
                            <input type="checkbox" name="is_favorite" class="flat-red" {{old('approved')?'checked':''}} value="1">
                            Обязательный
                        </label><br>
                        <label>
                            <input type="checkbox" name="for_login" class="flat-red" {{old('approved')?'checked':''}} value="1">
                            Только для зарегестрированных пользователей
                        </label>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Добавить</button>
            </div>
        </form>
    </div>
    <!-- /.box-body -->
</div>