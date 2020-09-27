<template>
    <ticket-modal-component
        v-bind:target-ticket="this.ticket"
        v-on:close-event="closeModal">
        <template slot="title">チケット作成</template>
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
    import moment from 'moment-timezone'
    export default {
        components: { 'ticket-modal-component': TicketModal },
        props: ['propsParentId', 'propsTicketNum'],
        data(){
            return {
                ticketNum: this.propsTicketNum,
                parentId: this.propsParentId,
                ticket: {
                    parent_id: this.propsParentId,
                    text: null,
                    memo: null,
                    start_date_time: moment(moment().format("YYYY-MM-DD")),
                    stop_date_time: moment(moment().format("YYYY-MM-DD")),
                    deadline_date: moment(moment().format("YYYY-MM-DD")),
                    deadline_second: 0,
                    run_start_date_time: moment(moment().format("YYYY-MM-DD")),
                    run_stop_date_time: moment(moment().format("YYYY-MM-DD")),
                    runtime_second: 0,
                    status: 0,
                    display_sequence: 0
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
                let url = env.url + 'api/tickets';
                let self = this;
                console.log("storeTicket start-------");
                if (this.parentId == null) {
                    this.parentId = 0;
                }
                axios
                    .post(url, storeTicket)
                    .then(function(response) {
                        self.ticket = response.data;
                        console.log(response);

                        let displaySequence = {"ticket_id": self.ticket.id, "sequence": self.propsTicketNum}
                        url = env.url + 'api/ticketDisplaySequence';
                        axios
                            .post(url, displaySequence)
                            .then(function(response) {
                                console.log(response);
                                console.log("storeTicket end  -------");
                                // self.$parent.getTickets();
                                self.$router.push({path: '/ticket'});
                                self.closeModal();
                            })
                            .catch(function (error) {
                                console.log("error!!!!!!!");
                                console.log(error.config);
                                self.$router.push({path: '/ticket'});
                            });
                    });
            }
        }
    }
</script>

