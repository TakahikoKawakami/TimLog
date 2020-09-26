<template>
<div v-if="showFlag">
    <div class="ticket-container vertical-container">
        <div class="ticket-element">
            <a class="ticket-element ticket-summary"><!-- v-on:click="addSelectTickets(ticket)"> -->
                <span class="ticket-title" v-text="text"></span>
            </a>
            <button
                class="ticket-edit ticket-open-icon"
                v-on:click="openModal()"
            >
                <ion-icon name="create-outline"></ion-icon>
            </button>
        </div>
        <div class="ticket-container right-container">
            <span>
                <timer-component
                    v-bind:second="deadlineSecond - runtimeSecond"
                    v-bind:status="status"
                    ref='timer'
                ></timer-component>
            </span>
            <span>
                <button
                    class="timer-btn"
                    v-if="status==0 || status == 2"
                    v-on:click="startTimer()"
                >
                    <ion-icon name="play-outline"></ion-icon>
                </button>
                <button
                    class="timer-btn"
                    v-if="status==1"
                    v-on:click="stopTimer()"
                >
                    <ion-icon name="pause"></ion-icon>
                </button>
            </span>
        </div>
    </div>
    <!-- <router-link v-bind:to="{ name: 'Ticket', params: { id: id }}">ボタン</router-link> -->

    <update-modal-component
        v-if="this.openModalFlag"
        v-bind:target-ticket="ticket"
        v-bind:new-create="ticket.newCreated"
        v-on:close-event="closeModal"
        v-on:remove-event="unshowTicket"
    ></update-modal-component>
</div>
</template>

