<template>
    <ticket-modal-component
        v-bind:target-ticket="this.ticket"
        v-on:close-event="closeModal">
        <template slot="save-button">
            <button class="btn btn-info" style="display: inline-block"
                v-on:click="storeTicket(ticket)" >
                登録
            </button>
        </template>
        <template slot="remove-button">
            <button class="btn btn-danger" style="display: inline-block"
                v-on:click='cancel()'>
                キャンセル
            </button>
        </template>
    </ticket-modal-component>
</template>

<script>
    import TicketModal from '@/components/ticket/modals/ModalComponent.vue'
    export default {
        components: { 'ticket-modal-component': TicketModal },
        props: ['parentId'],
        data(){
            return {
                ticketNum: 0,
                ticket: {
                    parentId: this.parentId,
                    text: null,
                    memo: null,
                    startDateTime: null,
                    stopDateTime: null,
                    deadlineDate: null,
                    deadlineSecond: null,
                    runStartDateTime: null,
                    runStopDateTime: null,
                    runtimeSecond: null,
                    status: null,
                    displaySequence: null
                }
            }
        },
        methods: {
            closeModal() {
                this.$parent.getTickets();
                this.$emit('close-event');
            },
            cancel() {
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
                    runStartDateTime: storeTicket.run_start_date_time,
                    runStopDateTime: storeTicket.run_stop_date_time,
                    runtimeSecond: storeTicket.runtime_second,
                    status: 0,
                    displaySequence: storeTicket.display_sequence
                };

                axios
                    .post(url, ticketDataArray)
                    .then(function(response) {
                        console.log(response);
                    })
                console.log("storeTicket end  -------");
                this.$parent.getTickets();
                this.closeModal();
            }
        }
    }
</script>

