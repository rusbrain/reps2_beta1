<form method="get" action="{{route('home.search')}}" class="form-inline my-2 my-lg-0 search-form" id="search-form">
    @csrf
    <input class="form-control mr-sm-2 search-input" name="search" type="search" placeholder="Search" aria-label="Search">
    <select name="section" id="section" class="form-control search-select">
        @foreach(\App\Http\Controllers\HomeController::$search_types as $search_type => $title)
            <option value="{{$search_type}}">{{$title}}</option>
        @endforeach
    </select>
    <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
</form>