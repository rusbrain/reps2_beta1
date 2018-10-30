<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Файл № {{$file->id}}</h3>
    </div>
    <div class="box-body">
        <form action="{{route('admin.file.update', ['id' => $file->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    @if (stristr($file->type, 'image'))
                        <img src="{{route('home').'/'.$file->link}}" alt="Изображение" style="max-width: 250px;">
                    @else
                        <h3><a class="img-preview" href="{{route('admin.file.download', ['id' => $file->id])}}">Скачать</a></h3>
                    @endif

                    <div class="input-group">
                        <span class="">Заменить файл</span>
                        <input type="file" id="file" name="file">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="">Название</span>
                        <input type="text" class="form-control" placeholder="Название" name="title" value="{{$file->title}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="">Тип</span>
                        <input type="text" class="form-control" placeholder="Тип не определен" name="type" value="{{$file->type}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="">Размер (Kb)</span>
                        <input type="text" class="form-control" placeholder="Размер не определен" value="{{(int)($file->size/1024)}}" disabled>
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