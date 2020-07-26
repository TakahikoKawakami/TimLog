<template>
    <MyModal v-on:close-event="closeModal()">
        <template slot="body">
            <table class="">
                <tr><td>チケット番号</td><td><input v-model="ticket.id"></td></tr>
                <tr><td>親チケット番号</td><td>{{ ticket.parent_id }}</td></tr>
                <tr><td>チケット名</td><td>{{ ticket.text }}</td></tr>
                <tr><td>予定工数</td><td>{{ ticket.deadline_second }}</td></tr>
                <tr><td>開始予定日</td><td>{{ ticket.start_date_time }}</td></tr>
                <tr><td>終了予定日</td><td>{{ ticket.deadline_date }}</td></tr>
                <tr><td>メモ</td><td>{{ ticket.memo }}</td></tr>
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
                let url = location.href + "api/tickets/" + storeTicket.id;
                console.log("storeTicket start-------");
                axios
                    .put(url, {
                        parentId: storeTicket.parent_id
                    })
                    .then(function(response) {
                        console.log(response);
                    })
                console.log("storeTicket end  -------");
            }
        }
    }
</script>

