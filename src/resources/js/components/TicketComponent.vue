<template>
<div>
    <div class="list-group-item"> <!-- 畳まれた状態のチケット -->
        <div class="ticket-container between-container">
            <div class="ticket-container vertical-container">
                <a class="ticket-element ticket-summary" href="#" v-on:click="addSelectTickets(ticket)">
                    <span class="ticket-title" v-text="ticket.text"></span>
                </a>
                <div class="ticket-element ticket-time" v-text="ticket.deadline_second"></div>
            </div>
            <div class="ticket-element ticket-icon-list-group">
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
</div>
</template>

<style lang='stylus' scoped>
.ticket-container {
    display: flex;
}
.between-container {
    justify-content: space-between;
}
.vertical-container {
    flex-direction: column;
    justify-content: space-between;
}

</style>


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

