<template>
    <div>
        <ticket-nav-component></ticket-nav-component>
        <div class="main-wrapper">
    <!-- ticket contents  -->
            <ul class="list-group">
                <li v-for="ticket in tickets">
                    <ticket-component
                        v-bind:ticket="ticket"
                    > </ticket-component>
                </li>
            </ul>
    <!-- ticket contents -->
            <new-ticket-button-component v-on:create-ticket-event="createBros(ticketNum)"></new-ticket-button-component>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                ticketNum: 0,
                selectTickets: [],
                tickets: [],
                edit: false,
                results: [],
            }
        },
        mounted(){
            let url = location.href + '/api/tickets';
            console.log("mounted start---------" + url)
            axios
                .get(url)
                .then(response => (this.tickets = response.data))
            console.log(this.tickets)
            console.log("mounted   end---------" + url)
        },
        methods: {
            // apiを叩いて、レスポンスをselectTicketsに格納
            getTickets() {
                let url = location.href + '/api/tickets';
                console.log("getTickets start---------" + url)
                axios
                    .get(url)
                    .then(response => (this.tickets = response.data))
                console.log(this.tickets)
                console.log("getTickets   end---------" + url)
            },
            createBros(parentId) {
                let newTicket = {
                    id: this.ticketNum,
                    parentId: parentId,
                    text: "new ticket",
                    openFlag: false,
                }
                this.tickets.push(newTicket)
            },
            addSelectTickets(ticket) {
                this.selectTickets.push({
                    id: ticket.id,
                    text: ticket.text,
                });
            }
        }
    }
</script>

