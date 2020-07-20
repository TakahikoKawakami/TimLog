<template>
    <MyModal v-on:close-event="closeModal()">
        <template slot="body">
            <table class="">
                <tr><td>チケット番号</td><td>{{ ticket.id }}</td></tr>
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
                <li class="btn btn-info" style="display: inline-block">完了</li>
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
            createBros(parentId) {
                let newTicket = {
                    id: this.ticketNum,
                    parentId: parentId,
                    text: "new ticket",
                    openFlag: false,
                }
                this.Tickets.push(newTicket)
            },
            addSelectTickets(ticket) {
                this.selectTickets.push({
                    id: ticket.id,
                    text: ticket.text,
                });
            },
            closeModal() {
                this.$emit('close-event');
            }
        }
    }
</script>

