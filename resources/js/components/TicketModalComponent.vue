<template>
    <MyModal>
        <template slot="body">
            <div class="">
                <span>チケット番号：{{ ticket.id }}</span><span>親チケット番号：{{ ticket.parentId }}</span>
            </div>
            <span class="text" v-if="!edit" v-text="ticket.text" v-on:click="edit = true"></span>
            <span class="edit-icon" v-show="!edit" v-on:click="edit = true">
                <ion-icon name="create-outline"></ion-icon>
            </span>
            <input v-if="edit" type="text" v-model="ticket.text" v-on:blur="edit = false" v-auto-focus>
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
        props: ['ticket'],
        data(){
            return {
                ticketNum: 0,
                selectTickets: [],
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
            }
        }
    }
</script>

