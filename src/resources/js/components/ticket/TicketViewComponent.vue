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

        <create-modal-component
            v-if="this.createTicketFlag"
            v-bind:parent-id="parentId"
            v-on:close-event="cancelBros"
            v-on:remove-event="removeTicket"
        ></create-modal-component>
    </div>
</template>

<script>
    import ticketComponent from '@/components/ticket/TicketComponent.vue'
    import newTicketButtonComponent from '@/components/ticket/NewTicketButtonComponent.vue'
    import ticketCreateModalComponent from '@/components/ticket/modals/CreateModalComponent.vue'

    export default {
        components: {
            'ticket-component': ticketComponent,
            'create-modal-component': ticketCreateModalComponent,
            'new-ticket-button-component': newTicketButtonComponent,
        },
        data(){
            return {
                ticketNum: 0,
                selectTickets: [],
                tickets: [],
                edit: false,
                results: [],
                createTicketFlag: false,
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
                    .catch(function (error) {
                        console.log("error!!!!!!!");
                        console.log(error.config);
                        this.$router.push({path: '/login'});
                    })
                console.log(this.tickets)
                console.log("getTickets   end---------" + url)
            },
            createBros() {
                this.createTicketFlag = true;
            },
            cancelBros() {
                this.createTicketFlag = false;
            },
            addSelectTickets(ticket) {
                this.selectTickets.push({
                    id: ticket.id,
                    text: ticket.text,
                });
            },
        }
    }
</script>

