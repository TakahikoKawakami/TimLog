<template>
    <div>
        <header>
    <!-- nav -->
            <header-component></header-component>
    <!-- nav -->
        </header>
        <hr>
        <router-view></router-view>
    </div>
</template>

<script>
    import HeaderComponent from '@/components/HeaderComponent.vue'
    export default {
        components: {
            'header-component': HeaderComponent,
        },
        methods: {
       }
    }

</script>
