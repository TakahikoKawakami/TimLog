<template>
    <div>
        <header>
    <!-- nav
            <nav-component></nav-component> -->
    <!-- nav -->
        </header>
        <ul>
            <li><router-link to="/">ホーム</router-link></li>
            <li><router-link to="/login">ログイン</router-link></li>
            <li><router-link to="/register">登録</router-link></li>
            <li><router-link to="/user">ユーザー情報</router-link></li>
            <li
                @click="logout"
            >ログアウト</li>
        </ul>
        <hr>
        <router-view></router-view>
    </div>
</template>

<script>
    import navComponent from '@/components/NavComponent.vue'
    import ticketViewComponent from '@/components/ticket/TicketViewComponent.vue'
    import loginComponent from '@/components/auth/LoginComponent.vue'
    export default {
        components: {
            'nav-component': navComponent,
            'ticket-view-component': ticketViewComponent,
            'login-component': loginComponent,
        },
        methods: {
            logout() {
                axios.post('/api/logout').then(res => {
                    axios.defaults.headers.common['Authorization'] = '';
                    state.isLogin = false;
                    this.$router.push({path: '/login'});
                });
            }
        }
    }

</script>
