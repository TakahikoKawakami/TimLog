<template>
    <div class="ticket-bar-wrapper">
        <span>
            <a href="#">
                <ion-icon name="home-outline"></ion-icon>
            </a>
        </span>
        <span v-for="ticket in selectTickets">
            <a href="#">
                <ion-icon name="chevron-forward-outline"></ion-icon>{{ ticket.text }}
            </a>
        </span>
        <span>
            <ion-icon name="chevron-down-outline"></ion-icon>
        </span>
    </div>
</template>

<script>
    export default {
        props: {
        },
        data(){
            return {
                selectTickets: {},
            }
        }
    }
</script>
