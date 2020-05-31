<template>
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
                <label id="nav-open" for="nav-input"><span></span></label><span class="title">TicketTimer</span>
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
</template>
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
          props: {
              laravel: {
                  tuype: string
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
