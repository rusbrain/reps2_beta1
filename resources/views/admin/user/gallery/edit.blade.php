<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{$gallery->id}}</h3>
    </div>
    <div class="box-body">
        <form action="{{route('admin.user.gallery.update', ['id' => $gallery->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="">Подпись</span>
                        <input type="text" class="form-control" placeholder="Подпись" name="comment" value="{{$gallery->comment}}">
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