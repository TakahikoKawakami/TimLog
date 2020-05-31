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
<div id="app">
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
        <header>
    <!-- nav -->
            <nav id="nav-drawer">
                <input id="nav-input" type="checkbox" class="nav-unshown">
                <label id="nav-open" for="nav-input"><span></span></label><span class="title">@{{name}}</span>
                <label id="nav-close" for="nav-input">close</label>
                <div id="nav-content">
                    <ul class="main-nav">
                        <li><a href="#">home</a></li>
                        <li><a href="#">setting</a></li>
                        <li><a href="#">how to use</a></li>
                        <li><a href="#">logout</a></li>
                    </ul>
                </div>
            </nav>
<!-- nav -->
        </header>
<!-- ticket open-ticket-bar -->
        <div class="ticket-bar-wrapper">
            <span>
                <a href="#">
                    <ion-icon name="home-outline"></ion-icon>
                </a>
            </span>
            <span v-for="ticket in selectTickets">
                <a href="#">
                    <ion-icon name="chevron-forward-outline"></ion-icon>@{{ ticket.text }}
                </a>
            </span>
            <span>
                <ion-icon name="chevron-down-outline"></ion-icon>
            </span>
        </div>
<!-- ticket open-ticket-bar -->
        <div class="main-wrapper">
<!-- ticket contents  -->
            <ul class="list-group">
                <li v-for="ticket in childTickets">
                    <ul>
                        <li class="list-group-item"> <!-- 畳まれた状態のチケット -->
                            <div class="ticket-container"> 
                                <a class="ticket-summary" href="#" v-on:click="addSelectTickets(ticket)">
                                    <span class="ticket-title" v-text="ticket.text"></span>
                                    <span class="ticket-time" v-text="ticket.time"></span>
                                </a>
                                <div class="ticket-icon-list-group">
                                    <span class="ticket-timer-icon">
                                        <ion-icon name="alarm-outline"></ion-icon> <!-- timer start -->
                                    </span>
                                    <span class="ticket-open-icon" v-on:click="ticket.openFlag = !ticket.openFlag">
                                        <ion-icon v-if="!ticket.openFlag" name="caret-forward-outline"></ion-icon> <!-- edit open -->
                                        <ion-icon v-if="ticket.openFlag" name="caret-down-outline"></ion-icon> <!-- edit close -->
                                    </span>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item" v-if="ticket.openFlag"> <!-- エディット状態 -->
                            <div class="">
                                <span>@{{ ticket.id }}</span><span>@{{ ticket.parentId }}</span>
                            </div>
                            <span class="text" v-if="!edit" v-text="ticket.text" v-on:click="edit = true"></span>
                            <span class="edit-icon" v-show="!edit" v-on:click="edit = true">
                                <ion-icon name="create-outline"></ion-icon>
                            </span>
                            <input v-if="edit" type="text" v-model="ticket.text" v-on:blur="edit = false" v-auto-focus>
                            <ul class="group" style="text-align: right; flex-direction: row; justify-content: space-between;">
                                <li class="btn btn-danger" style="display: inline-block">削除</li>
                                <li class="btn btn-info" style="display: inline-block">完了</li>
                            </ul>
                        </li> <!-- エディット状態 -->
                    </ul>
                </li>
            </ul> 
<!-- ticket contents -->
            <div align="center">
                <button class="btn btn-primary" v-on:click="createBros(parentId)">+</button>
            </div>
        </div>
    </div>
</div>
    <script>
      Vue.directive('auto-focus', {
        bind: function () {
          var el = this.el;
          Vue.nextTick(function(){
              el.focus();
          });
        }
      })
      export default {
          async mounted() {
            const ret = await window.axios.get("/api/sample");
            this.name = ret.data.name;
        },
        data() {
           name: 'auieo'
        }
      }
      const openTicket = new Vue({
        el: "#app",
        data: {
          ticketNum: 0,
          selectTickets: [],
          childTickets: [
            { id: 1,
              parentId: -1,
              text: 'test ticket1',
              openFlag: false,
              time: '3.5H',
              createDateTime: '',
              updateDateTime: '',
            }
          ],
          edit: false
       },
        methods: {
            createBros: function(parentId) {
                let newTicket = {
                    id: this.ticketNum,
                    parentId: parentId,
                    text: "new ticket",
                    openFlag: false,
                }
                this.childTickets.push(newTicket)
            },
            addSelectTickets: function(ticket) {
                this.selectTickets.push({
                    id: ticket.id,
                    text: ticket.text,
                })
            },
        }
      })
    </script>
  </body>
</html>


