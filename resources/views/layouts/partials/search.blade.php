<form method="GET" action="{{route('home.search')}}" class="form-inline" id="search-form">
    @csrf

    <div class="form-group">
        <label class="sr-only" for="exampleInputEmail3">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
    </div>
    <div class="form-group">
        <div class="input-group">
            <select name="section" class="form-control">
                @foreach(\App\Http\Controllers\HomeController::$search_types as $search_type => $title)
                    <option value="{{$search_type}}" @if (isset($search_section) && $search_section == $search_type)selected="selected"@endif>{{$title}}</option>
                @endforeach
            </select>
            <span class="input-group-addon" id="basic-addon2" style="background: #4890af;">
                <button type="submit" class="btn-search btn-blue">
                    <img src="{{route('home')}}/images/icons/search.png" alt="">
                </button>
            </span>
        </div>


    </div>
{{--    <div class="search_input">--}}
{{--        @php--}}
{{--            $search_text = isset($search_text) ? $search_text : '';    --}}
{{--        @endphp--}}
{{--        <input type="text" name="text" class="form-control {{ $errors->has('text') ? ' is-invalid' : '' }}"--}}
{{--             value="{{$errors->has('text') ? old('text') : $search_text }}" placeholder="Поиск" >--}}
{{--        @if ( $errors->has('text') )--}}
{{--            <span class="invalid-feedback text-red" role="alert">--}}
{{--                <strong>{{ $errors->first('text') }}</strong>--}}
{{--            </span>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--    <div class="position-relative">--}}
{{--        <select name="section" class="custom-select">--}}
{{--            @foreach(\App\Http\Controllers\HomeController::$search_types as $search_type => $title)--}}
{{--                <option value="{{$search_type}}" @if (isset($search_section) && $search_section == $search_type)selected="selected"@endif>{{$title}}</option>--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--        <button type="submit" class="btn-search btn-blue">--}}
{{--            <img src="{{route('home')}}/images/icons/search.png" alt="">--}}
{{--        </button>--}}
{{--    </div>--}}
</form>
