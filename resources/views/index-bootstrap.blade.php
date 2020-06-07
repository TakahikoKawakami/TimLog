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
    <link href"{{ mix('css/app.css') }}" rel="stypesheet" type="text/css">
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

        /*--ハンバーガーメニュー--*/
        header {
            padding:10px;
            background: skyblue;
        }
        header .title {
            font-size: 3rem;
        }
        #nav-drawer  {
            position: relative;
        }
        .nav-unshown {
            display: none;
        }
        #nav-open {
            display: inline-block;
            width: 30px;
            height: 22px;
            vertical-align: middle;
        }
        #nav-open span, #nav-open span:before, #nav-open span:after {
            position: absolute;
            height: 3px;
            width: 25px;
            border-radius: 3px;
            background: #555;
            display: block;
            content: '';
            cursor: pointer;
        }
        #nav-open span:before {
            bottom: -8px;
        }
        #nav-open span:after {
            bottom: -16px;
        }
        #nav-close {
            display: none;
            position: fixed;
            z-index: 99;
            top:  0;
            width: 30%;
            right: 0%;
            height: 100%;
            background: black;
            opacity: 0;
            transition: .3s ease-in-out;
        }
        #nav-content {
            overflow: auto;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;/*最前面に*/
            width: 70%;/*右側に隙間を作る（閉じるカバーを表示）*/
            max-width: 330px;/*最大幅（調整してください）*/
            height: 100%;
            background: #fff;/*背景色*/
            transition: .3s ease-in-out;/*滑らかに表示*/
            -webkit-transform: translateX(-105%);
            transform: translateX(-105%);/*左に隠しておく*/
        }
        /*チェックが入ったらもろもろ表示*/
        #nav-input:checked ~ #nav-close {
            display: block;/*カバーを表示*/
            opacity: .5;
        } 
        #nav-input:checked ~ #nav-content {
            -webkit-transform: translateX(0%);
            transform: translateX(0%);/*中身を表示（右へスライド）*/
            box-shadow: 6px 0 25px rgba(0,0,0,.15);
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
        <header>
    <!-- nav -->
                <example-component></example-component>
    <!-- nav -->
        </header>
            <ticket-nav-component></ticket-nav-component>
            <ticket-view-component></ticket-view-component>
        </div>
    </div>
</div>
<!-- <script src="{{ asset('js/app.js') }}"></script> -->
        <script src="{{ asset(mix('/js/app.js')) }}"></script>
  </body>
</html>


