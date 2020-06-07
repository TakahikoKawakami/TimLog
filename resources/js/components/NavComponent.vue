<template>
    <nav id="nav-drawer">
        <input id="nav-input" type="checkbox" class="nav-unshown">
        <label id="nav-open" for="nav-input"><span></span></label><span class="title">{{ ticketNum }}</span>
        <span v-on:click="getTickets('sample')"><button>get</button></span>
        <label id="nav-close" for="nav-input">close</label>
        <div id="nav-content">
            <ul class="main-nav">
                <li><a href="#">home</a></li>
                <li><a href="#">setting</a></li>
                <li><a href="#">how to use</a></li>
                <li><a href="#">logout</a></li>
            </ul>
        </div>
    </nav>
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
            results: [
            ]
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
            }
        }
    }
</script>
