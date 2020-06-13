<template>
<div>
    <ticket-nav-component></ticket-nav-component>
    <div class="main-wrapper">
<!-- ticket contents  -->
        <ul class="list-group">
            <li v-for="ticket in Tickets">
                <ticket-component v-bind:ticket="ticket"></ticket-component>
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
                Tickets: [],
                edit: false,
                results: []
            }
        },
        mounted(){
            axios
            .get('https://ticket-timer.dev.apps.shaba-room.work/public/api/tickets')
            .then(response => (this.Tickets = response.data))
        },
        methods: {
            getTickets(section) {
                let url = builderUri(section);
                axios.get(url).then((response) => {
                        this.results = response;
                }).catch( error => {console.log(error);});
            },
            createBros(parentId) {
                let newTicket = {
                    id: this.ticketNum,
                    parentId: parentId,
                    text: "new ticket",
                    openFlag: false,
                }
                this.Tickets.push(newTicket)
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

