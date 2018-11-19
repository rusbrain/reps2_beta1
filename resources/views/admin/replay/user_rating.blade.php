
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Оценки пользователей @if($data->count() > 1)(последние {{$data->count()}})@endif</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Пользователь</th>
                        <th>Комментарий</th>
                        <th>Оценка</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $replay)
                        <tr>
                            <td>{{$replay->user->name}}</td>
                            <td>{{$replay->comment}}</td>
                            <td>{{$replay->rating}}</td>
                            <td>{{$replay->created_at->format('h:m d-m-Y')}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

<!-- /.modal -->