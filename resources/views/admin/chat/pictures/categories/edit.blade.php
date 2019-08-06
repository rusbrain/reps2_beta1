<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{$category->id}}</h3>
    </div>
    <div class="box-body">
        <form action="{{route('admin.chat.pictures.category.update', ['id' => $category->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="">Kатегория</span>
                        <input type="text" class="form-control" placeholder="Kатегория" name="name" value="{{$category->name}}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="">Подпись</span>
                        <input type="text" class="form-control" placeholder="Подпись" name="comment" value="{{$category->comment}}">
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