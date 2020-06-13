<template>
    <nav id="nav-drawer">
        <input id="nav-input" type="checkbox" class="nav-unshown">
        <label id="nav-open" for="nav-input"><span></span></label><span class="title">TicketTimer {{ ticketNum }}</span>
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
        data() {
            return {
                ticketNum: 'test'
            }
        },
    }
</script>
