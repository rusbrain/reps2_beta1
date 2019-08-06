<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Добавить в свою категория</h3>
    </div>
    <div class="box-body">
        <form action="{{route('admin.chat.pictures.category.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="row col-md-12"> 
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="">Kатегория</span>
                            <input type="text" class="form-control" placeholder="Kатегория" name="name">
                        </div>
                    </div>          
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="">Подпись</span>
                            <input type="text" class="form-control" placeholder="Подпись" name="comment">
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