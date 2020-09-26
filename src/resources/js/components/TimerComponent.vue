<template>
  <div id="timer">
    <div class="timer">
      <div class="time">
        {{ formatTime }}
      </div>
    </div>
  </div>
</template>

<script>

export default {
    name: 'timer',
    props: ['second', 'status'],

    data() {
        return {
        min:  parseInt(this.second / 60),
        sec: parseInt(this.second % 60),
        timerOn: this.status,
        timerObj: null,
        }
    },
    created() {
    },
    mounted() {

    },
    methods: {
        count: function() {
            if (this.sec <= 0 && this.min >= 1) {
                this.min --;
                this.sec = 59;
            } else if(this.sec <= 0 && this.min <= 0) {
                // this.complete();
                this.sec --;
            } else {
                this.sec --;
            }
        },

        start: function() {
        let self = this;
        this.timerObj = setInterval(function() {self.count()}, 1000)
        this.timerOn = true; //timerがOFFであることを状態として保持
        },

        stop: function() {
        clearInterval(this.timerObj);
        this.timerOn = false; //timerがOFFであることを状態として保持
        },

        complete: function() {
        clearInterval(this.timerObj)
        }
    },
    watch: {
        second: function(newSecond, oldSecond){
            this.min = parseInt(this.second / 60);
            this.sec = parseInt(this.second % 60);
            console.log('[timer component] Change second '+oldSecond+'[s] to '+newSecond+'[s]');
        },
    },
    computed: {
        formatTime: function() {
            let timeSignStr = '';
            if (this.min < 0 || this.sec < 0) {
                timeSignStr = '-';
            }
            let timeStrings = [
                this.min.toString(),
                this.sec.toString()
            ].map(function(str) {
                if (Math.abs(str).toString().length < 2) {
                    return "0" + Math.abs(str)
                } else {
                    return Math.abs(str)
                }
            })
            let signStr = '';
            if (timeStrings[0] * timeStrings[1] < 0) {
                signStr = '-';
                timeStrings[0] = Math.abs(timeStrings[0]);
                timeStrings[1] = Math.abs(timeStrings[0]);
            }

            return timeSignStr + timeStrings[0] + ":" + timeStrings[1]
        }
    }
}
</script>

<style scoped>
#timer {
  display: flex;
  align-items: center;
  justify-content: center;
}
.time {
  font-size: 24px;
}
</style>
