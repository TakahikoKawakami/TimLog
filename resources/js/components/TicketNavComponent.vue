<template>
    <div class="ticket-bar-wrapper">
        <span>
            <a href="#">
                <ion-icon name="home-outline"></ion-icon>
            </a>
        </span>
        <span v-for="ticket in selectTickets">
            <a href="#">
                <ion-icon name="chevron-forward-outline"></ion-icon>@{{ ticket.text }}
            </a>
        </span>
        <span>
            <ion-icon name="chevron-down-outline"></ion-icon>
        </span>
    </div>
</template>

<script>
    export default {
        async mounted() {
            const ret = await window.axios.get("/api/sample");
            this.name = ret.data.name;
        },
        data: {
            ticketNum: 0,
            selectTickets: [],
            childTickets: [
            { id: 1,
                parentId: -1,
                text: 'test ticket1',
                openFlag: false,
                time: '3.5H',
                createDateTime: '',
                updateDateTime: '',
            }
            ],
            edit: false,
            results: []
        },
        mounted () {
            this.getTickets('test');
        },
        methods: {
            getTickets(section) {
                let url = builderUri(section);
                axios.get(url).then((response) => {
                        this.results = response;
                }).catch( error => {console.log(error);});
            },
            addSelectTickets: function(ticket) {
                this.selectTickets.push({
                    id: ticket.id,
                    text: ticket.text,
                })
            },
        }
    }
</script>
