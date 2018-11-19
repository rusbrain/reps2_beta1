<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{$map->id}}</h3>
    </div>
    <div class="box-body">
        <form action="{{route('admin.replay.map.update', ['id' => $map->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <img src="{{route('home').'/'.$map->url}}" alt="Изображение">
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="">Название</span>
                        <input type="text" class="form-control" placeholder="Подпись" name="name" value="{{$map->name}}">
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