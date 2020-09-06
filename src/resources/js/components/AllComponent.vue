<template>
    <div>
        <header>
    <!-- nav
            <nav-component></nav-component> -->
    <!-- nav -->
        </header>
        <ticket-view-component></ticket-view-component>
    </div>
</template>

<script>
    import navComponent from '@/components/NavComponent.vue'
    import ticketViewComponent from '@/components/ticket/TicketViewComponent.vue'
    export default {
        components: {
            'nav-component': navComponent,
            'ticket-view-component': ticketViewComponent,
        }
    }

</script>