<style lang='stylus' scoped>
    .ticket-edit {
        // display: none;
        border: none;  /* 枠線を消す */
        outline: none; /* クリックしたときに表示される枠線を消す */
        background: transparent; /* 背景の灰色を消す */
    }
    // .ticket-element:hover .ticket-edit {
    //     display: inline-block;
    // }
    .ticket-summary {
        font-size: 2rem;
    }
    .ticket-title {
        display: inline-block;
    }
    .ticket-container {
        display: flex;
    }
    .grid-container {
        display: grid;
        grid-template-rows: 100px 50px;
        grid-template-columns: 1fr 1fr 1fr;
        // grid-template-areas:
        //     " header header   header "
        //     " nav    contents aside  "
        //     " .....  footer   .....  ";
    }
    .grid-container .grid-item {
        // grid-row: 1;
        // grid-column: 2;
    }
    .left-container {
        justify-content: start;
    }
    .right-container {
        justify-content: flex-end;
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
    .timer-btn {
        display: inline-block;
        text-decoration: none;
        color: #668ad8;
        width: 36px;
        height: 36px;
        line-height: 36px;
        border-radius: 50%;
        border: solid 2px #668ad8;
        text-align: center;
        overflow: hidden;
        font-weight: bold;
        transition: .4s;
    }
    .timer-btn:hover {
        background: #b3e1ff;
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
    import DatePicker from '@/components/DatePicker.vue'
    import timerComponent from '@/components/TimerComponent.vue'
    import ticketViewComponent from '@/components/ticket/TicketViewComponent.vue'
    import ticketUpdateModalComponent from '@/components/ticket/modals/UpdateModalComponent.vue'
    import moment from 'moment-timezone'

    export default {
        components: {
            'date-picker': DatePicker,
            'timer-component': timerComponent,
            'ticket-view-component': ticketViewComponent,
            'update-modal-component': ticketUpdateModalComponent,
        },
        props: ['eachTicket', 'parentId'],
        data() {
            return {
                openModalFlag: false,
                openChildTicketFlag: false,
                showFlag: true,

                ticket: this.eachTicket,
                id: this.eachTicket.id,
                text: this.eachTicket.text,
                status: this.eachTicket.status,
                runStartDateTime: this.eachTicket.run_start_date_time,
                runStopDateTime: this.eachTicket.run_stop_date_time,
                memo: this.eachTicket.memo,
                startDateTime: this.eachTicket.start_date_time,
                endDateTime: this.eachTicket.end_date_time,
                deadlineSecond: this.eachTicket.deadline_second,
                runtimeSecond: Number(this.eachTicket.runtime_second),

            }
        },
        created() {
            moment.tz.setDefault('Asia/Tokyo');
            if (this.status == 1) {
                let nowDateTime = moment(moment().format("YYYY-MM-DD hh:mm:ss"));
                let lastRunStartDateTime = moment(this.runStartDateTime);
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
            if (this.status == 1) {
                this.$refs.timer.start();
            }
        },
        methods: {
            getTicket() {
                let self = this;
                let url = env.url + 'api/tickets/' + this.id;
                axios
                    .get(url)
                    .then(function(response) {
                        self.ticket.forEach((object, index) => {
                            self.$set(self.ticket[index])
                            if (object.name === 'test2-Name') {
                                this.$set(this.testObject[index], 'value', 'test2-Value')
                            }
                        })
                        self.$set(ticket, response.data);
                        console.log(response);
                    });
                console.log("storeTicket end  -------");
            },
            toggleChildList() {
                console.log("reqire parentId: " + this.ticket.id);
                this.$parent.parentId = this.ticket.id;
                this.openChildTicketFlag = !this.openChildTicketFlag;
            },
            openModal() {
                this.openModalFlag = true;
            },
            closeModal(updatedTicket) {
                this.setParams(updatedTicket);
                this.ticket = updatedTicket;
                this.openModalFlag = false;
            },
            setParams(updatedTicket) {
                this.id = updatedTicket.oid;
                this.text = updatedTicket.text;
                this.status = updatedTicket.status;
                this.runStartDateTime = updatedTicket.run_start_date_time;
                this.runStopDateTime = updatedTicket.run_stop_date_time;
                this.runtimeSecond = updatedTicket.runtime_second;
                this.memo = updatedTicket.memo;
                this.startDateTime = updatedTicket.start_date_time;
                this.endDateTime = updatedTicket.end_date_time;
                this.deadlineSecond = updatedTicket.deadline_second;
                this.runtimeSecond =  Number(updatedTicket.runtime_second);
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

                this.setParams(this.ticket);
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
                this.ticket.runtime_second = Number(this.ticket.runtime_second) + Number(diff);
                console.log("start: " + runStartDateTime + "ms");
                console.log("stop : " + runStopDateTime + "ms");
                console.log("diff: " + diff + "s");
                console.log("残: " + this.ticket.runtime_second + "s");

                this.setParams(this.ticket);
                this.updateTicket();
            },
            updateStartDateTime(newDate) {
                this.ticket.start_date_time = newDate;
                this.setParams(this.ticket);
                this.updateTicket();
            },
            updateEndDateTime(newDate) {
                this.ticket.end_date_time = newDate;
                this.setParams(this.ticket);
                this.updateTicket();
            },
            createTicket() {
                let url = env.url + "api/tickets";
                let now = Date.now();
                axios
                    .post(url, {
                        status: this.ticket.status,
                        text: this.ticket.text,
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
                console.log(this.startDateTime);
                let self = this;
                let url = env.url + "api/tickets/" + this.ticket.id;
                let now = moment(moment().format("YYYY-MM-DD hh:mm:ss"));
                axios
                    .put(url, {
                        start_date_time: this.startDateTime,
                        end_date_time: this.endDateTime,
                        deadline_second: this.deadlineSecond,
                        status: this.status,
                        run_start_date_time: moment(this.runStartDateTime).format("YYYY-MM-DD hh:mm:ss"),
                        run_stop_date_time: moment(this.runStopDateTime).format("YYYY-MM-DD hh:mm:ss"),
                        runtime_second: this.runtimeSecond,
                    })
                    .then(function(response) {
                        self.setParams(response.data);
                        console.log(response);
                    })
            },

            deleteTicket() {
                let url = env.url + "api/tickets/" + this.ticket.id;
                let now = Date.now();
                axios
                    .delete(url)
                    .then(function(response) {
                        console.log(response);
                    })
            },

            unshowTicket() {
                this.showFlag = false;
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

