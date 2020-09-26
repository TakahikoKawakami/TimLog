<template>
    <div>
        <my-modal v-on:close-event="closeModal()">
            <template slot="title"><slot name="title"></slot></template>
            <template slot="body">
                <table class="">
                    <tr><td>チケット番号</td><td>{{ticket.id}}</td></tr>
    <!--                <tr><td>親チケット番号</td><td><input v-model="ticket.parent_id"></td></tr> -->
                    <tr><td>チケット名</td><td><input v-model="ticket.text"></td></tr>
                    <tr><td>予定工数</td><td><input v-model="ticket.deadline_second">[秒]</td></tr>
                    <!-- <tr><td>開始予定日</td><td><div v-on:click="openDatePicker('startDateTime')" v-text="ticket.start_date_time"></div></td></tr> -->
                    <!-- <tr><td>終了予定日</td><td><div v-on:click="openDatePicker('deadlineDate')" v-text="ticket.deadline_date"></div></td></tr> -->
                    <!-- <tr><td>計測開始日</td><td><input v-model="ticket.run_start_date_time"></td></tr>
                    <tr><td>計測停止日</td><td><input v-model="ticket.run_stop_date_time"></td></tr> -->
                    <!-- <tr><td>実行時間</td><td><input v-model="ticket.runtime_second"></td></tr> -->
                    <tr><td>メモ</td><td><input v-model="ticket.memo"></td></tr>
                    <!-- <tr><td>表示順</td><td><input v-model="ticket.display_sequence"></td></tr> -->
                </table>
            </template>
            <template slot="footer">
                <div class="group" style="text-align: right; flex-direction: row; justify-content: space-between;">
                    <slot name="remove-button"> </slot>
                    <slot name="save-button"> </slot>
                </div>
            </template>
        </my-modal>

        <my-modal
            v-show="datepicker.startDateTime"
            v-on:close-event="closeDatePicker('startDateTime')">
            <template slot="body">
                <date-picker
                    ref="startDateTime"
                    v-model="ticket.start_date_time"
                    v-bind:default-date="String(ticket.start_date_time)"
                    v-on:date-change-event="updateStartDateTime"
                ></date-picker>
            </template>
        </my-modal>
        <my-modal
            v-show="datepicker.deadlineDate"
            v-on:close-event="closeDatePicker('deadlineDate')">
            <template slot="body">
                <date-picker
                    ref="deadlineDate"
                    v-model="ticket.deadline_date"
                    v-bind:default-date="String(ticket.deadline_date)"
                    v-on:date-change-event="updateDeadlineDate"
                ></date-picker>
            </template>
        </my-modal>
    </div>
</template>

<script>
    import moment from 'moment-timezone'
    import DatePicker from '@/components/DatePicker.vue'
    import MyModal from '@/components/base/modal.vue'
    export default {
        name: 'ModalComponent',
        components: {
            'my-modal': MyModal,
            'date-picker': DatePicker,
        },
        props: ['targetTicket'],
        data(){
            return {
                ticketNum: 0,
                ticket: this.targetTicket,
                edit: false,
                results: [],
                datepicker: { "startDateTime": false, "deadlineDate": false },
            }
        },
        mounted() {
            this.ticket.start_date_time = moment(this.ticket.start_date_time).format("YYYY-MM-DD");
            this.ticket.deadline_date = moment(this.ticket.deadline_date).format("YYYY-MM-DD");
        },
        watch: {
            ticket: function(value) {
                console.log(value.start_date_time);
            },
        },
        methods: {
            closeModal() {
                this.$emit('close-event');
            },
            closeDatePickerModal() {
                this.datepicker = false;
            },
            updateStartDateTime(newDate) {
                this.ticket.start_date_time = newDate;
                this.closeDatePicker("startDateTime");
            },
            updateDeadlineDate(newDate) {
                this.ticket.deadline_date = newDate;
                this.closeDatePicker("deadlineDate");
            },
            openDatePicker: function(picker){
                this.datepicker[picker] = true;
                if(!this.$refs[picker].$refs.picker.isOpen) {
                    this.$refs[picker].$refs.picker.$el.querySelector("input").focus();
                    this.$refs[picker].$refs.picker.showCalendar();
                }
            },
            closeDatePicker: function(picker){
                if(this.$refs[picker].$refs.picker.isOpen) {
                    this.$refs[picker].$refs.picker.$el.querySelector("input").blur();
                    // this.$refs[picker].$refs.picker.close(true);
                }
                this.datepicker[picker] = false;
            }

        }
    }
</script>

