<template>
    <nav id="nav-drawer">
        <h1>TimLog</h1>
        <nav-component></nav-component>
    </nav>
</template>

<script>
    import NavComponent from '@/components/NavComponent.vue';
    export default {
        components: {
            'nav-component': NavComponent,
        },
        data () {
            return {
                openFlag: false,
            }
        },
        computed: {
            isLogin: function(val) {
                this.getLiginState();
            },
        },
        methods: {
            logout() {
                axios.post('/api/logout').then(res => {
                    axios.defaults.headers.common['Authorization'] = '';
                    window.$cookies.set('access_token', '');
                    state.isLogin = false;
                    this.$router.push({path: '/login'});
                });
            },
            getLoginState() {
                console.log("login? : " + state.isLogin);
                return state.isLogin;
            },
            toggleFlag() {
                this.openFlag = !this.openFlag;
                console.log(this.openFlag);
            },
        }
    }
</script>
<style scoped>
        .menu-icon {
            font-size: 3rem;
        }

        /*--ハンバーガーメニュー--*/
</style>
