<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{route('home')}}/css/bootstrap.min.css">

    <!--Flags CSS-->
    <link rel="stylesheet" href="{{route('home')}}/css/flag-icon.css">

    <!--Menu-->
    <link rel="stylesheet" href="{{route('home')}}/css/metisMenu.min.css">

    <!--CSS into View-->
    @yield('css')

    <!--Main CSS-->
    <link rel="stylesheet" href="{{route('home')}}/css/main.css">
    <link rel="stylesheet" href="{{route('home')}}/css/responsive.css">
    <link rel="stylesheet" href="{{route('home')}}/css/message.css">

    <title>Главная | Reps.ru</title>
</head>
<body>

    <div id="chatroom">    
        <chat :auth = "{{ Auth::check() ? Auth::user() : 0 }}">
        </chat>
    </div>
    <!-- Optional JavaScript -->
    <script src="{{route('home')}}/js/jquery-3.2.1.min.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{route('home')}}/js/popper.min.js"></script>
    <script src="{{route('home')}}/js/bootstrap.min.js"></script>
    <script src="{{route('home')}}/js/bootstrap-filestyle.min.js"></script>

    <!--Menu js-->
    <script src="{{route('home')}}/js/metisMenu.min.js"></script>
    <!-- jQuery Validate -->
    <script src="{{route('home')}}/js/jquery.validate.min.js"></script>

    <!--Custom scripts-->
    <script src="{{route('home')}}/js/scripts.js"></script>
    <script src="{{route('home')}}/js/socket.io.js"></script>
    <script src="{{route('home')}}/js/message.js"></script>


</body>
</html>