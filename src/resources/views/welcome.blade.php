<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TimLog</title>
<!-- bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<!--JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- vue,.js -->
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0px;
            }
            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                /* display: flex; */
                justify-content: center;
                /* margin-top: 100px; */
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 2rem;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .title{
                font-size: 8rem;
                width:100vw;
                background-color: skyblue;
            }

            .text {
                /* height:500px; */
                margin-bottom: 30px;
            }

            footer {
                /*footerの装飾*/
                width: 100%;
                background-color: grey;
                color: #fff;
                text-align: center;
                padding: 10px 0;
                position: absolute;/*←絶対位置*/
                bottom: 0; /*下に固定*/
            }
        </style>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('css/app.css') }}" rel="stypesheet" type="text/css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <div class="title-wrapper">
                    TimLog
                    </div>
                </div>
                <div class="text">
                    <h3>日々のかかった時間を管理しましょう!</h3><br />
                    TimLog は、TODOリストとタイマーを組み合わせたアプリです。<br />
                    するべきタスクが何分かかったのか、予定よりどれだけオーバーしたのかを記録します。<br />
                    日々のかかった時間を整理し、次に活かしましょう。<br />
                    <br />
                    フリーで、ユーザー登録もIDとパスワードのみ。<br />
                    お気軽にご利用下さい。<br />
                    <br />
                </div>

                <div class="links">
                    <a href="/login">ログイン</a>
                    <a href="/register">新規登録</a>
                </div>
            </div>
        </div>
        <footer>
            ver 1.0.0
        </footer>
        <script src="{{ asset(mix('/js/app.js')) }}"></script>
    </body>
</html>
