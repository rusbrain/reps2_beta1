
@extends('layouts.site')

@section('content')
    <div class="">
        <div class="row">
            <div class="page-title w-100">Результат голосования</div>
        </div>
        {{dd($answers)}}
    </div>
@endsection