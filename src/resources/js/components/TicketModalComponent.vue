<template>
    <MyModal v-on:close-event="closeModal()">
        <template slot="body">
            <table class="">
                <tr><td>チケット番号</td><td>{{ticket.id}}</td></tr>
                <tr><td>親チケット番号</td><td><input v-model="ticket.parent_id"></td></tr>
                <tr><td>チケット名</td><td><input v-model="ticket.text"></td></tr>
                <tr><td>予定工数</td><td><input v-model="ticket.deadline_second"></td></tr>
                <tr><td>開始予定日</td><td><input v-model="ticket.start_date_time"></td></tr>
                <tr><td>終了予定日</td><td><input v-model="ticket.deadline_date"></td></tr>
                <tr><td>メモ</td><td><input v-model="ticket.memo"></td></tr>
            </table>
        </template>
        <template slot="footer">
            <ul class="group" style="text-align: right; flex-direction: row; justify-content: space-between;">
                <li class="btn btn-danger" style="display: inline-block">削除</li>
                <li
                    class="btn btn-info"
                    style="display: inline-block"
                    v-on:click="storeTicket(ticket)"
                >登録</li>
            </ul>
        </template>
    </MyModal> <!-- エディット状態 -->
</template>

<script>
    import MyModal from './modal.vue'
    export default {
        components: { MyModal },
        props: ['targetTicket'],
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
                let url = location.href + "api/tickets/" + this.targetTicket.id;
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
                // let forUpdateArray = ticketDataArray.filter(dog => {
                //     return ticke.type === 'pomeranian';
                // });
                axios
                    .put(url, {
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
            }
        }
    }
</script>

