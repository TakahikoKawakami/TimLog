<template>
    <ticket-modal-component
        v-bind:target-ticket="ticket"
        v-bind:new-create="ticket.newCreated"
        v-on:close-event="closeModal">
        <template slot="save-button">
            <button class="btn btn-info" style="display: inline-block"
                v-on:click="storeTicket(ticket)" >
                登録
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
                this.$emit('close-event');
            },
            storeTicket(storeTicket) {
                let url = location.href + "api/tickets";
                console.log("storeTicket start-------");
                let ticketDataArray = {
                    parentId: storeTicket.parent_id,
                    text: storeTicket.text,
                    memo: storeTicket.memo,
                    startDateTime: storeTicket.start_date_time,
                    stopDateTime: storeTicket.stop_date_time,
                    deadlineDate: storeTicket.deadline_date,
                    deadlineSecond: storeTicket.deadline_second,
                    status: storeTicket.status,
                    displaySequence: storeTicket.display_sequence
                };

                axios
                    .post(url, {
                        parentId: storeTicket.parent_id,
                        text: storeTicket.text,
                        memo: storeTicket.memo,
                        startDateTime: storeTicket.start_date_time,
                        stopDateTime: storeTicket.stop_date_time,
                        deadlineDate: storeTicket.deadline_date,
                        deadlineSecond: storeTicket.deadline_second,
                        status: storeTicket.status,
                        displaySequence: storeTicket.display_sequence
                    })
                    .then(function(response) {
                        console.log(response);
                    })
                console.log("storeTicket end  -------");
                this.closeModal();
            }
        }
    }
</script>

