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
                <span>
                    <button
                        class="ticket-open-icon"
                        v-on:click="openModal()"
                    >
                        <ion-icon v-if="!openModalFlag" name="caret-forward-outline"></ion-icon> <!-- edit open -->
                        <ion-icon v-if="openModalFlag" name="caret-down-outline"></ion-icon> <!-- edit close -->
                    </button>
                </span>
            </div>
        </div>
    </div>
    <ticket-modal-component
        v-if="openModalFlag"
        v-bind:targetTicket="ticket"
        v-on:close-event="closeModal"
    ></ticket-modal-component>
<!--
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
    -->
</div>
</template>

<script>
    Vue.directive('auto-focus', {
        bind: function () {
            var el = this.el;
            Vue.nextTick(function(){
                el.focus();
            });
        }
    })
    export default {
        props: ['ticket'],
        data() {
            return {
                openModalFlag: false,
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
                this.openModalFlag = true;
            },
            closeModal() {
                this.openModalFlag = false;
            }
        }
    }
</script>

