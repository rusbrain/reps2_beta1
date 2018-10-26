<div class="row footer">
    <div class="col">
        <div class="footer-widget">
            <div class="footer-widget-title">Наши именинники - 25</div>
            <div class="footer-widget-content birthday">
                @if($general_helper->getBirthdayUsers())
                    @foreach($general_helper->getBirthdayUsers() as $user)
                        <div class="birthday-user">
                            @php
                                $user_birthday  = new \Carbon\Carbon($user->birthday);
                                $now = new Carbon\Carbon(\Carbon\Carbon::now()->format('Y-m-d'));
                            @endphp
                            <a href="{{route('user_profile',['id' => $user->id])}}">
                                <span>{{$user->name}}</span>
                                <span>({{$user_birthday->diff($now)->format('%y')}}),</span>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="footer-widget-footer"></div>
        </div>
    </div>
    <div class="col">
        <div class="footer-widget">
            <div class="footer-widget-title">footer-widget</div>
            <div class="footer-widget-content birthday">

            </div>
            <div class="footer-widget-footer"></div>
        </div>
    </div>
    <div class="col">
        <div class="footer-widget">
            <div class="footer-widget-title">footer-widget</div>
            <div class="footer-widget-content birthday">
            </div>
            <div class="footer-widget-footer"></div>
        </div>
    </div>
</div>