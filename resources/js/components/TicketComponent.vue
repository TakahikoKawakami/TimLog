<template>
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
                <span class="ticket-open-icon" v-on:click="openFlag = !openFlag">
                    <ion-icon v-if="!openFlag" name="caret-forward-outline"></ion-icon> <!-- edit open -->
                    <ion-icon v-if="openFlag" name="caret-down-outline"></ion-icon> <!-- edit close -->
                </span>
            </div>
        </div>
    </li>
    <li class="list-group-item" v-if="openFlag"> <!-- エディット状態 -->
        <div class="">
            <span>チケット番号：{{ ticket.id }}</span><span>親チケット番号：{{ ticket.parentId }}</span>
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
        props: ['ticket'],
        data() {
            return {
                openFlag: false,
                edit: false,
            }
        },
        methods: {
            addSelectTickets: function(ticket) {
                this.selectTickets.push({
                    id: ticket.id,
                    text: ticket.text,
                });
            }
        }
    }
</script>

