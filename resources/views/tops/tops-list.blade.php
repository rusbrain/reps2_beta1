
@php 
    $key_array = array(
        'points'          => ['title'=>'Top-100 pts', 'unit' => 'pts'],
        'rating'          => ['title'=>'Top-100 Репутация', 'unit' => 'кг'],
        'newstopics_count'=> ['title'=>'Top-100 Новости', 'unit' => ''],
        'replays_count'   => ['title'=>'Top-100 Replays', 'unit' => ''],
    );
    $countries = $general_helper->getCountries();
@endphp
@foreach($key_array as $key => $value)
    <a class="widget-title">{{ $value['title']}}</a>
    @if(!empty($tops_users[$key]))
    <div class="tops-info col-md-12" style="height:300px;overflow-y:scroll">
        @foreach($tops_users[$key] as $index => $user)
        <div class="widget-top-users">       
            <span class="position">#{{$index + 1}}</span>
            <a href="{{route('user_profile',['id'=>$user->id])}}" class="logged-user-avatar">
                @if(isset($user->avatar) )
                    <img class="img-circle img-bordered-sm" src="{{route('home').$user->avatar->link}}" alt="A">
                @else
                    <img class="img-circle img-bordered-sm" src="{{route('home').'/dist/img/avatar.png'}}" alt="A">
                @endif
            </a>
            <a href="{{route('user_profile',['id'=>$user->id])}}">
                <span class="user-name">{{$user->name}}</span>
            </a>
                @if($user->country_id)
                <span class="flag-icon flag-icon-{{mb_strtolower($countries[$user->country_id]->code)}}"></span>
                @else
                    <span class="flag-icon"></span>
                @endif
                @if($user->race)
                    <img class="margin-left-5" src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons[$user->race]}}" alt="">
                @else
                    <img class="margin-left-5" src="{{route('home')}}/images/emoticons/smiles/{{\App\Replay::$race_icons['All']}}" alt="">
                @endif
                <span class="color-blue user-value">{{$user[$key]}} {{$value['unit']}}</span> 
           
        </div>
        @endforeach
    </div>
    @endif      
@endforeach
