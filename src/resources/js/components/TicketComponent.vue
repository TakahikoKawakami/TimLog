<template>
<div>
    <div class="list-group-item"> <!-- 畳まれた状態のチケット -->
        <div class="ticket-container between-container">
            <div class="ticket-container vertical-container">
                <a class="ticket-element ticket-summary" href="#" v-on:click="addSelectTickets(ticket)">
                    <span class="ticket-title" v-text="ticket.text"></span>
                </a>
                <timer-component
                    v-bind:second="ticket.deadline_second"
                    v-bind:status="ticket.status"
                    ref='timer'
            ></timer-component>
            </div>
            <div class="ticket-element">
                <button
                    class="timer-btn"
                    v-if="ticket.status==0"
                    v-on:click="startTimer()"
                >
                    <ion-icon name="play-outline"></ion-icon>
                </button>
                <button
                    class="timer-btn"
                    v-if="ticket.status==1"
                    v-on:click="stopTimer()"
                >
                    <ion-icon name="pause"></ion-icon>
                </button>
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
        props: ['eachTicket'],
        data() {
            return {
                openModalFlag: false,
                edit: false,
                ticket: this.eachTicket,
            }
        },
        mounted() {
            if (this.ticket.status == 1) {
                this.startTimer();
            } else if (this.ticket.status == 0) {
                this.stopTimer();
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
            },
            startTimer() {
                console.log('timer start-----');
                this.$refs.timer.start();
                this.ticket.status = 1;

                this.updateTicketStatus();
            },
            stopTimer() {
                console.log('timer start-----');
                this.$refs.timer.stop();
                this.ticket.status = 0;

                this.updateTicketStatus();
            },

            getDateTime(date, format) {
                let targetDateTime = new Date(date);
                let result = format;
                result = result.replace(/YYYY/, targetDateTime.getFullYear());
                result = result.replace(/MM/, targetDateTime.getMonth() + 1);
                result = result.replace(/DD/, targetDateTime.getDate());

                result = result.replace(/hh/, targetDateTime.getHours());
                result = result.replace(/ii/, targetDateTime.getMinutes());
                result = result.replace(/ss/, targetDateTime.getSeconds());

                return result;
            },

            updateTicketStatus() {
                let url = location.href + "api/tickets/" + this.ticket.id;
                let now = Date.now();
                axios
                    .put(url, {
                        startDateTime: this.getDateTime(Date.now(), "YYYY-MM-DD hh:ii:ss"),
                        status: this.ticket.status,
                    })
                    .then(function(response) {
                        console.log(response);
                    })

            }
        }
    }
</script>

