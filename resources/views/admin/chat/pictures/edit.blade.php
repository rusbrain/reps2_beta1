<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{$picture->id}}</h3>
    </div>
    <div class="box-body">
        <form action="{{route('admin.chat.pictures.update', ['id' => $picture->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="">Подпись</span>
                        <input type="text" class="form-control" placeholder="Подпись" name="comment" value="{{$picture->comment}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="">Персонажи</span>
                        <input type="text" class="form-control" placeholder="Персонажи" name="charactor"  value="{{$picture->charactor}}" readonly>
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