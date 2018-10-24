<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Создать Роль</h3>
    </div>
    <div class="box-body">
        <form action="{{route('admin.replay.map.create')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="">Карта</span>
                        <input type="file" placeholder="Карта" name="file" value="{{old('name')}}">
                    </div>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                    @endif
                    <br>
                    <div class="input-group">
                        <span class="">Название</span>
                        <input type="text" name="name" class="form-control" placeholder="Название роли" value="{{old('title')}}">
                    </div>
                    @if ($errors->has('title'))
                        <span class="invalid-feedback text-red" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                    @endif
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Сохранить</button>
            </div>
        </form>
    </div>
    <!-- /.box-body -->
</div>