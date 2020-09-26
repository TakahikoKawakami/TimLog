<template>
    <div>
        <!-- <ticket-nav-component></ticket-nav-component> -->
        <div class="main-wrapper">
    <!-- ticket contents  -->
            <draggable
                class="list-group"
                tag="ul"
                handle=".handle-icon"
                v-on:start="draggableStart"
                v-on:end="draggableEnd"
                v-on:sort="draggableSort"
            >
                <li
                    class="list-group-item list-group-item-action"
                    v-for="ticket in tickets"
                    v-bind:id="ticket.id"
                >
                    <div class="list-container between-container">
                    <div class="handle"><ion-icon class="handle-icon" name="reorder-four-outline"></ion-icon></div>
                    <ticket-component
                        ref="'ticket' + ticket.id"
                        v-bind:each-ticket="ticket"
                        v-bind:parent-id="parentId"
                    > </ticket-component>
                    </div>
                </li>
            </draggable>
            <!-- <a class= "list-group-item list-group-item-action ">
                <ticket-component
                    ref="'ticket' + ticket.id"
                    v-bind:each-ticket="dummyTicket"
                    v-bind:parent-id="parentId"
                > </ticket-component>
            </a> -->
    <!-- ticket contents -->
            <new-ticket-button-component v-on:create-ticket-event="createBros()"></new-ticket-button-component>
        </div>

        <create-modal-component
            v-if="this.createTicketFlag"
            v-bind:props-parent-id="parentId"
            v-bind:props-ticket-num="tickets.length"
            v-on:close-event="cancelBros"
        ></create-modal-component>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import ticketComponent from '@/components/ticket/TicketComponent.vue'
    import newTicketButtonComponent from '@/components/ticket/NewTicketButtonComponent.vue'
    import ticketCreateModalComponent from '@/components/ticket/modals/CreateModalComponent.vue'

    export default {
        components: {
            'draggable': draggable,
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
                parentId: this.$route.params.id,
                dummyTicket: "",
                sortArray:[],
            }
        },
        watch: {
            '$route'(to, from) {
                console.log("parentid before: " + this.parentId);
                this.parentId = to.params.id;
                this.getTickets(to.params.id);
                console.log("parentid after: " + this.parentId);
            },
            tickets(value) {
                console.log("------watch tickets-------");
                console.log(this.tickets);
                console.log(value);
                console.log("------watch tickets-------");
            }
        },
        created() {
            if (this.parentId == undefined) {
                this.parentId = 0;
            }
        },
        mounted(){
            console.log('isLogin : ' + state.isLogin);
            this.getTickets(this.parentId);
            console.log("parentId : " + this.parentId);
            console.log(this.tickets)
            // console.log("mounted   end---------" + url)
        },
        methods: {
            // apiを叩いて、レスポンスをselectTicketsに格納
            getTickets(parentId) {
                let self = this;
                let url = env.url + 'api/tickets';
                console.log("getTickets start---------" + url)
                axios
                    .get( url, {
                        params: {
                            parent_id: parentId
                        }
                    })
                    .then(response => (this.tickets = response.data))
                    .catch(function (error) {
                        console.log("error!!!!!!!");
                        console.log(error.config);
                        state.isLogin = false;
                        $cookies.set("access_token", '');
                        self.$router.push({path: '/login'});

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
            draggableStart(event, ui) {
            },
            draggableEnd(evnet, ui) {
            },
            draggableSort(event) {
                let sortedHtmlElements = Array.from( event.to.children );
                let sortedIds = sortedHtmlElements.map((element, key) => (
                    {"ticket_id": element.id, "sequence": key})
                );
                console.log("------sort------------");
                console.log(sortedIds);
                console.log("------sort------------");

                let self = this;
                let url = env.url + "api/ticketDisplaySequence";
                axios
                    .put(url, { "sortArray": sortedIds })
            },
        }
    }
</script>

<style lang='stylus' scoped>
    .main-wrapper {
    margin-left: auto;
    margin-right: auto;
    width: 80%;
    }
    .list-container {
        display: flex;
    }
    .left-container {
        justify-content: start;
    }
    .between-container {
        justify-content: space-between;
    }
    .handle {
        // position: relative;
        display:inline-block;
    }
    .handle .handle-icon {
        // position: absolute;
        // margin: auto;
        font-size: 3rem;
        cursor:-moz-grab;
        cursor:-webkit-grab;
        cursor: grab;
    }
    .handle .handle-icon:active {
        cursor:-moz-grabbing;
        cursor:-webkit-grabbing;
        cursor: grabbing;
    }
</style>
