<!--Replay search form -->
@php
    $countries = $general_helper->getCountries();
    $races = \App\Replay::$races;
    $maps = $general_helper->getReplayMaps();
    $types = $general_helper->getReplayTypes();
@endphp
<div class="widget-wrapper">
    <div class="widget-header">Поиск реплеев</div>
    <form action="{{route('replay.search')}}" method="GET" class="search-replay-form col-md-12">
        @csrf
        <div class="form-group">
            <label for="text">Имя / Чемпионат /Описание:</label>
            <input type="text" id="text" name="text" value="{{ old('championship') }}"
                   class="form-control {{ $errors->has('championship') ? ' is-invalid' : '' }}">
            @if ($errors->has('championship'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('championship') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="first_country_id">Победившая страна:</label>
            <select name="first_country_id" id="first_country_id"
                    class="custom-select {{ $errors->has('first_country_id') ? ' is-invalid' : '' }}">
                <option value="">Все</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}" {{$country->id == old('first_country_id') ? ' selected' : '' }}>{{$country->name}}</option>
                @endforeach
            </select>
            @if ($errors->has('first_country_id'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('first_country_id') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="second_country_id">Проигравшая страна:</label>
            <select name="second_country_id" id="second_country_id"
                    class="custom-select {{ $errors->has('second_country_id') ? ' is-invalid' : '' }}">
                <option value="">Все</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}" {{$country->id == old('second_country_id') ? ' selected' : '' }}>{{$country->name}}</option>
                @endforeach
            </select>
            @if ($errors->has('second_country_id'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('second_country_id') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="first_race">Победившая раса:</label>
            <select name="first_race" id="first_race"
                    class="custom-select {{ $errors->has('first_race') ? ' is-invalid' : '' }}">
                <option value="">Все</option>
                @foreach($races as $race)
                    <option value="{{$race}}" {{$race == old('first_race') ? ' selected' : '' }}>{{$race}}</option>
                @endforeach
            </select>
            @if ($errors->has('first_race'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('first_race') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="second_race">Проигравшая раса:</label>
            <select name="second_race" id="second_race"
                    class="custom-select {{ $errors->has('second_race') ? ' is-invalid' : '' }}">
                <option value="">Все</option>
                @foreach($races as $race)
                    <option value="{{$race}}" {{$race == old('second_race') ? ' selected' : '' }}>{{$race}}</option>
                @endforeach
            </select>
            @if ($errors->has('second_race'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('second_race') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="map_id">Карта:</label>
            <select name="map_id" id="map_id" class="custom-select {{ $errors->has('map_id') ? ' is-invalid' : '' }}">
                <option value="">Все</option>
                @foreach($maps as $map)
                    <option value="{{$map->id}}" {{$map->id == old('map_id') ? ' selected' : '' }}>{!! $map->name !!}</option>
                @endforeach
            </select>
            @if ($errors->has('map_id'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('map_id') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="type_id">Тип:</label>
            <select name="type_id" id="type_id"
                    class="custom-select {{ $errors->has('type_id') ? ' is-invalid' : '' }}">
                <option value="">Все</option>
                @foreach($types as $type)
                    <option value="{{$type->id}}" {{$type->id == old('type_id') ? ' selected' : '' }}>{{$type->name}}</option>
                @endforeach
            </select>
            @if ($errors->has('type_id'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('type_id') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label for="sort_by">Сортировка:</label>
            <select name="sort_by" id="sort_by" class="custom-select {{ $errors->has('sort_by') ? ' is-invalid' : '' }}">
                <option value="">Все</option>
                @foreach($general_helper->getReplaySortBy() as $sort_by => $sort_title)
                    <option value="{{$sort_by}}" {{$sort_by == old('sort_by') ? ' selected' : '' }}>{{$sort_title}}</option>
                @endforeach
            </select>
            @if ($errors->has('sort_by'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('sort_by') }}</strong>
                </span>
            @endif
        </div>
        <div class="justify-content-center display-flex">
            <button class="btn-blue search-form-btn" type="submit">
                Поиск
            </button>
        </div>
    </form>
</div>
<!--END Replay search form -->