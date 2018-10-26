@extends('layouts.site')
@inject('general_helper', 'App\Services\GeneralViewHelper')
@section('content')
    <div class="">
        <div class="page-title row">Home page</div>
        <div class="row">
            <div class="col w-100">

            </div>
        </div>
        <div class="row">
            <div class="page-title w-100">Gosu реплеи</div>
            <div class="col-12">
                @if(!empty($general_helper->getLastGosuReplay()))
                    @foreach($general_helper->getLastGosuReplay() as $replay)
                        <div>
                            <p></p>
                        </div>
                    @endforeach
                    <a class="view-results" href="">Ещё</a>
                @else
                    <p class="">There is no Gosu replays</p>
                @endif
            </div>
        </div>
    </div>
@endsection