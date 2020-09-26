<template>
    <ticket-modal-component
        v-bind:target-ticket="ticket"
        v-on:close-event="closeModal">
        <template slot="title">チケット更新</template>
        <template slot="save-button">
            <button class="btn btn-warn" style="display: inline-block"
                v-on:click="finishTicket(ticket)" >
                完了
            </button>
            <button class="btn btn-info" style="display: inline-block"
                v-on:click="storeTicket(ticket)" >
                更新
            </button>
        </template>
        <template slot="remove-button">
            <button class="btn btn-danger" style="display: inline-block"
                v-on:click='deleteTicket()'>
                削除
            </button>
        </template>
    </ticket-modal-component>
</template>

<script>
    import TicketModal from '@/components/ticket/modals/ModalComponent.vue'
    export default {
        components: { 'ticket-modal-component': TicketModal },
        props: ['targetTicket','new-create'],
        data(){
            return {
                ticketNum: 0,
                ticketId: this.targetTicket.id,
                ticket: this.targetTicket,
                edit: false,
                results: []
            }
        },
        methods: {
            getTickets(section) {
                let url = builderUri(section);
                axios.get(url).then((response) => {
                        this.results = response;
                }).catch( error => {console.log(error);});
            },
            closeModal() {
                this.$emit('close-event', this.ticket);
            },
            storeTicket(storeTicket) {
                let updateTicket = storeTicket;
                let self = this;
                let url = env.url + 'api/tickets/' + this.ticketId;
                console.log("storeTicket start-------");
                delete updateTicket.id;
                delete updateTicket.user_id;
                axios
                    .put(url, updateTicket)
                    .then(function(response) {
                        self.ticket = response.data;
                        console.log("response--");
                        console.log(response.data)
                        console.log("storeTicket end  -------");
                        self.closeModal();
                    })
                    .catch(function (error) {
                        console.log("error!!!!!!!");
                        console.log(error.config);
                    });
            },
            finishTicket(storeTicket) {
                let updateTicket = storeTicket;
                let self = this;
                let url = env.url + 'api/tickets/' + this.ticketId;
                console.log("storeTicket start-------");
                delete updateTicket.id;
                delete updateTicket.user_id;
                updateTicket.status = 3;
                axios
                    .put(url, updateTicket)
                    .then(function(response) {
                        console.log("storeTicket end  -------");
                        self.closeModal();
                    })
                    .catch(function (error) {
                        console.log("error!!!!!!!");
                        console.log(error.config);
                    });
                location.reload();
            },
            deleteTicket() {
                let url = env.url + 'api/tickets/' + this.targetTicket.id;
                let self = this;
                console.log("deleteTicket start-------");
                axios
                    .delete(url)
                    .then(function(response) {
                        console.log("storeTicket end  -------");
                        self.closeModal();
                    });
                location.reload();
            }

        }
    }
</script>

