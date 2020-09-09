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

    <create-modal-component
        v-if="this.isset(this.ticket.newCreated)"
        v-bind:target-ticket="ticket"
        v-bind:new-create="ticket.newCreated"
        v-on:close-event="deleteTicket"
    ></create-modal-component>

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
    import ticketCreateModalComponent from '@/components/ticket/modals/CreateModalComponent.vue'
    import ticketUpdateModalComponent from '@/components/ticket/modals/UpdateModalComponent.vue'
    export default {
        components: {
            'timer-component': timerComponent,
            'ticket-view-component': ticketViewComponent,
            'create-modal-component': ticketCreateModalComponent,
            'update-modal-component': ticketUpdateModalComponent,
        },
        props: ['eachTicket', 'parentId'],
        data() {
            return {
                openModalFlag: false,
                openChildTicketFlag: false,
                edit: false,
                ticket: this.eachTicket,
                runtimeSecond: this.eachTicket.runtime_second,
            }
        },
        created() {
            if (this.ticket.status == 1) {
                let lastRunStartDateTime = new Date(this.ticket.run_start_date_time);
                let nowDateTime = new Date(Date.now());
                let leaveSecond = (nowDateTime.getTime() - lastRunStartDateTime.getTime()) / 1000;
                // this.ticket.runtime_second += leaveSecond;
                this.runtimeSecond += leaveSecond
                console.log("---monted");
                console.log("last run start: " + lastRunStartDateTime);
                console.log("now           : " + nowDateTime);
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
                // this.openChildTicketFlag = !this.openChildTicketFlag;
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
                this.ticket.run_start_date_time = this.getDateTime(Date.now(), 'YYYY-MM-DD hh:ii:ss');

                let runStartDateTime = new Date(this.ticket.run_start_date_time).getTime();
                let runStopDateTime = new Date(this.ticket.run_stop_date_time).getTime();
                console.log("start: " + runStartDateTime);
                console.log("stop : " + runStopDateTime);
                console.log("残: " + this.ticket.runtime_second);

                this.updateTicket();
            },
            stopTimer() {
                console.log('timer stop-----');
                this.$refs.timer.stop();
                this.ticket.status = 0;
                this.ticket.run_stop_date_time = this.getDateTime(Date.now(), 'YYYY-MM-DD hh:ii:ss');

                let runStartDateTime = new Date(this.ticket.run_start_date_time).toISOString();
                let runStopDateTime = new Date(this.ticket.run_stop_date_time).toISOString();
                console.log("startDateTime: " + runStartDateTime);
                console.log("stopDateTime : " + runStopDateTime);

                runStartDateTime = new Date(runStartDateTime).getTime();
                runStopDateTime = new Date(runStopDateTime).getTime();
                let diff = runStopDateTime - runStartDateTime;
                let runTime = diff / 1000;
                this.ticket.runtime_second += runTime;
                console.log("start: " + runStartDateTime + "ms");
                console.log("stop : " + runStopDateTime + "ms");
                console.log("diff: " + diff + "s");
                console.log("runTime: " + runTime + "s");
                console.log("残: " + this.ticket.runtime_second + "s");

                this.updateTicket();
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
                        runStartDateTime: this.ticket.run_start_date_time,
                        runStopDateTime: this.ticket.run_stop_date_time,
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

