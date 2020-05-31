<template>
<p>test</p>
</template>

<script>
export default {
        name: "SampleComponent",
        data () {
            return {
                number: 0
            }
        },
        computed: {
            numberClasses: function () {
                return {
                    'positive': (this.number > 0),
                    'negative': (this.number < 0)
                }
            }
        },
        methods: {
            countDown: function () {
            this.number--
            },
            countUp: function () {
                this.number++
            }
        }
    }
</script>

