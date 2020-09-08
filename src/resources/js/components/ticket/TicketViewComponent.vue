<template>
    <div>
        {{ parentId }}
        <!-- <ticket-nav-component></ticket-nav-component> -->
        <div class="main-wrapper">
    <!-- ticket contents  -->
            <ul class="list-group">
                <li v-for="ticket in tickets">
                    <ticket-component
                        ref="'ticket' + ticket.id"
                        v-bind:each-ticket="ticket"
                        v-bind:parent-id="parentId"
                    > </ticket-component>
                </li>
            </ul>
    <!-- ticket contents -->
            <new-ticket-button-component v-on:create-ticket-event="createBros()"></new-ticket-button-component>
        </div>
    </div>
</template>

<script>
    import ticketComponent from '@/components/ticket/TicketComponent.vue'
    import newTicketButtonComponent from '@/components/ticket/NewTicketButtonComponent.vue'

    export default {
        components: {
            'ticket-component': ticketComponent,
            'new-ticket-button-component': newTicketButtonComponent,
        },
        data(){
            return {
                ticketNum: 0,
                selectTickets: [],
                tickets: [],
                edit: false,
                results: [],
                newTicket: null,
                parentId: 0,
            }
        },
        mounted(){
            console.log("parentId : " + this.parentId);
            let url = location.href + 'api/tickets';
            console.log("mounted start---------" + url)
            axios
                .get( url, {
                    params: {
                        parent_id: this.parentId
                    }
                })
                .then(response => (this.tickets = response.data))
            console.log(this.tickets)
            console.log("mounted   end---------" + url)
        },
        // watch: {
        //     parentId: function() {
        //         console.log("reqire parentId: " + this.parentId);
        //         let url = location.href + 'api/tickets';
        //         console.log("getTickets start---------" + url)
        //         axios
        //             .get( url, {
        //                 params: {
        //                     parent_id: this.parentId
        //                 }
        //             })
        //             .then(response => (this.tickets = response.data))
        //         console.log(this.tickets)
        //         console.log("getTickets   end---------" + url)
        //     },
        // },
        methods: {
            // apiを叩いて、レスポンスをselectTicketsに格納
            getTickets() {
                let url = location.href + 'api/tickets';
                console.log("getTickets start---------" + url)
                axios
                    .get( url, {
                        params: {
                            parent_id: this.parentId
                        }
                    })
                    .then(response => (this.tickets = response.data))
                console.log(this.tickets)
                console.log("getTickets   end---------" + url)
            },
            createBros() {
                let newTicket = {
                    parent_id: this.parentId,
                    text: "new ticket",
                    newCreated:true,
                }
                let newTicketId = "ticket" + newTicket.id;
                this.tickets.push(newTicket);
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

