<div id="chatroom">    
    <chat :auth = "{{ Auth::check() ? Auth::user() : 0 }}">
    </chat>
</div>
