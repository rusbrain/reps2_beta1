<div class="left-inner-replay-sidebar">
    <div class="sidebar-inner-widget">
        <div class="sidebar-inner-widget-title">Поиск реплеев</div>
        @php
            $countries = $general_helper->getCountries();
            $races = \App\Replay::$races;
            $maps = $general_helper->getReplayMaps();
            $types = $general_helper->getReplayTypes();
        @endphp

        <div class="sidebar-inner-widget-content">
            <form action="{{route('replay.users')}}" method="GET">
                @csrf
                <div class="form-group">
                    <label for="text">Имя/Чемпионат/Описание</label>
                    <div class="error-country"></div>
                    <input type="text" id="text" name="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="first_country_id">Победившая страна:</label>
                    <div class="error-country"></div>
                    <select size=1 id="first_country_id" name="first_country_id" class="form-control country">
                        <option value="">Все</option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="second_country_id">Проигравшая страна:</label>
                    <div class="error-country"></div>
                    <select size=1 id="second_country_id" name="second_country_id" class="form-control country">
                        <option value="">Все</option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="first_race">Победившая раса:</label>
                    <div class="error-country"></div>
                    <select size=1 id="first_race" name="first_race" class="form-control country">
                        @foreach($races as $key => $race)
                            <option value="{{$key}}">{{$race}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="second_race">Проигравшая раса:</label>
                    <div class="error-country"></div>
                    <select size=1 id="second_race" name="second_race" class="form-control country">
                        @foreach($races as $key => $race)
                            <option value="{{$key}}">{{$race}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="second_race">Карта:</label>
                    <div class="error-country"></div>
                    <select size=1 id="map_id" name="map_id" class="form-control country">
                        <option value="">Все</option>
                        @foreach($maps as $map)
                            <option value="{{$map->id}}">{!! $map->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="second_race">Тип:</label>
                    <div class="error-country"></div>
                    <select size=1 id="type_id" name="type_id" class="form-control country">
                        <option value="">Все</option>
                        @foreach($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="error-country"></div>
                    <button type="submit" class="btn btn-primary">Поиск</button>
                </div>
            </form>
        </div>
    </div>
</div>