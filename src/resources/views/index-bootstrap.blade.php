<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ticket Timer</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<!--JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- vue,.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
<!-- css -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href"{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        header {
            padding:10px;
            background: skyblue;
        }
        header .title {
            font-size: 3rem;
        }
        .ticket-container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        .ticket-summary {
        }
        .ticket-icon-list-group {

        }
        .ticket-open-icon {
          margin-left: auto;
        }
        .nav-wrapper {
        }
    </style>

<!-- icon -->
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

</head>
<body>
<div>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        <div id='app'>
            <all-component></all-component>
        </div>
    </div>
</div>
<!-- <script src="{{ asset('js/app.js') }}"></script> -->
        <!-- サーバ環境ではassetが必要？ -->
        <!-- <script src="{{ asset(mix('/js/app.js')) }}"></script>  -->
        <!-- gitpod環境？ -->
        <script src="{{ mix('/js/app.js') }}"></script>
  </body>
</html>

