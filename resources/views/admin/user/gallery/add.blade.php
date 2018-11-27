<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Добавить в свою галерею</h3>
    </div>
    <div class="box-body">
        <form action="{{route('admin.user.gallery.create')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="box-header">
                            <h3 class="box-title">Загрузить изображение:</h3>
                            <!-- /. tools -->
                        </div>
                        <div class="form-group">
                            <input type="file" id="image" name="image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="">Подпись</span>
                            <input type="text" class="form-control" placeholder="Подпись" name="comment">
                        </div>
                    </div>
                </div>

                <div class="row  col-md-12">
                    <div class="col-md-6">
                        <div class="input-group">
                            <label>
                                <input type="checkbox" name="for_adults" class="flat-red" value="1">
                                18+
                            </label>
                        </div>
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