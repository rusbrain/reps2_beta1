<form method="GET" action="{{route('home.search')}}" class="search-form" id="search-form">
    @csrf
    <div>
        <input type="text" name="text" class="form-control" value="" placeholder="Поиск" >
    </div>
    <div class="position-relative">
        <select name="section" class="custom-select">
            @foreach(\App\Http\Controllers\HomeController::$search_types as $search_type => $title)
                <option value="{{$search_type}}">{{$title}}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-search btn-blue">
            <img src="{{route('home')}}/images/icons/search.png" alt="">
        </button>
    </div>
</form>