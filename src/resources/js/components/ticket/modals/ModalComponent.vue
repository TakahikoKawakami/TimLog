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
                <tr><td>計測開始日</td><td><input v-model="ticket.run_start_date_time"></td></tr>
                <tr><td>計測停止日</td><td><input v-model="ticket.run_stop_date_time"></td></tr>
                <tr><td>実行時間</td><td><input v-model="ticket.runtime_second"></td></tr>
                <tr><td>メモ</td><td><input v-model="ticket.memo"></td></tr>
                <tr><td>表示順</td><td><input v-model="ticket.display_sequence"></td></tr>
            </table>
        </template>
        <template slot="footer">
            <div class="group" style="text-align: right; flex-direction: row; justify-content: space-between;">
                <button class="btn btn-danger" style="display: inline-block">削除</button>
                <slot name="save-button"> </slot>
            </div>
        </template>
    </MyModal> <!-- エディット状態 -->
</template>

<script>
    import MyModal from '@/components/base/modal.vue'
    export default {
        components: { MyModal },
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
                this.closeModal();
            }
        }
    }
</script>

