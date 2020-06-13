<template>
<div>
    <div class="list-group-item"> <!-- 畳まれた状態のチケット -->
        <div class="ticket-container"> 
            <a class="ticket-summary" href="#" v-on:click="addSelectTickets(ticket)">
                <span class="ticket-title" v-text="ticket.text"></span>
                <span class="ticket-time" v-text="ticket.time"></span>
            </a>
            <div class="ticket-icon-list-group">
                <span class="ticket-timer-icon">
                    <ion-icon name="alarm-outline"></ion-icon> <!-- timer start -->
                </span>
                <!--                <span class="ticket-open-icon" @click="openModal()"> -->
                <span>
                <button class="ticket-open-icon" data-toggle="modal" data-target="#ticket-modal">
                    <ion-icon v-if="!openFlag" name="caret-forward-outline"></ion-icon> <!-- edit open -->
                    <ion-icon v-if="openFlag" name="caret-down-outline"></ion-icon> <!-- edit close -->
                </button>
                </span>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ticket-modal" tabindex="-1" role="dialog" aria-labelledby="ticket-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centerd" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticket-modal-label">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    test
                </div>
                <div class="modal-footer">
                 test2
                </div>
            </div>
        </div>
    </div>

    <!--    <MyModal @close="closeModal" v-if='openFlag'> -->
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
</div>
</template>

<script>
import MyModal from './modal.vue'
    Vue.directive('auto-focus', {
        bind: function () {
            var el = this.el;
            Vue.nextTick(function(){
                el.focus();
            });
        }
    })
    export default {
        components: { MyModal },
        props: ['ticket'],
        data() {
            return {
                openFlag: false,
                edit: false,
            }
        },
        methods: {
            addSelectTickets: function(ticket) {
                this.selectTickets.push({
                    id: ticket.id,
                    text: ticket.text,
                });
            },
            openModal() {
                this.openFlag = true;
            },
            closeModal() {
                this.openFlag = false;
            }
        }
    }
</script>

