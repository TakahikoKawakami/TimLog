<template>
    <div align="center">
        <button class="btn btn-primary" v-on:click="createBros()">+</button>
    </div>
</template>

<script>
    export default {
        data: { },
        methods: {
            getTicket() {
                axios
                .get('https://ticket-timer.dev.apps.shaba-room.work/public/api/tickets')
                .then(response => (this.ticketNum = response))
            },
            createBros() {
                this.$emit('create-ticket-event');
            },
        }
    }
</script>
