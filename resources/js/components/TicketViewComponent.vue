<template>
    <div class="main-wrapper">
<!-- ticket contents  -->
        <ul class="list-group">
            <li v-for="ticket in Tickets">
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
        data: {
            ticketNum: 0,
            selectTickets: [],
            Tickets: [
                { id: 1,
                    parentId: -1,
                    text: 'test ticket1',
                    openFlag: false,
                    time: '3.5H',
                    createDateTime: '',
                    updateDateTime: '',
                }
            ],
            edit: false,
            results: []
        },
        mounted () {
            this.getTickets('test');
        },
        methods: {
            getTickets(section) {
                let url = builderUri(section);
                axios.get(url).then((response) => {
                        this.results = response;
                }).catch( error => {console.log(error);});
            },
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
                });
            }
        }
    }
</script>

