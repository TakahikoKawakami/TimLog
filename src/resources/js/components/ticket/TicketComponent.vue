<template>
<div>
    <div class="list-group-item"> <!-- 畳まれた状態のチケット -->
        <div class="ticket-container vertical-container">
            <div class="ticket-container between-container">
                <div class="ticket-container vertical-container">
                    <a class="ticket-element ticket-summary" href="#" v-on:click="addSelectTickets(ticket)">
                        <span class="ticket-title" v-text="ticket.text"></span>
                    </a>
                    <timer-component
                        v-bind:second="ticket.deadline_second - runtimeSecond"
                        v-bind:status="ticket.status"
                        ref='timer'
                ></timer-component>
                </div>
                <div class="ticket-element">
                    <button
                        class="timer-btn"
                        v-if="ticket.status==0 || ticket.status == 2"
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
    </div>
    <div class="list-group-item"
        v-if="openChildTicketFlag">
        <ticket-view-component
            v-bind:parent-id="ticket.id"
        ></ticket-view-component>
    </div>
    <div class="list-group-item">
        <button
            class="ticket-open-icon element-wide"
            v-on:click="toggleChildList()"
        >
            <ion-icon v-if="!openChildTicketFlag" name="caret-forward-outline"></ion-icon> <!-- edit open -->
            <ion-icon v-if="openChildTicketFlag" name="caret-down-outline"></ion-icon> <!-- edit close -->
        </button>
    </div>

    <update-modal-component
        v-if="this.openModalFlag"
        v-bind:target-ticket="ticket"
        v-bind:new-create="ticket.newCreated"
        v-on:close-event="closeModal"
    ></update-modal-component>
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
    .element-wide {
        width: 100%;
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
    import timerComponent from '@/components/TimerComponent.vue'
    import ticketViewComponent from '@/components/ticket/TicketViewComponent.vue'
    import ticketUpdateModalComponent from '@/components/ticket/modals/UpdateModalComponent.vue'
    import moment from 'moment-timezone'

    export default {
        components: {
            'timer-component': timerComponent,
            'ticket-view-component': ticketViewComponent,
            'update-modal-component': ticketUpdateModalComponent,
        },
        props: ['eachTicket', 'parentId'],
        data() {
            return {
                openModalFlag: false,
                openChildTicketFlag: false,
                edit: false,
                ticket: this.eachTicket,
                runtimeSecond: Number(this.eachTicket.runtime_second),
            }
        },
        created() {
            moment.tz.setDefault('Asia/Tokyo');
            if (this.ticket.status == 1) {
                let nowDateTime = moment(moment().format("YYYY-MM-DD hh:mm:ss"));
                let lastRunStartDateTime = moment(this.ticket.run_start_date_time);
                let leaveSecond = nowDateTime.diff(lastRunStartDateTime, "seconds");
                this.runtimeSecond += leaveSecond;
                console.log("---created");
                console.log("last run start: " + lastRunStartDateTime);
                console.log("now           : " + nowDateTime);
                console.log("last run start: " + lastRunStartDateTime.format("YYYY-MM-DD hh:mm:ss"));
                console.log("now           : " + nowDateTime.format("YYYY-MM-DD hh:mm:ss"));
                console.log("leaveSecond   : " + leaveSecond);
                console.log("runtimeSecond : " + this.runtimeSecond);
            }
        },
        mounted() {
            if (this.ticket.status == 1) {
                this.$refs.timer.start();
            }
        },
        methods: {
            addSelectTickets: function(ticket) {
                this.selectTickets.push({
                    id: ticket.id,
                    text: ticket.text,
                });
            },
            toggleChildList() {
                console.log("reqire parentId: " + this.ticket.id);
                this.$parent.parentId = this.ticket.id;
                this.openChildTicketFlag = !this.openChildTicketFlag;
            },
            openModal() {
                this.openModalFlag = true;
            },
            closeModal() {
                this.openModalFlag = false;
                this.$parent.getTickets();
            },
            startTimer() {
                console.log('timer start-----');
                this.$refs.timer.start();
                this.ticket.status = 1;
                this.ticket.run_start_date_time = moment().format('YYYY-MM-DD hh:mm:ss');

                let runStartDateTime = moment(this.ticket.run_start_date_time);
                let runStopDateTime = moment(this.ticket.run_stop_date_time);
                console.log("startDateTime: " + runStartDateTime.format('YYYY-MM-DD hh:mm:ss'));
                console.log("stopDateTime : " + runStopDateTime.format('YYYY-MM-DD hh:mm:ss'));

                let diff = runStopDateTime.diff(runStartDateTime, "seconds");
                console.log("start: " + runStartDateTime + "ms");
                console.log("stop : " + runStopDateTime + "ms");
                console.log("diff: " + diff + "s");
                console.log("残: " + this.ticket.runtime_second + "s");

                this.updateTicket();
            },
            stopTimer() {
                console.log('timer stop-----');
                this.$refs.timer.stop();
                this.ticket.status = 2;
                this.ticket.run_stop_date_time = moment().format('YYYY-MM-DD hh:mm:ss');

                let runStartDateTime = moment(this.ticket.run_start_date_time);
                let runStopDateTime = moment(this.ticket.run_stop_date_time);
                console.log("startDateTime: " + runStartDateTime.format('YYYY-MM-DD hh:mm:ss'));
                console.log("stopDateTime : " + runStopDateTime.format('YYYY-MM-DD hh:mm:ss'));

                let diff = runStopDateTime.diff(runStartDateTime, "seconds");
                this.ticket.runtime_second += diff;
                console.log("start: " + runStartDateTime + "ms");
                console.log("stop : " + runStopDateTime + "ms");
                console.log("diff: " + diff + "s");
                console.log("残: " + this.ticket.runtime_second + "s");

                this.updateTicket();
            },

            createTicket() {
                let url = location.href + "api/tickets";
                let now = Date.now();
                axios
                    .post(url, {
                        status: this.ticket.status,
                        runStartDateTime: this.ticket.run_start_date_time,
                        runStopDateTime: this.ticket.run_stop_date_time,
                        runtimeSecond: this.ticket.runtime_second,
                        memo: this.ticket.memo,
                        startDateTime: this.ticket.start_date_time,
                        endDateTime: this.ticket.end_date_time,
                        deadlineSecond: this.ticket.deadline_second
                    })
                    .then(function(response) {
                        console.log(response);
                    })
            },

            updateTicket() {
                let url = location.href + "api/tickets/" + this.ticket.id;
                let now = Date.now();
                axios
                    .put(url, {
                        status: this.ticket.status,
                        runStartDateTime: moment(this.ticket.run_start_date_time).format("YYYY-MM-DD hh:mm:ss"),
                        runStopDateTime: moment(this.ticket.run_stop_date_time).format("YYYY-MM-DD hh:mm:ss"),
                        runtimeSecond: this.ticket.runtime_second,
                    })
                    .then(function(response) {
                        console.log(response);
                    })
            },

            deleteTicket() {
                let url = location.href + "api/tickets/" + this.ticket.id;
                let now = Date.now();
                axios
                    .delete(url)
                    .then(function(response) {
                        console.log(response);
                    })
            },

            isset(data) {
                if(data === "" || data === null || data === undefined){
                    return false;
                }else{
                    return true;
                }
            }
        }
    }
</script>

