<template>
    <vue-date-picker
        ref="picker"
        v-model="date"
        v-bind:format="DatePickerFormat"
        v-bind:inline="false"
        v-bind:bootstrap-styling="true"
        v-bind:language="ja"
        placeholder="日付を選択してください"
    ></vue-date-picker>
</template>

<script>
    import moment from 'moment-timezone'
    import VueDatepicker from 'vuejs-datepicker';
    export default {
        components: {
            'vue-date-picker': VueDatepicker,
        },
        props: {
            defaultDate: {
                type: String,         // 型の検査
                // default: '',  // 初期値
                required: true,       // 必須かどうか
            },
        },
        data() {
            return {
                date: this.defaultDate,
                DatePickerFormat: 'yyyy-MM-dd',
                ja: {
                    language: 'Japanese',
                    months: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                    monthsAbbr: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                    days: ['日', '月', '火', '水', '木', '金', '土'],
                    rtl: false,
                    ymd: 'yyyy-MM-dd',
                    yearSuffix: '年'
                }
            }
        },
        watch: {
            date: function(newDate, oldDate){
                // this.defaultDate = this.date;
                console.log('[date-picker component] Change second '+oldDate+' to '+newDate+'');
                let formattedDate = moment(this.date).format("YYYY-MM-DD");
                this.$emit('date-change-event', formattedDate);
            },
        },
    }
</script>

<style lang='stylus' scoped>
    .vdp-datepicker {
        // width: 10px !important;
    }
    .vdp-datepicker >>> .input-group {
        width: 80% !important;
        display:none !important;
    }
    .vdp-datepicker >>> .vdp-datepicker__calendar {
        width: 100% !important;
        position : relative !important;
    }
</style>

